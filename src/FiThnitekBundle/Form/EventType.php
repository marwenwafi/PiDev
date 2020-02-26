<?php

namespace FiThnitekBundle\Form;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')->add('dateDebut')->add('dateFin')->add('description')
            ->add('promotion')
            ->add('url',UrlType::class)
            ->add('image','Symfony\Component\Form\Extension\Core\Type\FileType')
            ->add('operation',ChoiceType::class, [
                'choices' => [


                        'Questionnaire' => 'Questionnaire',
                         'Publicité' => 'Publicité',


                ],
            ])
            //->add('destinataires', CollectionType::class, [
            //            'entry_type' => LeasingArcadeType::class,
            //            'allow_add' => false,
            //        ]);)
                /*
            ->add('destinataires', EntityType::class, [
            'class' => User::class,
            'placeholder' => 'Choose User',
            'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('u')
            ->orderBy('u.prenom ', 'DESC');
            },
            'choice_label' => 'prenom ',
            'multiple'=>true,
            'expanded'=>false,
            'by_reference' => false,
            ])*/


            ->add('reset', ResetType::class, array(
                'label' => 'Annuler',
                'attr'  => array(
                    'class' => 'btn btn-danger'
                )))
            ->add('Ajouter',SubmitType::class,[
                'attr' => ['formnovalidate' => 'formnovalidate']
            ]);
    }


}
