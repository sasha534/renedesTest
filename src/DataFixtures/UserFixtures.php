<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /** @var $manager \FOS\UserBundle\Doctrine\UserManager */
        $manager = $this->container->get('fos_user.user_manager');
        /** @var $user User */
        $user = $manager->createUser();
        $user->setUsername('admin');
        $user->setEmail('admin@example.com');
        $user->setRoles(array('ROLE_SUPER_ADMIN'));
        $user->setEnabled(true);
        $user->setPlainPassword('admin_pass');
        $manager->updateUser($user);
        unset($user);

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++)
        {
            /** @var $user User */
            $user = $manager->createUser();
            $user->setUsername($faker->userName);
            $user->setEmail($faker->safeEmail);
            $user->setRoles(array('ROLE_USER'));
            $user->setEnabled(true);
            $user->setPlainPassword('pass');
            $manager->updateUser($user);
            $this->addReference('user.demo_'.$i, $user);
        }
    }

    /**
     * @return integer
     */
    function getOrder()
    {
        return 10;
    }
}
