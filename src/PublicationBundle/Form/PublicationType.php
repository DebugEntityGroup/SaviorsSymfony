<?php

namespace PublicationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationType extends AbstractType
{
  /**
   * {@inheritdoc}
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      -> add('titre')
      -> add('description')
      -> add('video')
      -> add('brochure', FileType::class, [
        'label'    => 'Upload Image',

        // unmapped means that this field is not associated to any entity property
        'mapped'   => false,

        // make it optional so you don't have to re-upload the PDF file
        // every time you edit the Product details
        'required' => false,
      ]);
  }

  /**
   * {@inheritdoc}
   */
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver -> setDefaults([
                               'data_class' => 'PublicationBundle\Entity\Publication',
                             ]);
  }

  /**
   * {@inheritdoc}
   */
  public function getBlockPrefix()
  {
    return 'publicationbundle_publication';
  }


}
