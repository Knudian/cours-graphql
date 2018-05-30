<?php

namespace App\Factory;

use App\Entity\Author;
use App\Exception\NoModificationException;
use App\Exception\NullAttributeException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AuthorFactory
 * @package App\Factory
 */
class AuthorFactory
{
    /**
     * @var array
     */
    private $sample = array(
        'lastName'  => null,
        'firstName' => null,
        'birthDate' => null,
    );

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * AuthorFactory constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param array $attributes
     * @return Author
     * @throws NullAttributeException
     */
    public function make(array $attributes) : Author
    {
        $data = array_merge($this->sample, $attributes);
        $author = new Author();
        $birthDate = new \DateTime($data['birthDate']);

        foreach ($data as $key => $value) {
            if( is_null($value)) {
                throw new NullAttributeException($key, 'author');
            }
        }

        $author->setLastName($data['lastName'])
            ->setFirstName($data['firstName'])
            ->setBirthDate($birthDate);

        $this->em->persist($author);
        $this->em->flush();
        return $author;
    }

    /**
     * @param Author $author
     * @param array $attributes
     * @return Author
     * @throws NoModificationException
     */
    public function update(Author $author, array $attributes) : Author
    {
        $hasBeenModified = false;
        foreach (['username', 'firstName', 'lastName'] as $key) {
            if (array_key_exists($key, $attributes) && $author->get($key) !== $attributes[$key]) {
                $author->set($key, $attributes[$key]);
                $hasBeenModified = true;
            }
        }
        if ($hasBeenModified) {
            $this->em->persist($author);
            $this->em->flush();
        } else {
            throw new NoModificationException();
        }
        return $author;
    }

    /**
     * @param Author $author
     */
    public function delete(Author $author)
    {
        $this->em->remove($author);
        $this->em->flush();
    }
}