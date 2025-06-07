<?php

namespace App\Modules\DummyPaymentGateway;

use App\Modules\DummyPaymentGateway\Contracts\CardInterface;

class DummyPaymentGateway
{
    private ?CardInterface $card;
    private ?string $token;

    public function getValidToken(): ?DummyPaymentToken
    {
        $dummyPaymentToken = $this->validToken($this->token);

        if ($dummyPaymentToken === null) {
            $dummyPaymentToken = $this->generateToken($this->card);
        }
        return $dummyPaymentToken;
    }
    private function generateToken(CardInterface $card): DummyPaymentToken
    {
        if (!$card->isValid()) {
            throw new \InvalidArgumentException('Invalid card details.');
        }

        $token = 'dummy_' . md5($card->number . $card->expiration . $card->cvv);

        return new DummyPaymentToken($token);
    }

    private function validToken(?string $token): ?DummyPaymentToken
    {
        if ($token === null) {
            return null;
        }
        return new DummyPaymentToken($token);
    }

    public function setCard(?CardInterface $card): self
    {
        $this->card = $card;

        return $this;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }
}
