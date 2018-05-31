<?php

namespace App\GraphQL\Resolver;

use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

/**
 * Class BookResolver
 * @package App\GraphQL\Resolver
 */
class BookResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var BookRepository
     */
    private $bookRepository;

    /**
     * BookResolver constructor.
     * @param EntityManagerInterface $entityManager
     * @param BookRepository $bookRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        BookRepository $bookRepository
    ) {
        $this->entityManager    = $entityManager;
        $this->bookRepository   = $bookRepository;
    }

    /**
     * @param Argument $args
     * @return \App\Entity\Book|null
     */
    public function resolve(Argument $args)
    {
        return $this->bookRepository->find($args['id']);
    }

    /**
     * @return array
     */
    public static function getAliases()
    {
        return array(
            'resolve'   => 'Book'
        );
    }
}