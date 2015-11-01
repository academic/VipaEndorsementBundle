<?php

namespace OkulBilisim\EndorsementBundle\Controller;

use Ojs\CoreBundle\Controller\OjsController as Controller;
use OkulBilisim\EndorsementBundle\Entity\Skill;
use OkulBilisim\EndorsementBundle\Entity\UserEndorse;
use OkulBilisim\EndorsementBundle\Entity\UserSkill;
use OkulBilisim\EndorsementBundle\Form\Type\SkillType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $em = $this->getDoctrine()->getManager();
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
        $skillNameOrId = $request->request->get('okul_bilisim_endorsementbundle_skill')['skills'];
        $em = $this->getDoctrine()->getManager();
        if(!(int)$skillNameOrId){
            $skill = new Skill();
            $skill->setName($skillNameOrId);
            $em->persist($skill);
            $em->flush();
        }else{
            $skill = $em->getRepository("EndorsementBundle:Skill")->find($skillNameOrId);
            $this->throw404IfNotFound($skill);
        }
        $userSkill = new UserSkill();
        $userSkill
            ->setSkill($skill)
            ->setUser($this->getUser())
            ->setEndorsementCount(0)
            ;
        $em->persist($userSkill);
        $em->flush();

        $this->successFlashBag('success.create');
        return $this->redirectToRoute('user_endorsement_skills');
    }

    /**
     * @param Request $request
     * @param UserSkill $userSkill
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function endorseUserAction(Request $request, UserSkill $userSkill)
    {
        $em = $this->getDoctrine()->getManager();
        $endorserUser = $this->getUser();
        $endorseUser = new UserEndorse();
        $endorseUser
            ->setEndorser($endorserUser)
            ->setUserSkill($userSkill)
            ;
        $userSkill->setEndorsementCount(1 + $userSkill->getEndorsementCount());
        $em->persist($endorseUser);
        $em->flush();
        $this->successFlashBag('success.create');
        return $this->redirectToRoute('ojs_user_profile', [
            'slug' => $userSkill->getUser()->getUsername()
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autoCompleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $skillRepo = $em->getRepository("EndorsementBundle:Skill");
        $userSkillRepo = $em->getRepository("EndorsementBundle:UserSkill");
        $userSkills = $userSkillRepo->findBy([
            'user' => $this->getUser()
        ]);
        $userSkillIds = [];
        $userSkillNames = [];
        /** @var UserSkill $userSkill */
        foreach($userSkills as $userSkill){
            $userSkillIds[] = $userSkill->getSkill()->getId();
            $userSkillNames[] = $userSkill->getSkill()->getName();
        }
        $skills = $skillRepo->createQueryBuilder('s')
            ->where('s.name LIKE :skill')
            ->setParameter('skill', '%'.$request->get('q').'%')
            ->getQuery()
            ->getResult();
        $data = [];
        /** @var Skill $skill */
        foreach ($skills as $skill) {
            if(!in_array($skill->getId(), $userSkillIds)){
                $data[] = [
                    'id' => (int)$skill->getId(),
                    'text' => $skill->getName(),
                ];
            }
        }
        if(count($data) == 0 && !in_array($request->get('q'), $userSkillNames)) {
            $data[] = [
                'id' => (string)$request->get('q'),
                'text' => $request->get('q')
            ];
        }

        return new JsonResponse($data);
    }
}
