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
    use Drak\BlogBundle\Form\AdvertType;
    use Drak\BlogBundle\Form\AdvertEditType;
    use Symfony\Component\Security\Core\Exception\AccessDeniedException;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


    class AdvertController extends Controller
    {
        public function indexAction($page)
        {
            if ($page < 1){
                throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
            }
            // Notre liste d'annonce en dur
            $em = $this->getDoctrine()->getManager();

            // fixation du nombre de page
            $nbPerPage = 3;

            $listAdverts = $em
                ->getRepository('DrakBlogBundle:Advert')
                ->getAdverts($page, $nbPerPage)
                // ->findAll()
            ;

            // on calcule le nombre total de pages grace au count($listAdverts)
            // qui retourne le nombre total d'annonces
            $nbPages = ceil(count($listAdverts)/$nbPerPage);

            // si la page n'existe pas, on retourne une 404
            if($page > $nbPages){
                throw $this->createNotFoundException("La page ".$page." n'existe pas.");
            }


            $this->container->get('drak_blog.purge')->toPurge();


            return $this->render('DrakBlogBundle:Advert:index.html.twig',
                array(
                    'listAdverts'   =>  $listAdverts,
                    'nbPages'       =>  $nbPages,
                    'page'          =>  $page
                ));
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

            // On vérifie que l'utilisateur dispose bien du rôle ROLE_AUTEUR
            if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
                // Sinon on déclenche une exception « Accès interdit »
                throw new AccessDeniedException('Accès limité aux auteurs.');
            }

            // je déclare toujours ma variable flash
            $flash = $request->getSession()->getFlashBag();

            $advert = new Advert();
            $form = $this->createForm(new AdvertType(), $advert);

            // on fait le lien requete <-> formulaire
            $form->handleRequest($request);

            // vérification des entrées 
            if ($form->isValid()) {
                // on déplace l'image pour le stocker 
                // $advert->getImage()->upload();

                // on enregistre notre advert dans la base de donne
                $em = $this->getDoctrine()->getManager();
                $em->persist($advert);
                $em->flush();

                $flash 
                    ->add('notice','annonce bien enregistrée !')
                ;
                // on redirige vers la page de visualisation de l'annonce freshman créée
                return $this->redirect(
                    $this->generateUrl(
                        'blog_view', array(
                            'id'    =>  $advert->getId(),
                        )
                    )
                );

            }

            return $this->render('DrakBlogBundle:Advert:add.html.twig',array(
                'form'  =>  $form->createView()
            ));
        }

        public function editAction($id, Request $request)
        {
            $em = $this->getDoctrine()->getManager();

            $advert = $em->getRepository('DrakBlogBundle:Advert')->find($id);

            if ($advert == null){
                throw $this->createNotFoundException("L'annonce d'id ".$id." n'existe pas.");
            }

            // déclaration de la variable flash
            $flash = $request->getSession()->getFlashBag();
            // récupération du formulaire d'edition
            $editform = $this->createForm(new AdvertType(), $advert);
            // on fait le lien requete <-> formulaire
            $editform->handleRequest($request);

            if($editform->isValid()){

                // Inutile de persister ici car doctrine connait déja l'entité
                $em->flush();

                $flash 
                    ->add('notice','Annonce bien modifiee');

                return $this->redirect(
                    $this->generateUrl(
                        'blog_view',array(
                            'id' => 5
                        )
                    )
                );
            }

            return $this->render('DrakBlogBundle:Advert:edit.html.twig', array(
                'form'  =>$editform->createView(),
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

            // on créé un formulaire vide vide pour une protection contre les failles de sécurité 
            $form = $this->createFormBuilder()->getForm();
            
            // déclaration de la variable flash
            $flash = $request->getSession()->getFlashBag();

            
            // on fait le lien requete <-> formulaire
            $form->handleRequest($request);


            if ($form->isValid()){
                $em->remove($advert);
                $em->flush();

                $flash
                    ->add('info',"L'annonce avec l'id : ".$id." a été bien supprimée");
                return $this->redirect($this->generateUrl('blog_home'));
            }

            return $this
                ->render('DrakBlogBundle:Advert:delete.html.twig',
                    array(
                        'advert'    => $advert,
                        'form'      => $form->createView()
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
