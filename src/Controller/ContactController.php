<?php

// src/Controller/ContactController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ContactController extends AbstractController
{
    #[Route('/contact/send', name: 'app_send_contact_form', methods: ['POST'])]
    public function sendContactForm(
        Request $request,
        MailerInterface $mailer,
        ValidatorInterface $validator
    ): Response {
        // Récupération des données du formulaire
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $subject = $request->request->get('subject');
        $message = $request->request->get('message');

        // Validation des données du formulaire
        $input = [
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
        ];

        $constraints = new Assert\Collection([
            'name' => [new Assert\NotBlank(), new Assert\Length(['min' => 2])],
            'email' => [new Assert\NotBlank(), new Assert\Email()],
            'subject' => [new Assert\NotBlank(), new Assert\Length(['min' => 3])],
            'message' => [new Assert\NotBlank(), new Assert\Length(['min' => 10])],
        ]);

        $violations = $validator->validate($input, $constraints);

        // Si des erreurs de validation sont présentes, rediriger avec un message d'erreur
        if (count($violations) > 0) {
            foreach ($violations as $violation) {
                $this->addFlash('error', $violation->getMessage());
            }

            return $this->redirectToRoute('app_contact_us');
        }

        // Création de l'email
        $emailMessage = (new Email())
            ->from($email)
            ->to('autorent@autorent.fehizoro.fr')
            ->subject('Nouveau message de contact: ' . $subject)
            ->text("Nom: $name\nEmail: $email\n\nMessage:\n$message")
            ->html("<p><strong>Nom:</strong> $name</p><p><strong>Email:</strong> $email</p><p><strong>Sujet:</strong> $subject</p><p><strong>Message:</strong><br>$message</p>");

        // Envoi de l'email
        try {
            $mailer->send($emailMessage);
            $this->addFlash('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi de votre message. Veuillez réessayer plus tard.');
        }

        return $this->redirectToRoute('app_contact_us');
    }
}

