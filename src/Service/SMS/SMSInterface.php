<?php

namespace App\Service\SMS;

interface SMSInterface
{
    /**
     * Should read and return Provider's Api Address from .env file
     *
     * @return String
     */
    public function getApiAddress();

    /**
     * Should trigger the real send method
     *
     * @param String $number
     * @param String $body
     * @return ‌mixed
     */
    public function sendSMS($number, $body);
}
