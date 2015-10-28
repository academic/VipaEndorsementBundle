<?php

namespace OkulBilisim\EndorsementBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Ojs\CoreBundle\Events\TwigEvent;
use Ojs\JournalBundle\Service\JournalService;
use Ojs\JournalBundle\Entity\Journal;
use Ojs\CoreBundle\Event\WorkflowEvent;
use Ojs\CoreBundle\Events\TwigEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class EndorsementEventListener implements EventSubscriberInterface
{

    /** @var  ObjectManager */
    private $em;

    /** @var  RouterInterface */
    private $router;

    /** @var  JournalService */
    private $journalService;

    /**
     * @param ObjectManager   $em
     * @param RouterInterface $router
     * @param JournalService  $journalService
     */
    public function __construct(ObjectManager $em, RouterInterface $router, JournalService $journalService)
    {
        $this->em = $em;
        $this->router = $router;
        $this->journalService = $journalService;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            TwigEvents::OJS_USER_PROFILE_EDIT_TABS => 'onUserProfileEditTabs',
        );
    }

    /**
     * @param TwigEvent $event
     */
    public function onUserProfileEditTabs(TwigEvent $event)
    {
        $isActive = $event->getOptions()['activeTab'] == 5 ? 'class="active"':'';
        $event->setTemplate('<li role="presentation" '.$isActive.'>'
            .'<a href="'.$this->router->generate('user_endorsement_skills').'">skills</a>'
        .'</li>');
    }
}
