<?php

namespace App\GraphQL\Resolver;

use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

/**
 * Class AuthorListResolver
 * @package App\GraphQL\Resolver
 */
class AuthorListResolver implements ResolverInterface, AliasedInterface
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
     * AuthorResolver constructor.
     * @param EntityManagerInterface $entityManager
     * @param AuthorRepository $authorRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        AuthorRepository $authorRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->authorRepository = $authorRepository;
    }

    /**
     * @param Argument $args
     * @return \App\Entity\Author[]
     */
    public function resolve(Argument $args)
    {
        $page = $args['page'];
        $perPage = $args['perPage'] ?: 20;

        $limit = $page * $perPage;
        $offset = ($limit - $perPage) > 0 ? $limit - $perPage : null;
        $list = $this->authorRepository->findBy([], ['id' => 'asc'], $limit, $offset);
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
            'resolve'   => 'AuthorList',
        );
    }

}