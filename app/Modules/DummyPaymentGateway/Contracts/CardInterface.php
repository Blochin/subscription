<?php

namespace App\Modules\DummyPaymentGateway\Contracts;

interface CardInterface
{
    public function getMasked(): string;
    public function isValid(): bool;
    public function getNumber(): string;
    public function getExpiration(): string;
    public function getCvv(): string;
}
