<?php


namespace App\Controller\Profile;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileHomeController extends ProfileBaseController
{

    /**
     * @Route ("/profile", name="profile")
     * @return Response
     */
    public function index()
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Your profile';
        return $this->render('profile/index.html.twig', $forRender);
    }

}