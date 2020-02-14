<?php

namespace FiThnitekBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')->add('dateDebut')->add('dateFin')->add('description')
            ->add('promotion')->add('etat')
            ->add('image','Symfony\Component\Form\Extension\Core\Type\FileType')
            ->add('Ajouter',SubmitType::class);
    }


}
