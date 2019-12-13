<?php


namespace App\DataFixtures;


use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
      'Walking Dead' => [
        'summary' => 'Le policier Rick Grimes se réveille après un long coma. Il découvre avec effarement que le monde, ravagé par une épidémie, est envahi par les morts-vivants.',
        'category' => 'categorie_4',
        'poster' => 'http://fr.web.img2.acsta.net/r_1920_1080/medias/nmedia/18/81/95/48/19592305.jpg',
      ],
      'The Haunting Of Hill House' => [
        'summary' => 'Plusieurs frères et sœurs qui, enfants, ont grandi dans la demeure qui allait devenir la maison hantée la plus célèbre des États-Unis, sont contraints de se réunir pour finalement affronter les fantômes de leur passé.',
        'category' => 'categorie_4',
        'poster' => 'http://fr.web.img6.acsta.net/r_1920_1080/pictures/18/10/02/12/47/4356733.jpg',
      ],
      'American Horror Story' => [
        'summary' => 'A chaque saison, son histoire. American Horror Story nous embarque dans des récits à la fois poignants et cauchemardesques, mêlant la peur, le gore et le politiquement correct.',
        'category' => 'categorie_4',
        'poster' => 'http://fr.web.img6.acsta.net/r_1920_1080/pictures/18/10/30/17/07/0996605.jpg',
      ],
      'Love Death And Robots' => [
        'summary' => 'Un yaourt susceptible, des soldats lycanthropes, des robots déchaînés, des monstres-poubelles, des chasseurs de primes cyborgs, des araignées extraterrestres et des démons assoiffés de sang : tout ce beau monde est réuni dans 18 courts métrages animés déconseillés aux âmes sensibles.',
        'category' => 'categorie_4',
        'poster' => 'http://fr.web.img6.acsta.net/r_1920_1080/pictures/19/03/25/14/32/3491300.jpg',
      ],
      'Penny Dreadful' => [
        'summary' => 'Dans le Londres ancien, Vanessa Ives, une jeune femme puissante aux pouvoirs hypnotiques, allie ses forces à celles de Ethan, un garçon rebelle et violent aux allures de cowboy, et de Sir Malcolm, un vieil homme riche aux ressources inépuisables. Ensemble, ils combattent un ennemi inconnu, presque invisible, qui ne semble pas humain et qui massacre la population.',
        'category' => 'categorie_4',
        'poster' => 'http://fr.web.img5.acsta.net/r_1920_1080/pictures/14/06/18/10/58/077616.jpg',
      ],
      'Fear The Walking Dead' => [
        'summary' => 'La série se déroule au tout début de l épidémie relatée dans la série mère The Walking Dead et se passe dans la ville de Los Angeles, et non à Atlanta. Madison est conseillère dans un lycée de Los Angeles. Depuis la mort de son mari, elle élève seule ses deux enfants : Alicia, excellente élève qui découvre les premiers émois amoureux, et son grand frère Nick qui a quitté la fac et a sombré dans la drogue.',
        'category' => 'categorie_4',
        'poster' => 'http://fr.web.img2.acsta.net/r_1920_1080/pictures/17/04/05/11/36/568191.jpg',
      ],

    ];

    const PROGRAM = 'program_';

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $i = 0;
        foreach (self::PROGRAMS as $title => $data) {
            $program = new Program();
            $program->setTitle($title);
            $program->setSummary($data['summary']);
            $program->setPoster($data['poster']);
            $program->setCategory($this->getReference($data['category']));
            $manager->persist($program);
            $this->addReference(self::PROGRAM . $i, $program);
            $i++;
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}