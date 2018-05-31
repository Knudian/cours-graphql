<?php

namespace App\GraphQL\Resolver;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

/**
 * Class AuthorInputResolver
 * @package App\GraphQL\Resolver
 */
class AuthorInputResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * AuthorInputResolver constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
            'resolve' => 'AuthorInput'
        );
    }

    public function resolve(Argument $argument)
    {
        $firstName = $argument['input']['firstName'];
        $lastName = $argument['input']['lastName'];
        $birthDate = $argument['input']['birthDate'];
        $author = new Author();
        $author->setBirthDate($birthDate)
            ->setFirstName($firstName)
            ->setLastName($lastName);

        $this->entityManager->persist($author);
        $this->entityManager->flush();

        return $author;
    }
}