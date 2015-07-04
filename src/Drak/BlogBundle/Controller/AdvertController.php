<?php

    namespace Drak\BlogBundle\Controller;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller


    class AdvertController extends Controller
    {
        public function indexAction()
        {
            $content = $this->get('templating')->render('DrakBlogBundle:Advert:index.html.twig');
            return new Response($content);
        }
    }
