<?php

	namespace Drak\BlogBundle\Controller;
	use Doctrine\ORM\EntityRepository;
    use Doctrine\ORM\EntityManager;

	/**
	*
	*/
	class AdvertServices
	{
        private $entityManager;
        private $days;

        public function __construct(EntityManager $entityManager, $days)
		{
            $this->em = $entityManager;
			$this->days = (int) $days;
		}

		public function toPurge()
		{
			 $em = $this->em;
            $list_a_purger = $em
                ->getRepository('DrakBlogBundle:Advert')
                ->getliste_purge($this->days);
            if($list_a_purger){
                foreach($list_a_purger as $liste){
                    $em->remove($liste);
                }
                $em->flush();
            }
		}
	}
