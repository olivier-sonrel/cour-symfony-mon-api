<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        $users = [];
        for($i=0; $i < 50; $i++){
            $user = new User();
            $user->setUsername($faker->name);
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setEmail($faker->email);
            $user->setPassword($faker->password());
            $user->setCreatedAt(new \DateTime());
            $manager->persist($user);
            $users[] = $user;
        }

        $categories = [];
        for($i=0; $i < 15; $i++){
            $category = new Category();
            $category->setTitle($faker->text(50));
            $category->setDescription($faker->text(250));
            $manager->persist($category);
            $categories[] = $category;
        }

        $articles = [];
        for($i=0; $i < 100; $i++){
            $article = new Article();
            $article->setTitle($faker->text(50));
            $article->setContent($faker->text(250));
            $article->setCreatedAt(new \DateTime());
            $article->setUser($users[$faker->numberBetween(0,49)]);
            $article->addCategory($categories[$faker->numberBetween(0,14)]);

            $manager->persist($article);
            $articles[] = $article;
        }

        $manager->flush();
    }
}
