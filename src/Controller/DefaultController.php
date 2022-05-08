<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;

use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Service\VerificationComment;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class DefaultController extends AbstractController
{
  /**
   * @Route("/", name="liste_articles", methods={"GET"})
   */
  public function listeArticles(ArticleRepository $articleRepository): Response
  {

    $articles = $articleRepository->findAll();
    // NEW

    // $searchDate = new \DateTime('2022-10-01');
    // $articles = $articleRepository->findByDateCreation($searchDate);

    return $this->render('default/index.html.twig', [
      'articles' => $articles,
    ]);
  }

  /**
   * @Route("/{id}", name="vue_article", requirements={"id"="\d+"}, methods={"GET", "POST"})
   */
  public function vueArticle(
    ArticleRepository $articleRepository,
    int $id,
    Request $request,
    EntityManagerInterface $manager,
    VerificationComment $verifService,
    FlashBagInterface $session
  ): Response {

    $article = $articleRepository->find($id);
    /**
     * Cette page va afficher un form pour ajouter un commentaire
     */

    $comment = new Comment();
    $comment->setArticle($article);

    $form = $this->createForm(CommentType::class, $comment);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      // Vérification du contenu du commentaire avant enregistrement

      if ($verifService->commentaireNonAutorise($comment) ===  false) {
        $manager->persist($comment);
        $manager->flush();

        return $this->redirectToRoute("vue_article", ['id' => $article->getId()]);
      } else {
        $session->add('danger', 'Le commentaire contient un mot interdit');
      }
    }


    return $this->render('default/vue.html.twig', [
      'article' => $article,
      'form' => $form->createView(),
    ]);
  }


  /**
   * @Route("/article/ajouter", name="ajout_article")
   * @Route("/article/{id}/edition", name="edition_article", requirements={"id"="\d+"}, methods={"GET", "POST"})
   */
  public function ajouter(Article $article = null, Request $request, EntityManagerInterface $manager, LoggerInterface $logger)
  {
    /**
     * Ici on utilise ParamConverter, c'est à dire qu'on passe une instance d'Article comme 1er argument
     * qui sera utilisée pour faire le lien avec {id} passé en paramètre et trouver l'objet correspondant.
     * 
     * Dans cette méthode on gère 2 routes différentes, et seulement "/article/{id}/edition" a besoin de ce paramètre.
     * C'est pourquoi on affecte la valeur par défaut '$article = null'.
     * 
     * Ensuite on utilise la logique là où c'est nécessaire pour différencier les 2 cas.
     */
    if ($article === null) {
      // on crée une nouvelle instance
      $article = new Article();
    }

    $logger->info('Nous sommes passés par le logger');

    // on la passe en 2e argument au formulaire
    // et le f. va qutomatiquement mapper les champs de f. avec les p. de l'objet
    $form = $this->createForm(ArticleType::class, $article);

    $form->handleRequest($request);

    // Traitement de formulaire
    if ($form->isSubmitted() && $form->isValid()) {

      if ($article->getId() === null) {
        $manager->persist($article);
      }

      $manager->flush();

      return $this->redirectToRoute("liste_articles");
    }

    // render de la vue
    return $this->render('default/ajout.html.twig', [
      'form' => $form->createView()
    ]);
  }

  // MK -- non utilisée
  /**
   * @Route("/article/ajouteralt", name="ajout_articlealt")
   */
  public function ajouterAlt(Request $request, CategoryRepository $categoryRepository, EntityManagerInterface $manager)
  {
    /**
     * Création du FORMULAIRE dans le controller
     * 
     * On utilise la méthode createFormBuilder() du parent
     */

    $form = $this->createFormBuilder()
      ->add('titre', TextType::class, [
        'label' => "Titre de l'article"
      ])
      ->add('contenu', TextareaType::class)
      ->add('dateCreation', DateType::class, [
        'widget' => 'single_text',
        'input' => 'datetime'
      ])
      ->getForm();


    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $article = new Article;

      $article->setTitre($form->get('titre')->getData());
      $article->setContenu($form->get('contenu')->getData());
      $article->setDateCreation($form->get('dateCreation')->getData());

      $category = $categoryRepository->findOneBy([
        'name' => 'Sport'
      ]);

      $article->addCategory($category);

      $manager->persist($article);

      $manager->flush();

      return $this->redirectToRoute('liste_articles');
    }

    return $this->render('default/ajout.html.twig', [
      'form' => $form->createView()
    ]);
  }

  /**
   * @Route("/article/{id}/delete", name="suppression_article")
   */
  public function deleteArticle(Article $article, EntityManagerInterface $manager): Response
  {
    $manager->remove($article);
    $manager->flush();

    return $this->redirectToRoute('liste_articles', []);
  }

  /**
   * @Route("/categorie/ajouter", name="ajout_categorie")
   */
  public function ajouterCategorie(Request $request, EntityManagerInterface $manager)
  {
    // Création du formulaire
    $form = $this->createFormBuilder()
      ->add('name', TextType::class, [
        'label' => "Nom de la catégorie"
      ])
      ->getForm();

    // Traitement du formulaire
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $category = new Category();
      $category->setName($form->get('name')->getData());

      $manager->persist($category);

      $manager->flush();

      return $this->redirectToRoute('liste_articles');
    }

    // Render du formulaire
    return $this->render('default/ajoutCategory.html.twig', [
      'form' => $form->createView()
    ]);
  }
}
