<?php

namespace App\Service\SMS\Providers;

use App\Service\SMS\SMSInterface;

class SecondProvider implements SMSInterface
{
    /**
     * Reads and Returns this provider Api Address from .env file
     *
     * @return String
     */
    public function getApiAddress(): string
    {
        return $_ENV['FIRST_SMS_PROVIDER_API_ADDRESS'];
    }

    /**
     * Actual sender for this provider
     *
     * @param String $number
     * @param String $body
     * @return mixed
     */
    public function sendSMS($number, $body): bool
    {
        // Must use GuzzleClient to send request to $this->getApiAddress()
        // But for demo purposes, just returning "true" sometimes or "exception" so SMSComposer picks the next SMS Provider

        if (rand(1, 10) > 7)
            return true;

        throw new \Exception('Second SMS Provider failed :(');
    }
}
