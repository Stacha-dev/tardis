<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Lib\Security\Hash;

class AppPasswordCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'app:password';

    /**
     * Command configuration
     *
     * @return void
     */
    protected function configure()
    {
        $this->setDescription('Generates passwod hash.')->setHelp('This command generates hash of provided password.');
        $this->addArgument('password', InputArgument::REQUIRED, 'Provide password');
    }

    /**
    * Execute command
    *
    * @param InputInterface $input
    * @param OutputInterface $output
    * @return integer
    */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $password = $input->getArgument('password');
        is_string($password) && $output->writeln(Hash::getHash($password));
        return Command::SUCCESS;
    }
}
