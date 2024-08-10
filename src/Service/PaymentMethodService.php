<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PaymentMethodService
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function setPaymentMethod(?string $paymentMethod): void
    {
        $this->session->set('payment_method', $paymentMethod);
    }

    public function getPaymentMethod(): ?string
    {
        return $this->session->get('payment_method');
    }

    public function clearPaymentMethod(): void
    {
        $this->session->remove('payment_method');
    }
}
