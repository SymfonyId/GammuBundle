<?php
namespace Symfonian\Indonesia\GammuBundle\Processor;

/**
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: http://blog.khodam.org
 */

use Symfony\Component\Process\Process;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SendSMSProcessor extends AbstractProcessor implements ProcessorInterface
{
    protected $receiver;

    protected $message;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container, $container->getParameter('symfonian_id.gammu.smsdrc.default'));
    }

    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function process()
    {
        $smsdPath = $this->container->getParameter('symfonian_id.gammu.smsd_inject_path');

        $format = 'TEXT';
        if (strlen($this->message) > 153) {
            $format = 'EMS';
        }

        $process = new Process(sprintf('%s -c %s %s %s -text %s', $smsdPath, $this->config, $format, $this->receiver, $this->message));
        $process->run();

        if (! $process->isSuccessful() && $process->getErrorOutput()) {
            throw \RuntimeException($process->getErrorOutput());
        }

        return $process->getOutput();
    }
}
