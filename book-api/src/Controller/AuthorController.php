<?php

namespace App\Controller;

use App\Service\AuthorService;
use App\Service\AuthTokenService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthorController
 * @package App\Controller
 */
class AuthorController extends ApiController
{
    /**
     * @var AuthorService
     */
    private $service;

    /**
     * AuthorController constructor.
     * @param AuthTokenService $authTokenService
     * @param AuthorService $service
     */
    public function __construct(AuthTokenService $authTokenService, AuthorService $service)
    {
        parent::__construct($authTokenService);
        $this->service = $service;
    }

    /**
     * @Route("/api/author", name="author_creation")
     * @Method({"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createAction(Request $request) : JsonResponse
    {
        $attributes = array(
            'lastName' => $request->get('last_name', null),
            'firstName'=> $request->get('first_name', null),
            'birthDate'=> $request->get('birth_date', null),
        );

        $token = $this->parseToken($request);

        $response = $this->service->create($token, $attributes);

        return $this->buildResponse($response);
    }

    /**
     * @Route("/api/author/{id}", name="author_read")
     * @Method({"GET"})
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function getAction(Request $request, int $id): JsonResponse
    {
        $token = $this->parseToken($request);
        $response = $this->service->find($token, $id);

        return $this->buildResponse($response);
    }

    /**
     * @Route("/api/author/{id}", name="author_update")
     * @Method({"PATCH"})
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateAction(Request $request, int $id) : JsonResponse
    {
        $token = $this->parseToken($request);
        $attributes = array(
            'lastName' => $request->get('last_name', null),
            'firstName'=> $request->get('first_name', null),
            'birthDate'=> $request->get('birth_date', null),
        );

        $response = $this->service->update($token, $id, $attributes);

        return $this->buildResponse($response);
    }

    /**
     * @Route("/api/author/{id}", name="author_delete")
     * @Method({"DELETE"})
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function deleteAction(Request $request, int $id) : JsonResponse
    {
        $token = $this->parseToken($request);
        $response = $this->service->delete($token, $id);
        return $this->buildResponse($response);
    }

    /**
     * @Route("/api/author/list", name="author_list")
     * @Method({"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function listAction(Request $request) : JsonResponse
    {
        $token = $this->parseToken($request);
        $response = $this->service->all($token);
        return $this->buildResponse($response);
    }
}