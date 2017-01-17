<?php

namespace Ojs\EndorsementBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Ojs\AdminBundle\Events\MergeEvent;
use Ojs\AdminBundle\Events\MergeEvents;
use Ojs\CoreBundle\Events\TwigEvent;
use Ojs\EndorsementBundle\Entity\UserEndorse;
use Ojs\EndorsementBundle\Entity\UserSkill;
use Ojs\JournalBundle\Service\JournalService;
use Ojs\JournalBundle\Entity\Journal;
use Ojs\CoreBundle\Events\TwigEvents;
use Ojs\UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Translation\TranslatorInterface;

class EndorsementEventListener implements EventSubscriberInterface
{
    /**
     * @var  ObjectManager
     */
    private $em;

    /**
     * @var  RouterInterface
     */
    private $router;

    /**
     * @var  JournalService
     */
    private $journalService;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @param ObjectManager   $em
     * @param RouterInterface $router
     * @param JournalService  $journalService
     */
    public function __construct(
        ObjectManager $em,
        RouterInterface $router,
        JournalService $journalService,
        TokenStorageInterface $tokenStorage,
        \Twig_Environment $twig,
        TranslatorInterface $translator
    )
    {
        $this->em               = $em;
        $this->router           = $router;
        $this->journalService   = $journalService;
        $this->tokenStorage     = $tokenStorage;
        $this->twig             = $twig;
        $this->translator       = $translator;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            TwigEvents::OJS_USER_PROFILE_EDIT_TABS          => 'onUserProfileEditTabs',
            TwigEvents::OJS_USER_PROFILE_PUBLIC_VIEW        => 'onUserProfilePublicView',
            TwigEvents::OJS_USER_PROFILE_PUBLIC_VIEW_SCRIPT => 'onUserProfilePublicViewScript',
            MergeEvents::OJS_ADMIN_USER_MERGE               => 'onAdminUserMerge',
            
        );
    }

    /**
     * @param TwigEvent $event
     */
    public function onUserProfileEditTabs(TwigEvent $event)
    {
        $isActive = $event->getOptions()['active_tab'] == 100 ? 'class="active"':'';
        $event->setTemplate('<li role="presentation" '.$isActive.'>'
            .'<a href="'.$this->router->generate('user_endorsement_skills').'">'.$this->translator->trans('title.skills').'</a>'
        .'</li>');
    }

    /**
     * @param TwigEvent $event
     */
    public function onUserProfilePublicView(TwigEvent $event)
    {
        $options = $event->getOptions();
        $token = $this->tokenStorage->getToken();
        /** @var User $currentUser */
        $currentUser = $token->getUser();
        $user = $options['user'];
        $template = '';
        $userSkills = $this->em->getRepository('OjsEndorsementBundle:UserSkill')->findBy([
            'user' => $user
        ]);
        if(!$currentUser instanceof User){
            $isCurrentUser = true;
        }else{
            $isCurrentUser = $currentUser->getId() == $user->getId() ? true: false;
        }
        $event->setTemplate($this->twig->render('OjsEndorsementBundle:Skill:skills.html.twig', [
            'userSkills' => $userSkills,
            'user' => $user,
            'isCurrentUser' => $isCurrentUser
        ]));
    }

    /**
     * @param TwigEvent $event
     */
    public function onUserProfilePublicViewScript(TwigEvent $event)
    {
        $options = $event->getOptions();
        $token = $this->tokenStorage->getToken();
        /** @var User $currentUser */
        $currentUser = $token->getUser();
        $user = $options['user'];
        if(!$currentUser instanceof User){
            $isCurrentUser = true;
        }else{
            $isCurrentUser = $currentUser->getId() == $user->getId() ? true: false;
        }
        $event->setTemplate($this->twig->render('OjsEndorsementBundle:Skill:skills_script.html.twig', [
            'isCurrentUser' => $isCurrentUser
        ]));
    }

    /**
     * @param MergeEvent $event
     * @return null
     */
    public function onAdminUserMerge(MergeEvent $event)
    {
        $primaryUser = $event->getPrimaryUser();
        if(!$primaryUser instanceof User){

            exit('1');
            return;
        }

        /** @var User[] $slaveUsers */
        $slaveUsers = $event->getSlaveUsers();
        if(!$slaveUsers){

            exit('2');
            return;
        }
        foreach ($slaveUsers as $slaveUser) {
            if($primaryUser->getId() == $slaveUser->getId() || !$slaveUser->getMerged()){

                exit('3');
                continue;
            }

            $this->migrateSkills($primaryUser, $slaveUser);
            $this->migrateEndorser($primaryUser,$slaveUser);
        }
        return;
    }

    /**
     * @param User $primaryUser
     * @param User $slaveUser
     */
    private function migrateSkills(User $primaryUser, User $slaveUser) 
    {
        /**  @var UserSkill[] $skills */
        $skills = $this->em->getRepository(UserSkill::class)->findBy(['user' => $slaveUser->getId()]);

        if(!$skills) {
            return;
        }
        foreach ($skills as $skill) {
            $haveSkill = $this->em->getRepository(UserSkill::class)->findBy(['user' => $primaryUser->getId(), 'skill' => $skill->getSkill()]);

            if(!$haveSkill)
            {
                $skill->setUser($primaryUser);
                $this->em->persist($skill);
            }
        }

    }

    /**
     * @param User $primaryUser
     * @param User $slaveUser
     */
    private function migrateEndorser(User $primaryUser, User $slaveUser)
    {
        /**  @var UserEndorse[] $userEndorsers */
        $userEndorsers = $this->em->getRepository(UserEndorse::class)->findBy(['endorser' => $slaveUser->getId()]);

        if(!$userEndorsers) {
            return;
        }
        $primaryUserEndorsers = $this->em->getRepository(UserEndorse::class)->findBy(['endorser' => $primaryUser->getId()]);

        foreach ($userEndorsers as $userEndorse) {
            if(!in_array($userEndorse, $primaryUserEndorsers))
            {
                $userEndorse->setEndorser($primaryUser);
                $this->em->persist($userEndorse);
            }
        }

    }

}
