<?php

    namespace Drak\BlogBundle\Controller;

    use Drak\BlogBundle\Entity\Advert;
    use Drak\BlogBundle\Entity\Application;
    use Drak\BlogBundle\Entity\AdvertSkill;
    use Drak\BlogBundle\Entity\Image;
    use Drak\BlogBundle\Entity\Categorie;
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
            $em = $this->getDoctrine()->getManager();

            $listAdverts = $em
                ->getRepository('DrakBlogBundle:Advert')
                ->getAdverts()
                // ->findAll()
            ;

            return $this->render('DrakBlogBundle:Advert:index.html.twig',
                array('listAdverts'=> $listAdverts));
        }

        public function viewAction($id)
        {
            $em = $this->getDoctrine()->getManager();

            $advert = $em->getRepository('DrakBlogBundle:Advert')
                ->find($id)
            ;

            if(null === $advert){
                throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas");
            }

            $listApplications = $em->getRepository('DrakBlogBundle:Application')
                ->findBy(array('advert' => $advert))
            ;

            $listAdvertSkills = $em->getRepository('DrakBlogBundle:AdvertSkill')
                ->findBy(array('advert' => $advert))
            ;

            return $this->render('DrakBlogBundle:Advert:view.html.twig', array(
                'advert'            =>  $advert,
                'listApplications'  =>  $listApplications,
                'listAdvertSkills'  =>  $listAdvertSkills,
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
            // $antispam = $this->container->get('drak_anti_spam.antispam');
            // $text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
            // if($antispam->isSpam($text)){
            //     throw new \Exception('Votre message a ete detecte comme spam');
            // }
            //
            // $advert = new Advert();
            // $advert->setTitle('Recherche developpeur NODE JS');
            // $advert->setAuthor('Drakun');
            // $advert->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
            //
            // // creation de lentite image
            // $image = new Image();
            // $image->setUrl('http://placehold.it/64x64');
            // $image->setAlt('Job de reve bien');
            //
            // $advert->setImage($image);
            //
            //
            // // APPLICATION
            // $application1 = new Application();
            // $application1->setAuthor("Pierre");
            // $application1->setContent("J'ai toutes les qualites requises");
            //
            // $application2 = new Application();
            // $application2->setAuthor("Marine");
            // $application2->setContent("Je suis tres motive");
            //
            // $application1->setAdvert($advert);
            // $application2->setAdvert($advert);
            //
            // $em = $this->getDoctrine()->getManager();
            //
            // $listSkills = $em->getRepository('DrakBlogBundle:Skill')->findAll();
            // foreach($listSkills as $skill){
            //     $advertSkill = New AdvertSkill();
            //
            //     $advertSkill->setAdvert($advert);
            //     $advertSkill->setSkill($skill);
            //
            //     $advertSkill->setLevel('Expert');
            //     $em->persist($advertSkill);
            // }
            //
            // $em->persist($advert);
            //
            // $em->persist($application1);
            // $em->persist($application2);
            //
            // $em->flush();

            if($request->isMethod('POST')){
                $session = $request->getSession();
                $session->getFlashBag()->add('info','Annonce bien enregistree');

                return $this->redirect(
                    $this->generateUrl(
                        'blog_view',array(
                            'id'=>3
                        )
                    )
                );
            }

            return $this->render('DrakBlogBundle:Advert:add.html.twig');
        }

        public function editAction($id, Request $request)
        {
            $em = $this->getDoctrine()->getManager();

            $advert = $em->getRepository('DrakBlogBundle:Advert')->find($id);

            if ($advert == null){
                throw $this->createNotFoundException("L'annonce d'id ".$id." n'existe pas.");
            }
            // $listCategories = $em->getRepository('DrakBlogBundle:Category')->findAll();
            // foreach ($listCategories as $category){
            //     $advert->addCategory($category);
            // }
            //
            // $em->flush();

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

            return $this->render('DrakBlogBundle:Advert:edit.html.twig', array(
                'advert' => $advert
            ));
        }

        public function deleteAction($id, Request $request)
        {
            $em = $this->getDoctrine()->getManager();

            $advert = $em->getRepository('DrakBlogBundle:Advert')->find($id);

            if ($advert == null){
                throw new createNotFoundException("L'annonce d'id ".$id." n'existe pas ");
            }

            if ($request->isMethod('POST')){
                $request
                    ->getSession()
                    ->getFlashBag()
                    ->add('info',"L'annonce avec l'id : ".$id." n'existe pas Annonce");

                return $this->redirect($this->generateUrl('blog_home'));
            }

            return $this
                ->render('DrakBlogBundle:Advert:delete.html.twig',
                    array(
                        'advert'    =>  $advert,
                    )
                );
        }

        public function menuAction($limit = 3)
        {
            $listAdverts = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('DrakBlogBundle:Advert')
                ->findBy(
                    array(),
                    array('mdate'   =>  'desc'),
                    $limit,
                    0
                );

            return $this->render('DrakBlogBundle:Advert:menu.html.twig',
                array(
                    'listAdverts'   =>  $listAdverts,
                ));
        }

        public function listAction()
        {
            $listAdverts = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('DrakBlogBundle:Advert')
                ->getAdvertWithApplications()
            ;

            foreach ($listAdverts as $advert){
                $advert->getApplications();
            }
        }

        public function testAction()
        {
            $em = $this->getDoctrine()->getManager();
            $advert = $em->getRepository('DrakBlogBundle:Advert')->find(3);
            $advert->setTitle("Recherche d'un développeur FullStack H/F !");
            $em->persist($advert);
            $em->flush();

            return new Response('Slug genere : '.$advert->getSlug());
        }
    }
