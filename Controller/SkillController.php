<?php

namespace OkulBilisim\EndorsementBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use OkulBilisim\EndorsementBundle\Entity\UserSkill;
use OkulBilisim\EndorsementBundle\Form\Type\SkillType;
use Ojs\CoreBundle\Controller\OjsController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;

class SkillController extends Controller
{
    /**
     * Change user password
     *
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getEntityManager();
        $userSkills = $em->getRepository('EndorsementBundle:UserSkill')->findBy([
            'user' => $this->getUser()
        ]);

        $skillAddForm = $this->createCreateForm();
        return $this->render('EndorsementBundle:Skill:index.html.twig', [
            'userSkills' => $userSkills,
            'skillAddForm' => $skillAddForm->createView()
        ]);
    }

    /**
     * @return Form
     */
    private function createCreateForm()
    {
        $form = $this->createForm(
            new SkillType(),
            null,
            array(
                'action' => $this->generateUrl('user_endorsement_skills_add'),
                'method' => 'POST',
                'user' => $this->getUser()
            )
        );
        return $form;
    }

    /**
     * @param UserSkill $entity
     */
    public function removeAction(UserSkill $entity)
    {
        $this->throw404IfNotFound($entity);
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this->successFlashBag('successful.remove');
        return $this->redirectToRoute('user_endorsement_skills');
    }

    /**
     * @param Request $request
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $form = $this->createCreateForm();
        $form->handleRequest($request);
        $userSkill = new UserSkill();
        $userSkill
            ->setSkill($form->getData()['skills'])
            ->setUser($this->getUser())
            ->setEndorsementCount(0)
            ;
        $em->persist($userSkill);
        $em->flush();

        $this->successFlashBag('success.create');
        return $this->redirectToRoute('user_endorsement_skills');
    }
}
