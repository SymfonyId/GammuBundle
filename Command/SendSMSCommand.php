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
use Symfonian\Indonesia\GammuBundle\Processor\SendSMSProcessor;

class SendSMSCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('symfonyid:sigab:send-sms');
        $this->setDescription('Send SMS using Gammu SMSD');
        $this->addArgument('receiver', InputArgument::REQUIRED, 'Receiver');
        $this->addArgument('message', InputArgument::REQUIRED, 'Message Text');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $processor = new SendSMSProcessor($this->getContainer());
        $processor->setReceiver($input->getArgument('receiver'));
        $processor->setMessage($input->getArgument('message'));

        $output->writeln($processor->process());
    }
}
