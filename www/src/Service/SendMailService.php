<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class SendMailService extends AbstractController
{


    private $mailer;

    function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(string $from, string $to, string $subject, array $context)
    {

        // VERIF IS EMAIL
        if (!filter_var($from, FILTER_VALIDATE_EMAIL) || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return $this->addFlash('error', 'Email is not send !');
        }

        //SEND MAIL
        $mail = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->Subject($subject)
            // path of the Twig template to render
            ->htmltemplate('emails/default.html.twig')
            // pass variables (name => value) to the template
            ->context($context);

        $this->mailer->send($mail);

        $this->addFlash('success', 'Email has been send !');
    }
}
