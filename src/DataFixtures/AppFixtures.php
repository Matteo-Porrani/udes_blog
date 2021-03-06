<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Book;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    // ### original code
    // $product = new Product();
    // $manager->persist($product);


    /*
    for ($i = 0; $i < 5; $i++) {

      $book = new Book();

      $faker = Faker\Factory::create('fr_FR');
      // we can now access Factory methods through $faker

      $lsName = $faker->lastName;
      $fsName = $faker->firstName;

      $book->setTitle($faker->sentence($nbWords = 5, $variableNbWords = true));
      $book->setAuthor($lsName . ' ' . $fsName);
      $book->setSummary($faker->sentence($nbWords = 20, $variableNbWords = true));

      $day = $faker->numberBetween($min = 1, $max = 31);
      $month = $faker->numberBetween($min = 1, $max = 12);
      $year = $faker->numberBetween($min = 1900, $max = 2022);

      $book->setDatePublish(new \DateTime("{$year}-{$month}-{$day}"));
      // $book->setDatePublish(new \DateTime("1999-06-01"));

      $manager->persist($book);
    }
    */

    /*
    $admin = new User();

    $admin->setEmail('admin@admin.com');
    $admin->setPassword('$2y$13$HL0jOB.k9YZS5l.xhcl4L.NItg0yKXqJfBXvGzCNq30gAPhuLn/4y');
    $admin->setRoles(['ROLE_ADMIN']);

    $manager->persist($admin);
    */


    $user = new User();

    $user->setEmail('beta@mail.com');
    $user->setPassword('$2y$13$3rXedg90r5fpg23rhBYQYOIR8fZXsORuj1/JsS824qmpkxU3x..4u');
    $user->setRoles(['ROLE_USER']);

    $manager->persist($user);



    $manager->flush();
  }
}