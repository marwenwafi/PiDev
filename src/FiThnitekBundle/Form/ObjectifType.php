<?php

namespace FiThnitekBundle\Form;

use FOS\UserBundle\Event\FormEvent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjectifType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')
            ->add('description')
            ->add('start_date')
            ->add('end_date')
            ->add('type', ChoiceType::class,
                array("choices"=>["Nombre Utilisateurs"=>"Nombre Utilisateurs",
                "Revenues Taxi"=>"Revenues Taxi",
                "Activite Taxi"=>"Activite Taxi",
                "Revenues Covoiturage"=>"Revenues Covoiturage",
                "Activite Covoiturage"=>"Activite Covoiturage",
                "Revenues Colis"=>"Revenues Colis",
                "Activites Colis"=>"Activite Colis",
                "Revenues Totales"=>"Revenues Totales",
                "Activites Totales"=>"Activites Totales"]))
            ->add('but')
            ->add($options["label"],SubmitType::class);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FiThnitekBundle\Entity\Objectif'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fithnitekbundle_objectif';
    }


}
