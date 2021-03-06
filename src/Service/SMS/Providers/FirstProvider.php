<?php

namespace App\Service\SMS\Providers;

use App\Service\SMS\SMSProviderInterface;

class FirstProvider implements SMSProviderInterface
{
    /**
     * Reads and Returns this provider Api Address from .env file
     *
     * @return String
     */
    public function getApiAddress(): string
    {
        return $_ENV['SECOND_SMS_PROVIDER_API_ADDRESS'];
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

        if (rand(1, 10) > 4)
            return true;

        throw new \Exception('First SMS Provider failed :(');
    }
}
