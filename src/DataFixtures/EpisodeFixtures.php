<?php


namespace App\DataFixtures;


use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    const EPISODE = 'episode_';

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr-FR');

        for ($i = 0; $i < 20; $i++) {
            $episode = new Episode();
            $episode->setTitle($faker->name);
            $episode->setNumber($faker->randomDigit);
            $episode->setSynopsis($faker->realText(250,2));
            $episode->setSeason(
              $this->getReference(
                'season_'.$faker->numberBetween(0,19)));
            $manager->persist($episode);
            $this->addReference(self::EPISODE . $i, $episode);
        }


        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }

}