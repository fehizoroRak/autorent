<?php

// src/Controller/MailerController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    #[Route('/email', name: 'app_send_email')]
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('hello@test.com')
            ->to('test@test.com') // Assurez-vous que l'adresse est "example.com" pour Mailtrap
            ->subject('Test Email')
            ->text('This is a test email.')
            ->html('<p>This is a test email.</p>');

        try {
            $mailer->send($email);
            return new Response('Email sent successfully');
        } catch (\Exception $e) {
            return new Response('Failed to send email: ' . $e->getMessage());
        }
    }
}
