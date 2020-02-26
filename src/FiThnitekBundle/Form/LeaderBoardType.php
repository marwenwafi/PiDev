<?php

namespace FiThnitekBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class LeaderBoardType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')
                ->add('description')
                ->add('size')
                ->add('start_date')
                ->add('end_date')
                ->add('category',EntityType::class, array('class'=>'FiThnitekBundle:Category','choice_label' => 'title'))
                ->add('color')
                ->add('imageFile', VichFileType::class, array(
                    'required'      => false,
                    'allow_delete'  => true, // not mandatory, default is true
                    'download_link' => true, // not mandatory, default is true
                ))
                ->add($options["label"],SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FiThnitekBundle\Entity\LeaderBoard'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fithnitekbundle_leaderboard';
    }


}
