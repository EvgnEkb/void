<?php

namespace App\Services;

class BillingService
{
    private const float MIN_VALUE = 100.00;

    public function calculateInvoiceAmount(
        float $basePrice,
        bool $isLoyalCustomer,
        float $loyaltyDiscountPct,
        float $couponAmount,
        float $vatRate
    ): float
    {
        $currentPrice = $basePrice;

        if ($isLoyalCustomer) {
            $discount = $basePrice * ($loyaltyDiscountPct / 100);
            $currentPrice -= $discount;
        }

        $currentPrice -= $couponAmount;

        $taxAmount = $currentPrice * ($vatRate / 100);
        $currentPrice += $taxAmount;

        if ($currentPrice < self::MIN_VALUE) {
            $currentPrice = self::MIN_VALUE;
        }

        if ($currentPrice < 0) {
            $currentPrice = 0;
        }

        return round($currentPrice, 2);
    }
}