<?php

namespace Symfonian\Indonesia\GammuBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class SymfonianIndonesiaGammuExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $fileSystem = new Filesystem();

        $container->setParameter('symfonian_id.gammu.smsd_inject_path', $config['smsd_inject_path']);
        $container->setParameter('symfonian_id.gammu.gammu_path', $config['gammu_path']);

        foreach ($config['gammurc_path'] as $key => $gammurc) {
            if ($fileSystem->exists($gammurc['path'])) {
                throw new FileNotFoundException(sprintf('%s not found.'));
            }

            if (! $container->hasParameter('symfonian_id.gammu.gammurc.default')) {
                $container->setParameter('symfonian_id.gammu.gammurc.default', $gammurc['path']);
            }

            $container->setParameter('symfonian_id.gammu.gammurc.'.$key, $gammurc['path']);
        }

        foreach ($config['smsdrc_path'] as $key => $smsdrc) {
            if (! $fileSystem->exists($smsdrc['path'])) {
                throw new FileNotFoundException(sprintf('%s not found.', $smsdrc['path']));
            }

            if (! $container->hasParameter('symfonian_id.gammu.smsdrc.default')) {
                $container->setParameter('symfonian_id.gammu.smsdrc.default', $smsdrc['path']);
            }

            $container->setParameter('symfonian_id.gammu.smsdrc.'.$key, $smsdrc['path']);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
