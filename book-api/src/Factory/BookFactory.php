<?php

namespace App\Factory;

use App\Entity\Author;
use App\Entity\Book;
use App\Exception\NoModificationException;
use App\Exception\NullAttributeException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class BookFactory
 * @package App\Factory
 */
class BookFactory
{
    /**
     * @var array
     */
    private $sample = array(
        'title'  => null,
        'type' => null,
        'releaseDate' => null,
        'price'     => null
    );

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * BookFactory constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param Author $author
     * @param array $attributes
     * @return Book
     * @throws NullAttributeException
     */
    public function make(Author $author, array $attributes) : Book
    {
        $data = array_merge($this->sample, $attributes);
        $book = new Book();
        $releaseDate = new \DateTime($data['releaseDate']);

        foreach ($data as $key => $value) {
            if( is_null($value)) {
                throw new NullAttributeException($key, 'book');
            }
        }

        $book->setType($data['type'])
            ->setPrice($data['price'])
            ->setReleaseDate($releaseDate)
            ->setTitle($data['title'])
            ->setAuthor($author);

        $this->em->persist($book);
        $this->em->flush();
        return $book;
    }

    /**
     * @param Book $book
     * @param array $attributes
     * @return Book
     * @throws NoModificationException
     */
    public function update(Book $book, array $attributes) : Book
    {
        $hasBeenModified = false;
        foreach (['title', 'type', 'releaseDate', 'author', 'price'] as $key) {
            if (array_key_exists($key, $attributes) && $book->get($key) !== $attributes[$key]) {
                $book->set($key, $attributes[$key]);
                $hasBeenModified = true;
            }
        }
        if ($hasBeenModified) {
            $this->em->persist($book);
            $this->em->flush();
        } else {
            throw new NoModificationException();
        }
        return $book;
    }

    /**
     * @param Book $book
     */
    public function delete(Book $book)
    {
        $this->em->remove($book);
        $this->em->flush();
    }
}