<?php

namespace Symfonian\Indonesia\GammuBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class SymfonianIndonesiaGammuExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('symfonian_id.gammu.smsd_inject_path', $config['smsd_inject_path']);
        $container->setParameter('symfonian_id.gammu.gammu_path', $config['gammu_path']);

        foreach ($config['smsdrc_path'] as $key => $smsdrc) {
            $container->setParameter('symfonian_id.gammu.smsdrc.'.$key, $smsdrc['path']);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
