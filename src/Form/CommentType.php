<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('contenu', null, [
        'label' => 'Votre commentaire',
      ])
      ->add('author', null, [
        'label' => 'Votre nom',
      ])
      ->add("condition", CheckboxType::class, [  // ici on ajoute un champ qui n'existe pas dans l'entité
        'label' => "J'accepte les conditions",
        'mapped' => false,    // on précise que le champ n'est pas 'mappé' avec l'objet
        'required' => true,
      ]);
    // ->add('dateComment'); // la date est ajouté automatiquement par __construct() de 'Comment' Entity
    // ->add('article');
    /**
     * On n'a pas besoin du champ 'article' car le formulaire ajout commentaire
     * est déjà affiché dans la page d'un article spécifique
     */
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Comment::class,
    ]);
  }
}