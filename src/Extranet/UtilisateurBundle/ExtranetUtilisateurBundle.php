<?php

namespace Extranet\UtilisateurBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ExtranetUtilisateurBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
