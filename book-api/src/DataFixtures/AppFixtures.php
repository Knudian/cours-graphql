<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $tolkien = new Author();
        $tolkien->setLastName("Tolkien")
            ->setFirstName("John Ronald Reuel")
            ->setBirthDate(new \DateTime('1982-01-03'));

        $marion = new Author();
        $marion->setLastName('Zimmer Bradley')
            ->setFirstName('Marion')
            ->setBirthDate(new \DateTime('1930-06-03'));


        $manager->persist($tolkien);
        $manager->persist($marion);
        $manager->flush();



        $hobbit = new Book();
        $hobbit->setType('Fantasy')
            ->setAuthor($tolkien)
            ->setPrice(10)
            ->setReleaseDate(new \DateTime('1937-09-21'))
            ->setTitle('Le Hobbit');

        $avalon = new Book();
        $avalon->setType('Fantasy')
            ->setAuthor($marion)
            ->setPrice(10.2)
            ->setTitle('Avalon')
            ->setReleaseDate(new \DateTime('1970-04-01'));
        $manager->persist($hobbit);
        $manager->persist($avalon);

        $manager->flush();
    }
}
