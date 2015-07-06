<?php

namespace Drak\AntiSpamBundle\Controller;

class AntiSpam
{
    private $mailer;
    private $locale;
    private $minLength;

    public function __construct(\Swift_Mailer $mailer, $locale, $minLength)
    {
        $this->mailer   = $mailer;
        $this->locale   = $locale;
        $this->minLength = (int) $minLength;
    }
    /**
     * verifie si le texte est un spam
     *
     * @param string $text
     * @return bool
     */

     public function isSpam($text)
     {
         return strlen($text) < $this->minLength;
     }
}
