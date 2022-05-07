<?php

namespace App\Form;

use App\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('name', null, [
        'label' => 'Nom'
      ])
      ->add('color', ColorType::class, [
        'label' => 'Couleur'
      ])
      ->add('level', ChoiceType::class, [
        'choices' => [
          'débutant' => 'DEB',
          'intermédiaire' => 'INT',
          'champion' => 'CHA'
        ],
        // en ajoutant ces 2 options supplémentaires on affiche le champ comme radio buttons
        // 'expanded' => true,
        // 'multiple' => false
        // see more [https://symfony.com/doc/5.4/reference/forms/types/choice.html#example-usage]
      ])
      ->add('active')
      ->add('members', null, [
        'attr' => [
          'readonly' => true
        ]
      ])
      ->add('submit', SubmitType::class, []);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Team::class,
    ]);
  }
}