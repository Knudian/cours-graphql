<?php

namespace App\GraphQL\Resolver;

use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

/**
 * Class AuthorResolver
 * @package App\GraphQL\Resolver
 */
class AuthorResolver implements ResolverInterface, AliasedInterface
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

    public function resolve(Argument $args)
    {
        $author = $this->authorRepository->find($args['id']);
        return $author;
    }

    /**
     * @inheritdoc
     */
    public static function getAliases(): array
    {
        return array(
            'resolve' => 'Author'
        );
    }
}