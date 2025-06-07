<?php

namespace App\Services\Payment;

use App\Dto\ProcessPaymentDto;
use App\Models\Payment;
use App\Services\Payment\Mapper\StatusMapper;

class ProcessPaymentService
{
    public function process(ProcessPaymentDto $data): Payment
    {
        $payment = Payment::findOrFail($data->paymentId);
        $payment->update([
            'status' => StatusMapper::map($data->status)->value,
        ]);

        return $payment;
    }
}
