<?php

namespace PublicationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentairePType extends AbstractType
{
  /**
   * {@inheritdoc}
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      -> add('description')
      ;
  }
  /**
   * {@inheritdoc}
   */
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver -> setDefaults([
                               'data_class' => 'PublicationBundle\Entity\CommentaireP',
                             ]);
  }

  /**
   * {@inheritdoc}
   */
  public function getBlockPrefix()
  {
    return 'publicationbundle_commentaireP';
  }


}
