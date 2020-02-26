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

class ConvertirType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Points',ChoiceType::class, [
            'choices' => [



                '1000' => '1000',
                '5000' => '5000',
                '10000' => '10000',


            ],
        ])

            ->add('Cadeaux',ChoiceType::class, [
                'choices' => [


                        '5 tickets de 1dt' => '5 tickets de 1dt',
                         '28 tickets de 1dt' => '28 tickets de 1dt',
                         '60 tickets de 1dt' => '60 tickets de 1dt',




                ],
            ])



            ->add('Modifier',SubmitType::class,[
                'attr' => ['formnovalidate' => 'formnovalidate']
            ]);
    }


}
