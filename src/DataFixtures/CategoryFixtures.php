<?php


namespace App\DataFixtures;


use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    const CATEGORIES = [
      'Action',
      'Aventures',
      'Animation',
      'Fantastique',
      'Horreur',
      'Thriller',
      'Drame'
    ];

    const CATEGORY = 'categorie_';

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {

        foreach (self::CATEGORIES as $key => $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference(self::CATEGORY . $key, $category);
        }
        $manager->flush();
    }
}