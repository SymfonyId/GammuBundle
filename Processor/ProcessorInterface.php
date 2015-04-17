<?php
namespace Symfonian\Indonesia\GammuBundle\Processor;

/**
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: http://blog.khodam.org
 */

interface ProcessorInterface
{
    public function setConfigPath($path);

    public function process();
}
