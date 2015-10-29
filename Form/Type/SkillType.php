<?php

namespace OkulBilisim\EndorsementBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Ojs\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkillType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        $builder
            ->add(
                'skills',
                'tetranz_select2entity',
                [
                    'remote_route' => 'user_endorsement_skill_autocomplete',
                    'label' => 'skill',
                    'class' => 'OkulBilisim\EndorsementBundle\Entity\Skill',
                    'label' => 'select.skill',
                    'attr' => [
                        'class' => 'select2-element',
                        'placeholder' => 'journal.switch',
                    ]
                ]
            )
            ->add('add', 'submit')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'cascade_validation' => true,
                'user' => new User()
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'okul_bilisim_endorsementbundle_skill';
    }
}
