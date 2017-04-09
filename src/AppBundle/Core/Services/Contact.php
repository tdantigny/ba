<?php

namespace AppBundle\Core\Services;

use Symfony\Bundle\TwigBundle\TwigEngine;

/**
 * Class Contact
 * @package AppBundle\Core\Services
 */
class Contact
{
    /**
     * @var TwigEngine
     */
    private $twig;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    private $mailContact;

    /**
     * Contact constructor.
     * @param TwigEngine    $twig
     * @param \Swift_Mailer $mailer
     * @param string        $mailContact
     */
    public function __construct(TwigEngine $twig, \Swift_Mailer $mailer, string $mailContact)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->mailContact = $mailContact;
    }

    /**
     * Change data from form and use it for send the email
     *
     * @param array $data
     */
    public function sendMail(array $data)
    {
        $corpsMessage = $this->twig->render(
            'Contact/corps-mail.html.twig',
            [
                'nom' => $data['nom'],
                'sujet' => $data['sujet'],
                'message' => $data['message'],
            ]
        );

        $message = \Swift_Message::newInstance()
            ->setSubject('Bonne augure - Contact')
            ->setFrom($data['email'])
            ->setTo($this->mailContact)
            ->setBody($corpsMessage);

        $this->mailer->send($message);
    }
}
