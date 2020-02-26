<?php

namespace FiThnitekBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionnaireType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('question',TextareaType::class)->add('reponse1')->add('reponse2')

            ->add('Ajouter',SubmitType::class,[
                'attr' => ['formnovalidate' => 'formnovalidate']
            ])
            ->add('Plus', SubmitType::class, array(
                'label' => 'Ajouter une nouvelle question',
                'attr'  => array(
                    'class' => 'btn btn-dark'
                )));



    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FiThnitekBundle\Entity\Questionnaire'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fithnitekbundle_questionnaire';
    }


}
