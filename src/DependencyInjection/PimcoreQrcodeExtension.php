<?php declare(strict_types = 1);

namespace GalDigitalGmbh\PimcoreQrcodeBundle\DependencyInjection;

use Pimcore\Bundle\CoreBundle\DependencyInjection\ConfigurationHelper;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

final class PimcoreQrcodeExtension extends ConfigurableExtension implements PrependExtensionInterface
{
    /**
     * @param array<mixed> $mergedConfig
     */
    public function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $container->setParameter('pimcore_qrcode', $mergedConfig);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        if ($container->hasExtension('doctrine_migrations')) {
            $loader = new YamlFileLoader(
                $container,
                new FileLocator(__DIR__ . '/../Resources/config')
            );

            $loader->load('doctrine_migrations.yaml');
        }

        $containerConfig = ConfigurationHelper::getConfigNodeFromSymfonyTree($container, 'pimcore_qrcode');
        $configDir = $containerConfig['config_location']['qrcode']['write_target']['options']['directory'];
        $configLoader = new YamlFileLoader(
            $container,
            new FileLocator($configDir)
        );
        $configs = ConfigurationHelper::getSymfonyConfigFiles($configDir);
        foreach ($configs as $config) {
            $configLoader->load($config);
        }
    }
}
