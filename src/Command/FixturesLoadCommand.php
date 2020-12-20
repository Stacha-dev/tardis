<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Loader;

class LoadFixturesCommand extends Command
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
        $loader = new Loader();
        $loader->loadFromDirectory(__DIR__ . '/../Model/Fixtures');
        $purger = new ORMPurger();
        $executor = new ORMExecutor(\App\Bootstrap::getEntityManager(), $purger);
        $executor->execute($loader->getFixtures());
        return Command::SUCCESS;
    }
}
