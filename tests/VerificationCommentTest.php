<?php

namespace App\Tests;

use App\Entity\Comment;
use App\Service\VerificationComment;
use PHPUnit\Framework\TestCase;

class VerificationCommentTest extends TestCase
{

  protected $comment;

  // Ici on prépare le test et on crée une instance de 'Comment'
  protected function setUp(): void
  {
    $this->comment = new Comment();
  }


  public function testContientMotInterdit(): void
  {

    $service = new VerificationComment();

    // Ici on affecte une valeur spécifique à '$commentaire->contenu'
    $this->comment->setContenu('ceci est un commentaire pourri');
    $result = $service->commentaireNonAutorise($this->comment);

    $this->assertTrue($result);
    $this->assertIsBool($result);
    /**
     * On peut aussi ajouter d'autres assertions à la suite
     * et tester plusieurs conditions...
     */
  }

  public function testNeContientPasMotInterdit(): void
  {

    $service = new VerificationComment();

    // Ici on affecte une valeur spécifique à '$commentaire->contenu'
    $this->comment->setContenu('ceci est un commentaire propre');
    $result = $service->commentaireNonAutorise($this->comment);

    $this->assertFalse($result);
  }
}