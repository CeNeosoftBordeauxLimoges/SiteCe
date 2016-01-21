<?php

namespace Extranet\AngularBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AngularController extends Controller
{
    public function indexAction()
    {
        return $this->render('ExtranetAngularBundle:Angular:index.html.twig');
    }
}
