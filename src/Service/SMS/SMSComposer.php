<?php
/**
 * This is the main class responsible for:
 * 1. Instantiating the SMS provider class
 * 2. If SMS provider fails, it automatically tries the next provider
 * 3. If all SMS providers fail, allProvidersFailed() method will be triggered
 *
 * SOLID principles was one of the main concerns while creating this class
 * Adding or removing a SMS provider doesn't need any changes on this class nor on the controller itself
 * Just modifying the .env file will handle everything
 */

namespace App\Service\SMS;

use App\Service\Log\Logger;

class SMSComposer
{
    /**
     * Variable to hold SMS Providers defined in .env
     *
     * @var String
     */
    protected $providers;

    /**
     * Variable to hold current provider index, defaults to 0 so it starts from 0 index of providers array
     *
     * @var Integer
     */
    protected $currentProvider = 0;

    /**
     * Variable to hold logger instance
     *
     * @var Object
     */
    protected $logger;

    /**
     * Variable to hold if it is needed to save a failed attempt while all providers fail to send SMS
     *
     * @var Boolean
     */
    public $saveFailedAttempt = true;

    /**
     * Read and Set SMS providers from .env file
     * Also set the logger
     */
    public function __construct(Logger $logger)
    {
        $this->providers = explode(',', $_ENV['SMS_PROVIDERS']);

        $this->logger = $logger;
    }

    /**
     * Instantiate proper SMS Provider class based on currentProvider and returns it
     *
     * @return Object
     */
    public function getProvider(): SMSProviderInterface
    {
        $ProviderClass = __NAMESPACE__ . '\\Providers\\' . $this->providers[$this->currentProvider];

        $responsibelObject = new $ProviderClass;

        // Increase currentProvider index so next time it picks the next provider
        $this->currentProvider++;

        return $responsibelObject;
    }

    /**
     * Check to see if there is any provider left to try and send SMS with
     *
     * @return Boolean
     */
    public function isThereAnotherProvider(): bool
    {
        return $this->currentProvider + 1 <= count($this->providers);
    }

    /**
     * Select SMS provider first and then call sendSMS on the respected object
     *
     * @param String $body
     * @param String $number
     * @return Boolean
     */
    public function send(String $number, String $body): ?bool
    {
        try {
            // Getting responsible SMS provider object, each time calling this will instantiate the next SMS provider
            $sender = $this->getProvider();

            // Call sendSMS() method on the provider
            $sender->sendSMS($number, $body);

            // Log send success
            $this->logger->save($number, $body, $sender, true);

            return true;

        } catch (\Throwable $th) {

            echo $th->getMessage();

            // Log send failure
            $this->logger->save($number, $body, $sender, false);

            // If sending was failed, we check to see if there is another provider left
            if ($this->isThereAnotherProvider()) {
                // This triggers the next provider to send the SMS with
                return $this->send($number, $body);
            } else {
                // We have tried all providers, all failed :(
                return $this->allProvidersFailed($number, $body, $sender);
            }
        }
    }

    /**
     * This will be triggered when all providers failed to send the SMS
     *
     * @return Boolean
     */
    public function allProvidersFailed(String $number, String $body, $sender): bool
    {
        if ($this->saveFailedAttempt) {
            $this->logger->saveFailure($number, $body, $sender);
        }

        return false;
    }
}
