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

class Event2Type extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')->add('dateDebut')->add('dateFin')->add('description')
            ->add('promotion')

            ->add('url',UrlType::class)

            ->add('operation',ChoiceType::class, [
                'choices' => [


                        'Questionnaire' => 'Questionnaire',
                         'Publicité' => 'Publicité',


                ],
            ])



            ->add('Modifier',SubmitType::class,[
                'attr' => ['formnovalidate' => 'formnovalidate']
            ]);
    }


}
