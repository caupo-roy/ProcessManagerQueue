<?php

namespace Caupo\ProcessManagerQueueBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ProcessManagerQueueExtension extends Extension
{
    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->registerResources('process_manager_queue', $config['driver'], $config['resources'], $container);

        $bundles = $container->getParameter('kernel.bundles');

        if (array_key_exists('ProcessManagerBundle', $bundles)) {
            $config['pimcore_admin']['js']['process_manager'] = '/bundles/importdefinitions/pimcore/js/process_manager/import_definitions.js';
            $loader->load('process_manager.yml');
        }

        // if (array_key_exists('CoreShopCoreBundle', $bundles)) {
        //     $config['pimcore_admin']['js']['coreshop_interpreter_price'] = '/bundles/importdefinitions/pimcore/js/coreshop/interpreter/price.js';
        //     $config['pimcore_admin']['js']['coreshop_interpreter_stores'] = '/bundles/importdefinitions/pimcore/js/coreshop/interpreter/stores.js';
        //     $config['pimcore_admin']['js']['coreshop_setter_storePrice'] = '/bundles/importdefinitions/pimcore/js/coreshop/setter/storePrice.js';

        //     $loader->load('coreshop.yml');
        // }

        $this->registerPimcoreResources('process_manager_queue', $config['pimcore_admin'], $container);
        
        $loader->load('services.yml');
    }
}
