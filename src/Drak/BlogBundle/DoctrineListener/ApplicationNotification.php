<?php

    namespace Drak\BlogBundle\DoctrineListener;

    use Doctrine\ORM\Event\LifecycleEventArgs;
    use Drak\BlogBundle\Entity\Application;

    class ApplicationNotification
    {
        private $mailer;

        public function __construct(\Swift_Mailer $mailer)
        {
            $this->mailer = $mailer;
        }

        public function postPersist(LifecycleEventArgs $args)
        {
            $entity = $args->getEntity();

            // on peut envoyer un mail que pour les entites application
            if (!$entity instanceof Application){
                return;
            }

            $message = new \Swift_Message(
                'Nouvelle candidature',
                'Vous avez recu une nouvelle candidature.'
            );

            $message
            // ->addTo($entity->getAdvert()->getAuthor())
                ->addTo('ddiawara@cbao.sn')
                ->addFrom('admin@drak.corp')
            ;
            
            $this->mailer->send($message);
        }
    }
