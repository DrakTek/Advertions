<?php

    namespace Drak\BlogBundle\Controller;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


    class AdvertController extends Controller
    {
        public function indexAction($page)
        {
            if ($page < 1){
                throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
            }
            // Notre liste d'annonce en dur
            $listAdverts = array(
              array(
                'title'   => 'Recherche développpeur Symfony2',
                'id'      => 1,
                'author'  => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
                'date'    => new \Datetime()),
              array(
                'title'   => 'Mission de webmaster',
                'id'      => 2,
                'author'  => 'Hugo',
                'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'date'    => new \Datetime()),
              array(
                'title'   => 'Offre de stage webdesigner',
                'id'      => 3,
                'author'  => 'Mathieu',
                'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
                'date'    => new \Datetime())
            );

            return $this->render('DrakBlogBundle:Advert:index.html.twig',
                array('listAdverts'=> $listAdverts));
        }

        public function viewAction($id)
        {
            $advert = array(
      'title'   => 'Recherche développpeur Symfony2',
      'id'      => $id,
      'author'  => 'Alexandre',
      'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
      'date'    => new \Datetime()
    );

    return $this->render('DrakBlogBundle:Advert:view.html.twig', array(
      'advert' => $advert
    ));
        }

        public function viewSlugAction($slug, $year, $format)
        {
            return new Response(
                "On pourrait afficher l'annonce correspondant au
                slug '".$slug."', créée en ".$year." et au
                format ".$format."."
            );
        }

        public function addAction(Request $request)
        {
            $antispam = $this->container->get('drak_anti_spam.antispam');
            $text = 'Lorem ipsum dolor sit amet.';
            if($antispam->isSpam($text)){
                throw new \Exception('Votre message a ete detecte comme spam');
            }

            if($request->isMethod('POST')){
                $session = $request->getSession();
                $session->getFlashBag()->add('info','Annonce bien enregistree');

                return $this->redirect(
                    $this->generateUrl(
                        'blog_view',array(
                            'id'=>5
                        )
                    )
                );
            }

            return $this->render('DrakBlogBundle:Advert:add.html.twig');
        }

        public function editAction($id, Request $request)
        {
            if($request->isMethod('POST')){
                $request->getSession()->getFlashBag()->add(
                    'notice','Annonce bien modifiee'
                );

                return $this->redirect(
                    $this->generateUrl(
                        'blog_view',array(
                            'id' => 5
                        )
                    )
                );
            }

            $advert = array(
                'title'   => 'Recherche développpeur Symfony2',
                'id'      => $id,
                'author'  => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
                'date'    => new \Datetime()
            );

            return $this->render('DrakBlogBundle:Advert:edit.html.twig', array(
                'advert' => $advert
            ));
        }

        public function deleteAction($id, Request $request)
        {
            $request->getSession()->getFlashBag()->add('info','Annonce supprimee');

            return $this->render('DrakBlogBundle:Advert:delete.html.twig');
        }

        public function menuAction($limit)
        {
            $listAdverts = array(
                array('id' => 2,'title' => 'Recherche developpeur symfony2'),
                array('id' => 5,'title' => 'Mission Webmaster'),
                array('id' => 9,'title' => 'Offre stage WebDesigner'),
            );

            return $this->render('DrakBlogBundle:Advert:menu.html.twig',
                array(
                    'listAdverts'   =>  $listAdverts,
                ));
        }

    }
