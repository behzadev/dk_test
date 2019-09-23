<?php
/**
 * This is the main class responsible for:
 * 1. Insantiating the SMS provider class
 * 2. If SMS provider fails, it automatically tries the next provider
 * 3. If all SMS providers fail, sendFailed() method will be triggered
 *
 * SOLID was one of the main concerns while creating this class
 * Adding or removing a SMS provider doesn't need any changes on this class nor on the controller itself
 * Just modifying the .env file will handle everything
 */

namespace App\Service\SMS;

use App\Entity\FailedAttempt;
use App\Entity\Sent;
use Doctrine\ORM\EntityManagerInterface;

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
     * Variable to hold Doctrine EntityManager
     *
     * @var Object
     */
    protected $entityManager;

    /**
     * Read and Set SMS providers from .env file
     * Also set EntityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->providers = explode(',', $_ENV['SMS_PROVIDERS']);

        $this->entityManager = $entityManager;
    }

    /**
     * Instantiate proper SMS Provider class based on currentProvider and returns it
     *
     * @return Object
     */
    public function getProvider()
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
    public function isThereAnotherProvider()
    {
        return $this->currentProvider + 1 <= count($this->providers);
    }

    /**
     * Select SMS provider first and then call sendSMS on the respected object
     *
     * @param String $body
     * @param String $number
     * @return void
     */
    public function send($number, $body)
    {
        try {
            // Getting responsible SMS provider object, each time calling this will instantiate the next SMS provider
            $sender = $this->getProvider();

            // Call sendSMS() method on the provider
            $send = $sender->sendSMS($number, $body);

            // Log to DB
            // $sent = new Sent();

            // $sent
            //     ->setNumber($number)
            //     ->setBody($body)
            //     ->setProvider(get_class($sender));

            // $this->entityManager->persist($sent);

            // $this->entityManager->flush();

            return $send;

        } catch (\Throwable $th) {

            // If sending was failed, we check to see if there is another provider left
            if ($this->isThereAnotherProvider()) {
                // This triggers the next provider to send the SMS with
                return $this->send($number, $body);
            } else {
                // We have tried all providers, all faild :(
                return $this->sendFailed($number, $body);
            }
        }
    }

    /**
     * This will be triggered when all providers failed to send the SMS
     *
     * @return void
     */
    public function sendFailed($number, $body)
    {
        // Log to DB
        // $failedAttempt = new FailedAttempt;

        // $failedAttempt
        //     ->setNumber($number)
        //     ->setBody($body);

        // $this->entityManager->persist($failedAttempt);

        // $this->entityManager->flush();

        return false;
    }
}
