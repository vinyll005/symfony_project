<?php

namespace App\Service;

use App\Repository\PostRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

class DataService
{

    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getFilterPost(Request $request)
    {
        $categoryId = $request->get('categoryId');

        return $this->postRepository->getPostFilterJson((int)$categoryId);
    }
}