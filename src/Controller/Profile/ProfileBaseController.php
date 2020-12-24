<?php


namespace App\Controller\Profile;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileBaseController extends AbstractController
{
    public function renderDefault()
    {
        return  [
            'title' => 'Main page'
        ];
    }
}
