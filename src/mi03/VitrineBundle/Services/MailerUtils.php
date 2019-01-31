<?php
/**
 * Created by PhpStorm.
 * User: fabien
 * Date: 29/12/18
 * Time: 08:33
 */

namespace mi03\VitrineBundle\Services;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class MailerUtils
{
    private $mailer;
    private $templating;

    public function __construct(\Swift_Mailer $mailer,EngineInterface $templating){
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function sendMailConfirmationCommande($commande, $client){
        $from = 'contact@vitrineBundle.com';
        $to = $client->getMail();
        $subject = '[VitrineBundle] Confirmation commande N°'.$commande->getId();
        $body = $this->templating->render('@mi03Vitrine/Default/Emails/confirmationCommande.html.twig', array('commande' => $commande, 'client' => $client));
        $this->sendMessage($from, $to, $subject, $body);
    }

    private function sendMessage($from, $to, $subject, $body)
    {
        $mail = \Swift_Message::newInstance();

        $mail
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body)
            ->setContentType('text/html');

        $this->mailer->send($mail);
    }
}