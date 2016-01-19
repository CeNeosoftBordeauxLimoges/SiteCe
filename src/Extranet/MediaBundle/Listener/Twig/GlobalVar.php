<?php

namespace Extranet\MediaBundle\Listener\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Creates a twig globals variables
 */
class GlobalVar extends \Twig_Extension
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function setGlobals($globals)
    {
        $this->globals = $globals;
    }

    public function getGlobals()
    {
        return array(
            'annoncesFolder' => $this->container->getParameter('medias.repertoire.annonces'),
            'documentsFolder' => $this->container->getParameter('medias.repertoire.documents')
        );


    }

    public function getName()
    {
        return 'media_extension';
    }
}
