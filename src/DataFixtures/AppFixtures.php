<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class AppFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        for ($i = 1; $i < 30; $i++) {
            $article = new Article();
            /** @var User $user */
            $user = $this->getReference('App\Entity\User');
            $article->setUser($user);

            $article->setTitle('Titile '.$i);
            $article->setContent('Content' .$i);
            $article->setDateCreate(new \DateTime(sprintf('-%d days', rand(1, 100))));
            $article->setDateUpdate(new \DateTime(sprintf('-%d days', rand(1, 100))));
//            $this->setReference(self::TESTER_1, $article);
//            $article->setUserId($this->addReference(self::TESTER_1, $article));
            $user->addArticle($article);
            $manager->persist($article);
        }
        $manager->flush();
    }

    /**
     * @return integer
     */

    public function getOrder()
    {
        return 1;
    }

}
