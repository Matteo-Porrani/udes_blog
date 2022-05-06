<?php

namespace App\Controller;


use App\Entity\Book;
use App\Repository\BookRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LearnController extends AbstractController
{
  /**
   * @Route("/learn", name="learn_index", methods={"GET"})
   */
  public function index(BookRepository $bookRepository): Response
  {

    // get all the books
    $books = $bookRepository->findAll();

    return $this->render('learn/index.html.twig', [
      'books' => $books,
    ]);
  }


  /**
   * @Route("/learn/tutorials", name="learn_tutorials", methods={"GET"})
   *
   */
  public function tutorials(): Response
  {

    return $this->render('learn/tutorials.html.twig', [
      'test' => 'it works'
    ]);
  }


  /**
   * @Route("/learn/books", name="learn_books", methods={"GET"})
   *
   */
  public function books(BookRepository $bookRepository, Request $request): Response
  {

    // dump($request);
    // die;

    $action = $request->query->get('action');

    $method = $request->getMethod();


    $books = $bookRepository->findAll();

    return $this->render('learn/books.html.twig', [
      'books' => $books,
      'method' => $method,
      'action' => $action,
    ]);
  }

  /**
   * @Route("/learn/books/{id}", name="learn_books_detail", methods={"GET"})
   *
   * @param BookRepository $bookRepository
   * @return Response
   */
  public function books_detail(Book $book): Response
  {

    // dump($book);
    // die;

    return $this->render('learn/books_detail.html.twig', [
      'book' => $book
    ]);
  }
}