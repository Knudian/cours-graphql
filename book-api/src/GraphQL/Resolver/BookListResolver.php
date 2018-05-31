<?php

namespace App\GraphQL\Resolver;

use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

/**
 * Class BookListResolver
 * @package App\GraphQL\Resolver
 */
class BookListResolver implements ResolverInterface, AliasedInterface
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
    )
    {
        $this->entityManager = $entityManager;
        $this->bookRepository = $bookRepository;
    }

    /**
     * @param Argument $args
     * @return \App\Entity\Book[]
     */
    public function resolve(Argument $args)
    {
        $page = $args['page'];
        $perPage = $args['perPage'] ?: 20;

        $limit = $page * $perPage;
        $offset = ($limit - $perPage) > 0 ? $limit - $perPage : null;
        $list = $this->bookRepository->findBy([], ['id' => 'asc'], $limit, $offset);
        return $list;
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
            'resolve'   => 'BookList',
        );
    }

}