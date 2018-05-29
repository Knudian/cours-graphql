<?php

namespace App\Service;

use EUAutomation\GraphQL\Client;

/**
 * Class GHApiClientService
 * @package App\Service
 */
class GHApiClientService
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client, string $ghToken)
    {
        $this->client = $client;
        $this->client->setUrl('https://api.github.com/graphql');
        $this->client->
    }

    public function getRepositories()
    {

    }
}