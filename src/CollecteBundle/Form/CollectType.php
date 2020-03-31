<?php

namespace CollecteBundle\Form;

use CollecteBundle\Entity\CategorieCollect;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomCollecte')
                ->add('budgetCollecte', NumberType::class)
                ->add('descriptionCollecte', TextareaType::class)
                ->add('categorieCollect', EntityType::class, array(
                    'class' => CategorieCollect::class,
                    'choice_label' => 'typeCategorie'
                ))
                ->add('imageFile',VichImageType::class
                );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CollecteBundle\Entity\Collect'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'collectebundle_collect';
    }


}
