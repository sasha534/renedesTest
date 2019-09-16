<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\UserBundle\Model\UserManagerInterface as UserManager;

class AppFixtures extends Fixture
{
//    public const TESTER_1 = 'tester1';
//    public const TESTER_2 = 'tester2';
//    public const TESTER_3 = 'tester3';

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 30; $i++) {
            $product = new Article();
            $product->setTitle('Titile '.$i);
            $product->setContent('Content' .$i);
            $product->setDateCreate(new \DateTime(sprintf('-%d days', rand(1, 100))));
            $product->setDateUpdate(new \DateTime(sprintf('-%d days', rand(1, 100))));
//            $this->setReference(self::TESTER_1, $product);
//            $product->setUserId($this->addReference(self::TESTER_1, $product));
            $manager->persist($product);
        }
        $manager->flush();
    }
}
