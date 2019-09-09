<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;





class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);


//        $user = $this->getDoctrine()->getRepository(User::class)->findById(1);


        for ($i = 0; $i < 20; $i++) {
            $product = new Article();
            $product->setTitle('Titile '.$i);
            $product->setContent('Content' .$i);
            $product->setDateCreate(new \DateTime(sprintf('-%d days', rand(1, 100))));
            $product->setDateUpdate(new \DateTime(sprintf('-%d days', rand(1, 100))));
//            $product->setUserId(1);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
