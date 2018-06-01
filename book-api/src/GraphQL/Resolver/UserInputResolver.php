<?php

namespace App\GraphQL\Resolver;

use App\Factory\UserFactory;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

/**
 * Class UserInputResolver
 * @package App\GraphQL\Resolver
 */
class UserInputResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var UserFactory
     */
    private $factory;

    /**
     * UserInputResolver constructor.
     * @param UserFactory $factory
     */
    public function __construct(UserFactory $factory)
    {
        $this->factory = $factory;
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
            'resolve' => 'UserInput'
        );
    }

    public function resolve(Argument $argument)
    {
        $inputs = array(
            'username'  => $argument['input']['username'],
            'lastName'  => $argument['input']['lastName'],
            'firstName' => $argument['input']['firstName'],
            'email'     => $argument['input']['email']
        );
        $user = $this->factory->make($inputs);

        return $user;
    }
}