<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AdminBaseController
{
    /**
     * @Route ("/admin/users", name="admin_user")
     * @return Response
     */
    public function index(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Users';
        $forRender['users'] = $users;

        return $this->render('admin/user/index.html.twig', $forRender);
    }
}