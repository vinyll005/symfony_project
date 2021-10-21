<?php

namespace App\Controller\Main;

use App\Repository\CategoryRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
{

    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {

        $forRender = parent::getRender();

        return $this->render('main/index.html.twig', $forRender);
    }
}
