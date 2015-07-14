<?php 
	
	namespace Drak\BlogBundle\Controller;
	use Doctrine\ORM\EntityRepository;

	/**
	* 
	*/
	class AdvertServices
	{
		private $days;

		public function __construct($days)
		{
		
			$this->days = $days;
		}

		public function purge($applicationList)
		{
			$em = $this->getDoctrine()->getManager();
			$all_lists = $em->getRepository('DrakBlogBundle:Advert')->getlist_a_nettoyer($days,$applicationList);
			return $all_lists;
		}
	}