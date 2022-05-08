<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Person;

use App\Form\TeamType;
use App\Form\PersonType;


use App\Repository\PersonRepository;
use App\Repository\TeamRepository;
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
   * @Route("/team", name="back_team", methods={"GET", "POST"})
   */
  public function teamShowAll(TeamRepository $teamRepo, PersonRepository $personRepo, Request $request, EntityManagerInterface $em): Response
  {

    $team = new Team();
    // on affecte la valeur de '$members' en allant compter le nb de personnes reliées au team
    $team->setMembers(count($team->getPersons()));

    $form = $this->createForm(TeamType::class, $team);

    $form->handleRequest($request);

    // ### traitement de formulaire
    if ($form->isSubmitted() && $form->isValid()) {
      $em->persist($team);
      $em->flush();

      $this->redirectToRoute('back_team');
    }

    /**
     * on met à jour les compteurs des membres
     */

    $teams = $teamRepo->findAll();

    // $counter = [];
    foreach ($teams as $team) {
      // $counter[$team->getId()] = count($personRepo->findBy(['team' => $team->getId()]));

      /**
       * À chaque fois que cette page est affichée,
       * on met à jour les compteurs dans la BDD
       */
      // $team->setMembers(count($personRepo->findBy(['team' => $team->getId()])));
      // $em->flush();
    }

    return $this->render('back/team.html.twig', [
      'teams' => $teams,
      'form' => $form->createView(),
      // 'counter' => $counter,
    ]);
  }

  //
  /**
   * @Route("/person", name="back_person", methods={"GET"})
   */
  public function personShowAll(PersonRepository $personRepository): Response
  {
    // $persons = $personRepository->findAll();
    $persons = $personRepository->findAllOrderByTeam();

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


/**
 * Argument 1 passed to Doctrine\ORM\Persisters\Entity\BasicEntityPersister::getSelectConditionStatementColumnSQL() 
 * 
 * must be of the type string, 
 * 
 * int given, called in /Applications/MAMP/htdocs/symfony22/udes/blog/vendor/doctrine/orm/lib/Doctrine/ORM/Persisters/Entity/BasicEntityPersister.php on line 1627
 */