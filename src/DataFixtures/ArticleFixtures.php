<?php

namespace App\DataFixtures;

use App\Entity\Article;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {

    // for ($i = 1; $i <= 10; $i++) {
    //   $article = new Article();
    //   $article->setTitre("Le titre de l'article N°" . $i);
    //   $article->setContenu("Lorem ipsum dolor sit amet consectetur, adipisicing elit. Praesentium modi recusandae quibusdam expedita quos est quis, rem beatae animi minus fuga magnam nihil facere saepe eaque cum enim aspernatur provident!");

    //   $date = new \DateTime();
    //   $date->modify('+' . $i * 21 . ' days');

    //   $article->setDateCreation($date);

    //   $this->addReference('article-' . $i, $article);

    //   $manager->persist($article);
    // }

    // $manager->flush();
  }
}