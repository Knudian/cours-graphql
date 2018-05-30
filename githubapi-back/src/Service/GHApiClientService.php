<?php

namespace App\Service;

use EUAutomation\GraphQL\Client;
use EUAutomation\GraphQL\Exceptions\GraphQLMissingData;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class GHApiClientService
 * @package App\Service
 */
class GHApiClientService
{
    /**
     * @var string
     */
    private $ghToken;

    /**
     * @var Client
     */
    private $client;

    private $headers;

    public function __construct(ContainerInterface $container)
    {
        $this->client = new Client('https://api.github.com/graphql');
        $this->ghToken = $container->getParameter('gh_token');
        $this->headers = array(
            'Authorization' => 'Bearer '.$this->ghToken
        );
    }

    public function getRepositories(string $username)
    {
        $client = new \GuzzleHttp\Client();

        $query = 'query UserRepositories($login: String = "") {
            user(login: $login) {
                avatarUrl
                name
                repositories(last: 50, isFork: false) {
                    edges {
                        node {
                            id
                            name
                            url
                            description
                            languages(first: 10) {
                                edges {
                                    node {
                                        id
                                        name
                                        color
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }';

        try {
            $response = $client->request(
                'POST',
                'https://api.github.com/graphql',
                [
                    'json' => [
                        'query' => $query,
                        'variables' => [
                            'login' => $username
                        ]
                    ],
                    'headers' => $this->headers
                ]
            );
            $data = json_decode($response->getBody()->getContents(), true);
            return $data['data'];
        } catch (GuzzleException $e) {
            dump($e->getTrace());
        }
    }
}