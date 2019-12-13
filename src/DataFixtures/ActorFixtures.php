<?php


namespace App\DataFixtures;


use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{

    const ACTOR = 'actor_';

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr-FR');

        for ($i = 0; $i < 20; $i++) {
            $actor = new Actor();
            $actor->setName($faker->name);
            $actor->addProgram(
              $this->getReference(
                'program_'.$faker->numberBetween(0,5)));
            $manager->persist($actor);
            $this->addReference(self::ACTOR . $i, $actor);
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