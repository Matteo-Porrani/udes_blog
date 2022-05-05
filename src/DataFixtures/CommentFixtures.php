<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {


    for ($i = 1; $i <= 10; $i++) {

      $comment = new Comment();
      $comment->setContenu("On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page");
      $comment->setAuthor("Bruno Dumont");
      $comment->setDateComment(new \DateTime());
      $comment->setArticle($this->getReference('article-1'));

      $manager->persist($comment);
    }

    $manager->flush();
  }

  public function getDependencies()
  {
    return [
      ArticleFixtures::class
    ];
  }
}