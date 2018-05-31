<?php

namespace App\GraphQL\Resolver;

use App\Entity\Book;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

/**
 * Class BookInputResolver
 * @package App\GraphQL\Resolver
 */
class BookInputResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var AuthorRepository
     */
    private $authorRepository;

    /**
     * BookInputResolver constructor.
     * @param EntityManagerInterface $entityManager
     * @param AuthorRepository $authorRepository
     */
    public function __construct(EntityManagerInterface $entityManager, AuthorRepository $authorRepository)
    {
        $this->entityManager = $entityManager;
        $this->authorRepository = $authorRepository;
    }

    /**
     * Returns methods aliases.
     *
     * For instance:
     * array('myMethod' => 'myAlias')
     *
     * @return array
     */
    public static function getAliases()
    {
        return array(
            'resolve' => 'BookInput'
        );
    }

    public function resolve(Argument $argument)
    {
        $author = $this->authorRepository->findBy($argument['input']['author'], null, 1);

        $book = new Book();
        $book->setTitle($argument['input']['title'])
            ->setReleaseDate($argument['input']['releaseDate'])
            ->setPrice($argument['input']['price'])
            ->setAuthor($author[0])
            ->setType($argument['input']['type']);

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $book;
    }
}