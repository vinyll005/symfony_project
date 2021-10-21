<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AdminBaseController
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    #[Route('/admin/category', name: 'admin_category')]
    public function index()
    {
        $getRender = parent::getRender();
        $getRender['title'] = 'Categories';
        $getRender['categories'] = $this->categoryRepository->getAllCategory();
        return $this->render('admin/category/index.html.twig', $getRender);
    }

    #[Route('/admin/category/create', name: 'admin_category_create')]
    public function create(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryRepository->setCreateCategory($category);
            $this->addFlash('success', 'Category created!');

            return $this->redirectToRoute('admin_category');
        }

        $getRender = parent::getRender();
        $getRender['title'] = 'Category create';
        $getRender['form'] = $form->createView();
        return $this->render('admin/category/form.html.twig', $getRender);
    }

    #[Route('/admin/category/update/{id}', name: 'admin_category_update')]
    public function update(int $id, Request $request)
    {
        $category = $this->categoryRepository->getOneCategory($id);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('save')->isClicked()) {
                $this->categoryRepository->setUpdateCategory($category);
                $message = 'Category updated!';
            }
            if ($form->get('delete')->isClicked()) {
                $this->categoryRepository->setDeleteCategory($category);
                $message = 'Category deleted!';
            }
            $this->addFlash('success', $message);

            return $this->redirectToRoute('admin_category');
        }

        $getRender = parent::getRender();
        $getRender['title'] = 'Category change';
        $getRender['form'] = $form->createView();
        return $this->render('admin/category/form.html.twig', $getRender);
    }
}