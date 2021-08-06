<?php

namespace App\Controller\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileBaseController extends AbstractController
{
    /**
     * @return string[]
     */
    public function renderDefault(): array
    {
        return  [
            'title' => 'Main page'
        ];
    }
}
