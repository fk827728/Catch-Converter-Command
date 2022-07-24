<?php

namespace App\Command;

use App\Util\Service\OrderFileConverterService;
use App\Util\Service\OrderFileValidatorService;
use App\Util\Service\UploadService;
use App\Util\Service\EmailService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand(name: 'app:convert')]
class ConverterCommand extends Command
{
    /**
     * @var striOrderFileConverterServiceng
     */
    private OrderFileConverterService $orderFileConverterService;

    /**
     * @var OrderFileValidatorService
     */
    private OrderFileValidatorService $orderFileValidatorService;

    /**
     * @var UploadService
     */
    private UploadService $uploadService;

    /**
     * @var EmailService
     */
    private EmailService $emailService;

    /**
     * Construct
     *
     * @param OrderFileConverterService $orderFileConverterService
     * @param OrderFileValidatorService $orderFileValidatorService
     * @param UploadService $uploadService
     * @param EmailService $emailService
     */
    public function __construct(
        OrderFileConverterService $orderFileConverterService,
        OrderFileValidatorService $orderFileValidatorService,
        UploadService $uploadService,
        EmailService $emailService
    ) {
        $this->orderFileConverterService = $orderFileConverterService;
        $this->orderFileValidatorService = $orderFileValidatorService;
        $this->uploadService = $uploadService;
        $this->emailService = $emailService;
        parent::__construct('app:convert');
    }

    /**
     * Configure
     *
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->addArgument('jsonl_file_name', InputArgument::REQUIRED, 'The jsonl file name')
            ->addArgument('output_file_name', InputArgument::REQUIRED, 'The output file name')
            ->addArgument('email_address', InputArgument::OPTIONAL, 'The receiver email address');
    }

    /**
     * Execute
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $emailAddress = $input->getArgument('email_address');
        if (!empty($emailAddress)) {
            $this->emailService->validate($emailAddress);
        }

        $output->write("Start converting...\n");
        $jsonlFileName = $input->getArgument('jsonl_file_name');
        $outputFileName = $input->getArgument('output_file_name');
        $outputFileName = strtolower($outputFileName);
        $this->orderFileConverterService->convertOrderFile($jsonlFileName, $outputFileName);
        $output->write("Converting succeeds\n");

        $output->write("Start uploading...\n");
        $uploadFileName = $this->uploadService->upload($outputFileName);
        $output->write("Uploading succeeds\n");

        $output->write("Start validating...\n");
        $this->orderFileValidatorService->validate($uploadFileName);
        $output->write("Validating succeeds\n");

        if (!empty($emailAddress)) {
            $output->write("Start sending email...\n");
            $this->emailService->sendEmail($outputFileName, $emailAddress);
            $output->write("Sending email succeeds\n");
        }

        $output->write("All Done, Congratulations!!!\n");

        return Command::SUCCESS;
    }
}
