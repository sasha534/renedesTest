<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i < 20; $i++) {
            $product = new Article();
            $product->setTitle('Titile '.$i);
            $product->setContent('Content' .$i);
            $time = \DateTime::createFromFormat('yy-mm-dd hh:mm:ss');
            $product->setDateCreate($time);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
