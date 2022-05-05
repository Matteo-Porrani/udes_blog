<?php

namespace App\Service;

use App\Entity\Comment;

class VerificationComment
{
  /**
   * Function de vérification de vulgarité
   *
   * @param Comment $comment
   * @return boolean
   */
  public function commentaireNonAutorise(Comment $comment): bool
  {
    $nonAutorise = [
      "mauvais",
      "merde",
      "pourri",
    ];

    foreach ($nonAutorise as $word) {
      if (strpos($comment->getContenu(), $word)) {
        return true;
      }
    }
    return false;
  }
}