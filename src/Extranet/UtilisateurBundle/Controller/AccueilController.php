<?php

namespace Extranet\UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccueilController extends Controller
{
    public function indexAction()
    {
        return $this->render('ExtranetUtilisateurBundle:Accueil:accueil.html.twig');
    }
}
