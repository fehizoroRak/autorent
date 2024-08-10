<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Entity\Status;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/payment/process', name: 'payment_process')]
    public function processPayment(Request $request, EntityManagerInterface $entityManager, LocationRepository $locationRepository): Response
    {
        // Retrieve data from the request (assuming the form data is sent via POST)
        $locationId = $request->request->get('location_id');
        $amount = $request->request->get('amount');
        $paymentMode = $request->request->get('payment_mode');
        
        // Find the associated Location entity
        $location = $locationRepository->find($locationId);

        if (!$location) {
            throw $this->createNotFoundException('Location not found');
        }

        // Create a new Payment entity
        $payment = new Payment();
        $payment->setPaymentdate(new \DateTime());
        $payment->setAmount($amount);
        $payment->setPaymentmode($paymentMode);
        $payment->setLocation($location);

        // Update the Location entity
        $location->setPaid(true); // Mark as paid

        // Retrieve the "Confirmed" status
        $confirmedStatus = $entityManager->getRepository(Status::class)->findOneBy(['name' => 'Confirmed']);
        
        if (!$confirmedStatus) {
            throw $this->createNotFoundException('Status "Confirmed" not found');
        }

        // Add the "Confirmed" status to the location
        $location->addStatus($confirmedStatus);
        
        // Persist both the payment and location entities
        $entityManager->persist($payment);
        $entityManager->persist($location);
        $entityManager->flush();

        // Redirect or return a response
        return $this->redirectToRoute('app_myaccount'); // Redirect to the reservations page after payment
    }

    #[Route('/payment/confirm-agency', name: 'confirm_agency_payment', methods: ['POST'])]
    public function confirmAgencyPayment(Request $request, EntityManagerInterface $entityManager, LocationRepository $locationRepository): Response
    {
        $locationId = $request->request->get('location_id');
        $amount = $request->request->get('amount');
        
        if (!$locationId) {
            $this->addFlash('error', 'Invalid location ID.');
            return $this->redirectToRoute('app_myaccount');
        }
    
        $location = $locationRepository->find($locationId);
    
        if (!$location) {
            $this->addFlash('error', 'Location not found.');
            return $this->redirectToRoute('app_myaccount');
        }
    
        // Retrieve the "Confirmed" status
        $confirmedStatus = $entityManager->getRepository(Status::class)->findOneBy(['name' => 'Confirmed']);
        
        if (!$confirmedStatus) {
            $this->addFlash('error', 'Confirmed status not found.');
            return $this->redirectToRoute('app_myaccount');
        }
    
        // Create a new Payment entity for agency payment
        $payment = new Payment();
        $payment->setPaymentdate(new \DateTime());
        $payment->setAmount($amount);
        $payment->setPaymentmode('en agence');  // Set payment mode to 'en agence'
        $payment->setLocation($location);
    
        // Add "Confirmed" status to the location
        $location->addStatus($confirmedStatus);
        $location->setPaid(false);  // Mark as unpaid, since it's payment in agency
    
        $entityManager->persist($payment);
        $entityManager->persist($location);
        $entityManager->flush();
    
        // Flash message for success
        $this->addFlash('success', 'Payment confirmed in agency.');
    
        // Redirect to myaccount page
        return $this->redirectToRoute('app_myaccount');
    }
    
    
    
}
