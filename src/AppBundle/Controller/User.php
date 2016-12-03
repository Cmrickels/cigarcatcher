<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class User extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }

}