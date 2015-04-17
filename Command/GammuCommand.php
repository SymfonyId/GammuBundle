<?php
namespace Symfonian\Indonesia\GammuBundle\Command;

/**
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: http://blog.khodam.org
 */

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfonian\Indonesia\GammuBundle\Processor\GammuCommandProcessor;

class GammuCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('symfonyid:sigab:gammu');
        $this->setDescription('Gammu Command Utilities');
        $this->addArgument('option', InputArgument::REQUIRED, 'Gammu Command [see: http://wammu.eu/docs/manual/gammu/]');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $processor = new GammuCommandProcessor($this->getContainer());
        $processor->setCommand($input->getArgument('option'));

        $output->writeln($processor->process());
    }
}
