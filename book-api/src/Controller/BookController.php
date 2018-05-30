<?php

namespace App\Controller;

use App\Service\AuthTokenService;
use App\Service\BookService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BookController
 * @package App\Controller
 */
class BookController extends ApiController
{
    /**
     * @var BookService
     */
    private $service;

    /**
     * BookController constructor.
     * @param AuthTokenService $authTokenService
     * @param BookService $service
     */
    public function __construct(AuthTokenService $authTokenService, BookService $service)
    {
        parent::__construct($authTokenService);
        $this->service = $service;
    }

    /**
     * @Route("/api/author/{authorId}/book", name="book_creation")
     * @Method({"POST"})
     * @param Request $request
     * @param int $authorId
     * @return JsonResponse
     */
    public function createFromAuthorAction(Request $request, int $authorId) : JsonResponse
    {
        $token = $this->parseToken($request);
        $attributes = array(
            'title'         => $request->get('title', null),
            'type'          => $request->get('type', null),
            'releaseDate'   => $request->get('release_date', null),
            'price'         => $request->get('price', null),
        );

        $response = $this->service->create($token, $authorId, $attributes);

        return $this->buildResponse($response);
    }

    /**
     * @Route("/api/book", name="book_creation_2")
     * @Method({"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createAction(Request $request) : JsonResponse
    {
        $token = $this->parseToken($request);
        $authorId = $request->get('authorId');

        $attributes = array(
            'title'         => $request->get('title', null),
            'type'          => $request->get('type', null),
            'releaseDate'   => $request->get('release_date', null),
            'price'         => $request->get('price', null),
        );

        $response = $this->service->create($token, $authorId, $attributes);

        return $this->buildResponse($response);
    }

    /**
     * @Route("/api/book/{id}", name="book_read")
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
     * @Route("/api/book/{id}", name="book_update")
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
     * @Route("/api/book/{id}", name="book_delete")
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
     * @Route("/api/book/list", name="book_list")
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