<?php

namespace App\Command;

use App\Entity\FailedAttempt;
use App\Service\SMS\SMSComposer;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FailedAttemptRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RetrySendSMS extends Command
{
    /**
     * Command name
     * usage: ./bin/console sms:retry
     *
     * @var string
     */
    protected static $defaultName = 'sms:retry';

    /**
     * Variable to hold failedAttemptRepository object
     *
     * @var Object
     */
    protected $failedAttemptRepository;

    /**
     * Variable to hold SMSComposer object
     *
     * @var Object
     */
    protected $sms;

    /**
     * Variable to hold entityManager object
     *
     * @var Object
     */
    protected $entityManager;

    /**
     * Setting needed objects
     *
     * @param FailedAttemptRepository $failedAttemptRepository
     * @param SMSComposer $sms
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(FailedAttemptRepository $failedAttemptRepository, SMSComposer $sms, EntityManagerInterface $entityManager)
    {
        $this->failedAttemptRepository = $failedAttemptRepository;

        $this->sms = $sms;

        $this->entityManager = $entityManager;

        parent::__construct();
    }

    /**
     * Set command description and help
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setDescription('Try to send a failed attemp')
            ->setHelp('This command will look into failed_attempt table and sends an sms to the number with minimum number of attempts');
    }

    /**
     * executes the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Looking into failed_attempt table...');
        
        // Select the oldest row in failed_attempt table with minimum attempts
        $row = $this->failedAttemptRepository->rowWithMinimumAttempts();

        $output->writeln([
            'Picked row: ' . $row['id'],
            'Number: ' . $row['number'],
            'trying to send...'
        ]);

        // trying to send...
        $send = $this->sms->send(
            $row['number'],
            $row['body'],
            false
        );

        $pickedFailedAttempt = $this
            ->entityManager
            ->getRepository(FailedAttempt::class)
            ->findOneBy(['id' => $row['id']]);

        if ($send) {
            $output->writeln('Successfully sent, removing from failed_attempts...');
            // remove the row from failed_attempt table
            $this->entityManager->remove($pickedFailedAttempt);
        } else {
            $output->writeln('Sending failed, updating attempts count for this row');
            // update the attempts count
            $pickedFailedAttempt->setAttempts($pickedFailedAttempt->getAttempts() + 1);
        }

        $this->entityManager->flush();

        $output->writeln('Done :)');
    }
}
