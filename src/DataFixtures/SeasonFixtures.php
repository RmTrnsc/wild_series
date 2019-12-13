<?php


namespace App\DataFixtures;


use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{

    const SEASON = 'season_';

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr-FR');

        for ($i = 0; $i < 20; $i++) {
            $season = new Season();
            $season->setDescription($faker->realText(250, 2));
            $season->setYear($faker->year);
            $season->setProgram(
              $this->getReference(
                'program_'.$faker->numberBetween(0,5)));
            $manager->persist($season);
            $this->addReference(self::SEASON . $i, $season);
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}