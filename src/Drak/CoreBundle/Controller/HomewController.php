<?php

namespace Drak\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomewController extends Controller
{
    public function indexAction()
    {
        // $name = "DRAKUN CORP";
        // return $this->render('DrakCoreBundle:Homew:welcome.html.twig');
        return new Response(" BIEN VUE");
    }
}
