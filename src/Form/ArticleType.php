<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ArticleType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {

    /**
     * Ce builder prend en compte les types déclarés pour les propriétés de l'Entity
     * et utilise les éléménts de formulaire correspondants
     */

    $builder
      ->add('titre', null, [
        'attr' => [
          'placeholder' => 'Ajoutez votre titre'
        ]
      ])
      ->add('contenu')
      ->add('dateCreation', null, [
        'widget' => 'single_text'
      ])
      ->add('categories', EntityType::class, [
        'class' => Category::class,
        'multiple' => true,
        'by_reference' => false, // >>> TRÈS IMPORTANT !!!
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Article::class,
    ]);
  }
}