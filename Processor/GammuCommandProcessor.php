<?php
namespace Symfonian\Indonesia\GammuBundle\Processor;

/**
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: http://blog.khodam.org
 */

use Symfony\Component\Process\Process;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GammuCommandProcessor extends AbstractProcessor implements ProcessorInterface
{
    protected $command;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container, $container->getParameter('symfonian_id.gammu.gammurc.default'));
    }

    public function setCommand($command)
    {
        $this->command = $command;
    }

    public function process()
    {
        $gammuPath = $this->container->getParameter('symfonian_id.gammu.gammu_path');

        $process = new Process(sprintf('%s -c %s --%s', $gammuPath, $this->config, $this->command));
        $process->run();

        if (! $process->isSuccessful() && $process->getErrorOutput()) {
            throw \RuntimeException($process->getErrorOutput());
        }

        return $process->getOutput();
    }
}