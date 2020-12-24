<?php
namespace App\Lib\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Loader;

class FixturesLoadCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'fixtures:load';

    /**
     * Command configuration
     *
     * @return void
     */
    protected function configure():void
    {
        $this->setDescription('Loads all fixtures.')->setHelp('This command allows you to load all fixtures.');
        $this->addOption('yes', 'y', InputOption::VALUE_NONE, 'Continue with yes?');
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
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('This action deletes all contents of the database. Do you want to continue? [yes/no]' . PHP_EOL, false);

        if ($input->getOption('yes') || $helper->ask($input, $output, $question)) {
            $loader = new Loader();
            $loader->loadFromDirectory(__DIR__ . '/../Model/Fixtures');
            $purger = new ORMPurger();
            $executor = new ORMExecutor(\App\Bootstrap::getEntityManager(), $purger);
            $executor->execute($loader->getFixtures());

            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }
}
