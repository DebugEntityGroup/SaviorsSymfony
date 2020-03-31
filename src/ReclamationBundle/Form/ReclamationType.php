<?php

namespace ReclamationBundle\Form;

use ReclamationBundle\Entity\Raisons;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ReclamationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('objet')
            ->add('description', TextareaType::class)
            ->add('dateReclamation' )
            ->add('raisons' , EntityType::class, array(
        'class' => Raisons::class,
        'choice_label' => 'TypeRaison'))
            ->add('imageFile',VichImageType::class)
            ->add('captcha', CaptchaType::class)

            ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ReclamationBundle\Entity\Reclamation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'reclamationbundle_reclamation';
    }


}
