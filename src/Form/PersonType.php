<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PersonType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('ls_name', null, [
        'attr' => [
          'placeholder' => 'Renseignez votre nom de famille',
        ],
      ])
      ->add('fs_name', null, [
        'attr' => [
          'placeholder' => 'Renseignez votre prénom'
        ]
      ])
      ->add('email', EmailType::class, [
        // l'argument 'help' permet d'afficher un texte d'aide
        // avec la f. {{ form_help() }}
        'help' => 'Merci de saisir une adresse mail valide'
      ])
      ->add('notes', TextareaType::class, [
        'attr' => [
          'rows' => 5
        ]
      ])
      ->add('confirmed', CheckboxType::class, [ // ceci est un champ de type bool, géré avec une checkbox
        'required' => false,
        'data' => true
      ])
      ->add('Enregistrer', SubmitType::class);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Person::class,
    ]);
  }
}