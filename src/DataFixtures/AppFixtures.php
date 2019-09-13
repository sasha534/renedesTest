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
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);


//        $user = $this->getDoctrine()->getRepository(User::class)->findById(1);

//        for ($i = 1; $i < 30; $i++)
//        {
//            $user = new User();
//            $userManager = $container->get('fos_user.user_manager');
//            $user->setUsername('admin');
//
//            $password = $this->encoder->encodePassword($user, 'pass_1234');
//            $user->setPassword($password);
//
//            $manager->persist($user);
//            $manager->flush();
//        }






        for ($i = 1; $i < 30; $i++) {
            $product = new Article();
            $product->setTitle('Titile '.$i);
            $product->setContent('Content' .$i);
            $product->setDateCreate(new \DateTime(sprintf('-%d days', rand(1, 100))));
            $product->setDateUpdate(new \DateTime(sprintf('-%d days', rand(1, 100))));
            $product->setUser(mt_rand(1, 3));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
