<?php

	namespace Drak\BlogBundle\Controller;
	use Doctrine\ORM\EntityRepository;
    use Doctrine\ORM\EntityManager;

	/**
	*
	*/
	class AdvertServices
	{
        private $em;
        private $days;

        public function __construct($days, EntityManager $entityManager)
		{
		      // $this->entityManager = $entityManager;
            $this->em = $entityManager;
			 $this->days = $days;
		}

		public function toPurge()
		{
			// $em = $this->entityManager;
            $list_a_purger = $em
                ->getRepository('DrakBlogBundle:Advert')
                ->getliste_purge($days);
            if($list_a_purger){
                foreach($list_a_purger as $liste){
                    $em->remove($liste);
                }
                $em->flush();
            }
		}
	}
