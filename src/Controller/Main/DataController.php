<?php

namespace App\Controller\Main;

use App\Service\DataService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class DataController extends BaseController
{
    private DataService $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    #[Route('/data/post', name: 'data_post')]
    public function getFilterPost(Request $request): JsonResponse
    {
        $response = $this->dataService->getFilterPost();

        return $this->json($response);
    }

}