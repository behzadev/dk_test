<?php

namespace App\Service\SMS;

interface SMSProviderInterface
{
    /**
     * Should read and return Provider's Api Address from .env file
     *
     * @return String
     */
    public function getApiAddress(): string;

    /**
     * Should trigger the real send method
     *
     * @param String $number
     * @param String $body
     * @return ‌mixed
     */
    public function sendSMS($number, $body): bool;
}
