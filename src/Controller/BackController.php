<?php

namespace App\Controller;

use App\Entity\Person;

use App\Form\PersonType;

use App\Repository\PersonRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{
  /**
   * @Route("/back", name="back_index", methods={"GET"})
   */
  public function index(): Response
  {
    return $this->render('back/index.html.twig', [
      'controller_name' => 'BackController',
    ]);
  }

  /**
   * @Route("/person", name="back_person", methods={"GET"})
   */
  public function personShowAll(PersonRepository $personRepository): Response
  {
    $persons = $personRepository->findAll();

    return $this->render('back/person.html.twig', [
      'persons' => $persons
    ]);
  }


  // MK -- Ici création & modification par une même action, avec ou sans {id}
  /**
   * @Route("/back/person/add", name="back_person_add", methods={"GET", "POST"})
   * @Route("/back/person/edit/{id}", name="back_person_edit", methods={"GET", "POST"})
   */
  public function personAdd(Person $person = null, Request $request, EntityManagerInterface $manager)
  {
    /**
     * 1. 
     *    Si c'est une création on crée une nouvelle instance (car $person = null)
     *    Si c'est une modification $person contient déjà les données
     */
    if (!$person) {
      $person = new Person();
    }

    // 2. on la passe en 2e argument au formulaire,
    // qui va automatiquement mapper les champs de f. avec les propriétés de l'objet
    $form = $this->createForm(PersonType::class, $person);

    $form->handleRequest($request);

    // 3. On traite le formulaire
    if ($form->isSubmitted() && $form->isValid()) {
      // traitement de formulaire...

      /**
       * 4.
       *    Si c'est une création $personne ne contient pas encore d'id et on doit persister la nouvelle instance
       *    Si c'est une modification on peut lire la p. $id
       */

      if (!$person->getId()) {
        $manager->persist($person);
      }

      $manager->flush();
      return $this->redirectToRoute('back_person');
    }

    // 4. On pass le formulaire à la vue
    return $this->render('back/person_add.html.twig', [
      'form' => $form->createView()
    ]);
  }
}