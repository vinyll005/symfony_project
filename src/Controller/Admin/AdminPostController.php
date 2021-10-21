<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Post;
use App\Form\PostType;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\PostRepositoryInterface;
use App\Service\FileManagerServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminPostController extends AdminBaseController
{
    private $postRepository;
    private $categoryRepository;

    public function __construct(PostRepositoryInterface $postRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }

    #[Route('/admin/post', name: 'admin_post')]
    public function index()
    {
        $getRender = parent::getRender();
        $getRender['title'] = 'Posts';
        $getRender['posts'] = $this->postRepository->getAllPost();
        $getRender['categories'] = $this->categoryRepository->getAllCategory();
        return $this->render('admin/post/index.html.twig', $getRender);
    }

    #[Route('/admin/post/create', name: 'admin_post_create')]
    public function create(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            $this->postRepository->setCreatePost($post, $image);
            $this->addFlash('success', 'Post created!');
            return $this->redirectToRoute('admin_post');
        }
        $getRender = parent::getRender();
        $getRender['title'] = 'Post create';
        $getRender['form'] = $form->createView();
        return $this->render('admin/post/form.html.twig', $getRender);
    }

    #[Route('/admin/post/update/{id}', name: 'admin_post_update')]
    public function update(int $id, Request $request)
    {
        $post = $this->postRepository->getOnePost($id);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('save')->isClicked()) {
                $image = $form->get('image')->getData();
                $this->postRepository->setUpdatePost($post, $image);
                $message = 'Post updated!';
            }
            if ($form->get('delete')->isClicked()) {
                $this->postRepository->setDeletePost($post);
                $message = 'Post deleted!';
            }
            $this->addFlash('success', $message);
            return $this->redirectToRoute('admin_post');
        }
        $getRender = parent::getRender();
        $getRender['title'] = 'Update post';
        $getRender['form'] = $form->createView();
        return $this->render('admin/post/form.html.twig', $getRender);
    }
}