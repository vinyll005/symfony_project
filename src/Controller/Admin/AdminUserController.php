<?php

namespace App\Controller\Admin;

use App\Form\UserType;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminUserController extends AdminBaseController
{

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {

        $this->userRepository = $userRepository;
    }

    #[Route('/admin/user', name: 'admin_user')]
    public function index() : Response
    {
        $render = parent::getRender();
        $render['users'] = $this->userRepository->getAll();
        return $this->render('admin/user/index.html.twig', $render);
    }

    #[Route('/admin/user/create', name: 'admin_user_create')]
    public function create(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->setCreateUser($user);
            $this->addFlash('success', 'User created!');

            return $this->redirectToRoute('admin_user');
        }

        $render = parent::getRender();
        $render['title'] = 'Create user form';
        $render['form'] = $form->createView();
        return $this->render('admin/user/form.html.twig', $render);
    }

    #[Route('/admin/user/update/{id}', name: 'admin_user_update')]
    public function update(int $id, Request $request)
    {
        $user = $this->userRepository->getOne($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('save')->isClicked()) {
                $this->userRepository->setUpdateUser($user);
                $message = 'User updated!';
            }
            if ($form->get('delete')->isClicked()) {
                $this->userRepository->setDeleteUser($user);
                $message = 'User deleted!';
            }
            $this->addFlash('success', $message);

            return $this->redirectToRoute('admin_user');
        }

        $getRender = parent::getRender();
        $getRender['title'] = 'User';
        $getRender['form'] = $form->createView();
        return $this->render('admin/user/form.html.twig', $getRender);
    }
}