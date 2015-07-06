<?php

namespace Drak\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomewController extends Controller
{
    public function welcomeAction()
    {
        // $name = "DRAKUN CORP";
        return $this->render('DrakCoreBundle:Homew:welcome.html.twig');
        // return new Response("BIEN VUE");
    }

    public function contactAction(Request $request)
    {
        $session = $request->getSession();
        // Bien sûr, cette méthode devra réellement ajouter l'annonce

        // Le « flashBag » est ce qui contient les messages flash dans la session
        // Il peut bien sûr contenir plusieurs messages :
        $session->getFlashBag()->add('info', 'La page de contact n’est pas encore disponible!');

        // Puis on redirige vers la page homepage
     return $this->redirect($this->generateUrl('drak_core_homepage'));
        // return new Response("BIEN VUE");
    }
}
