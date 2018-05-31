<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends Controller
{
    private $repository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->repository = $authorRepository;
    }

    /**
     * @Route("/api/author/list/{page}/{perPage}", name="test_route")
     * @Method({"GET"})
     * @param Request $request
     * @param int $page
     * @param int $perPage
     * @return JsonResponse
     */
    public function testAction(Request $request, int $page, int $perPage = 20) : JsonResponse
    {
        $limit = $page * $perPage;
        $offset = ($limit - $perPage) > 0 ?:0;
        return new JsonResponse(
            array(
                'page'      => $page,
                'perPage'   => $perPage,
                'limit'     => $limit,
                'offset'    => $offset,
                'list'      => $this->repository->findBy([], ['id' => 'asc'], $limit, $offset),
            )
        );
    }
}
