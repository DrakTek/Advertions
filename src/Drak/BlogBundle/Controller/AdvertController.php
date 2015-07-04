<?php

    namespace Drak\BlogBundle\Controller;

    use Symfony\Component\HttpFoundation\Response;

    class AdvertController
    {
        public function indexAction()
        {
            return new Response("Hello Drak !");
        }
    }