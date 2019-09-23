<?php

namespace App\Service\Log;

use App\Entity\Sent;
use App\Entity\ProviderLog;
use App\Entity\FailedAttempt;
use App\Service\SMS\SMSProviderInterface;
use Doctrine\ORM\EntityManagerInterface;

class Logger
{
    /**
     * Variable to hold doctrine entity manager instance
     *
     * @var Object
     */
    protected $entityManager;

    /**
     * Setting entity manager
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * Save a success send for future statistics
     *
     * @param String $number
     * @param String $body
     * @param SMSProviderInterface $sender
     * @param Boolean $status
     * @return void
     */
    public function save(String $number, String $body, SMSProviderInterface $sender, bool $status): void
    {
        // Save as sent if SMS sent successfully
        if ($status) {
            $sent = new Sent();

            $sent
                ->setNumber($number)
                ->setBody($body)
                ->setProvider(get_class($sender));

            $this->entityManager->persist($sent);
        }

        $this->saveProviderLog($sender, $status);
    }

    /**
     * Save as provider log
     *
     * @param SMSProviderInterface $sender
     * @param boolean $status
     * @return void
     */
    public function saveProviderLog(SMSProviderInterface $sender, bool $status): void
    {
        $providerLog = $this->entityManager->getRepository(ProviderLog::class)->findOneBy(['name' => get_class($sender)]);
        
        if ($providerLog === null) {
            $providerLog = new ProviderLog();
        }

        $getter = $status ? 'getSuccessCount' : 'getFailedCount';
        $setter = $status ? 'setSuccessCount' : 'setFailedCount';

        $providerLog
            ->setName(get_class($sender))
            ->$setter($providerLog->$getter() + 1);

        $this->entityManager->persist($providerLog);

        // make the actual changes in database
        $this->entityManager->flush();
    }
    
    /**
     * Save failed attempt so we can retry later
     *
     * @param String $number
     * @param String $body
     * @param SMSProviderInterface $sender
     * @return void
     */
    public function saveFailure(String $number, String $body, SMSProviderInterface $sender): void
    {
        $failedAttempt = new FailedAttempt;

        $failedAttempt
            ->setNumber($number)
            ->setBody($body)
            ->setAttempts(0);

        $this->entityManager->persist($failedAttempt);

        // make the actual changes in database
        $this->entityManager->flush();
    }

}
