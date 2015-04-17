<?php
namespace Symfonian\Indonesia\GammuBundle\Processor;

/**
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: http://blog.khodam.org
 */

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractProcessor implements ProcessorInterface
{
    protected $config;

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container, $config)
    {
        $this->container = $container;
        $this->config = $config;
    }

    public function setConfigPath($path)
    {
        $this->config = $path;
    }
}
