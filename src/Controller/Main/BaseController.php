<?php

namespace App\Controller\Main;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    protected static function getRender()
    {
        return array(
            'title' => 'Symfony',
        );
    }
}