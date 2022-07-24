<?php

namespace App\Util\Service;

use Exception;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class EmailService
{
    /**
     * @var MailerInterface
     */
    private MailerInterface $mailerInterface;

    /**
     * Construct
     *
     * @param MailerInterface $mailerInterface
     */
    public function __construct(
        MailerInterface $mailerInterface
    ) {
        $this->mailerInterface = $mailerInterface;
    }

    /**
     * Validate
     *
     * @param string $emailAddress
     * @return void
     */
    public function validate(string $emailAddress): void
    {
        if (filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            return;
        }
        throw new Exception('Invalide email address');
    }

    /**
     * Send Email
     *
     * @param string $fileName
     * @param string $emailAddress
     * @return void
     */
    public function sendEmail(string $fileName, string $emailAddress): void
    {
        $email = (new Email())
            ->from('fk827728@gmail.com')
            ->to($emailAddress)
            ->subject('Converted Order Data File')
            ->text("Hi.\n\nThe attachment is the converted order data file.")
            ->attachFromPath($fileName);

        $this->mailerInterface->send($email);
    }
}
