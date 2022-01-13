<?php

namespace GalDigitalGmbh\PimcoreQrcodeBundle\DependencyInjection;

use GalDigitalGmbh\PimcoreQrcodeBundle\Model\QrCode\Dao;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class PimcoreQrcodeExtension extends ConfigurableExtension implements PrependExtensionInterface
{
    /**
     * @param array<mixed> $mergedConfig
     * @param ContainerBuilder $container
     *
     * @return void
     */
    public function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $container->setParameter('pimcore_qrcode', $mergedConfig);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }

    /**
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container): void
    {
        if ($container->hasExtension('doctrine_migrations')) {
            $loader = new YamlFileLoader(
                $container,
                new FileLocator(__DIR__ . '/../Resources/config')
            );

            $loader->load('doctrine_migrations.yaml');
        }

        $configDir = Dao::CONFIG_PATH;
        if (is_dir($configDir)) {
            $configLoader = new YamlFileLoader(
                $container,
                new FileLocator($configDir)
            );
            $finder = new Finder();
            $finder->files()->in($configDir)->name(['*.yml', '*.yaml']);
            foreach ($finder as $config) {
                $configLoader->load($config);
            }
        }
    }
}
