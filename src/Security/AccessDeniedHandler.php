<?php

// src/Security/AccessDeniedHandler.php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccessDeniedHandler extends AbstractController implements AccessDeniedHandlerInterface
{
  public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
  {
    // ...

    // $response = new Response();

    // $response->setContent('<h1>Cette section est réservée !</h1><a href=" / ">Accueil</a>');
    // $response->setStatusCode(403);

    // return $response;

    // return $this->redirectToRoute('app_login');
    return $this->render('security/forbidden.html.twig');
  }
}