<?php
/**
 */

namespace ProcessManagerQueueBundle\DependencyInjection;

use CoreShop\Bundle\ResourceBundle\Controller\ResourceController;
use CoreShop\Bundle\ResourceBundle\CoreShopResourceBundle;
use CoreShop\Component\Resource\Factory\Factory;
use ProcessManagerQueueBundle\Controller\JobController;
use ProcessManagerQueueBundle\Factory\JobFactory;
use ProcessManagerQueueBundle\Model\Job;
use ProcessManagerQueueBundle\Model\JobInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('process_manager_queue');

        $rootNode
            ->children()
                ->scalarNode('driver')->defaultValue(CoreShopResourceBundle::DRIVER_PIMCORE)->end()
            ->end()
        ;

        $this->addPimcoreResourcesSection($rootNode);
        $this->addModelsSection($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addModelsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('resources')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('job')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Job::class)->cannotBeEmpty()->end()
                                        ->scalarNode('interface')->defaultValue(JobInterface::class)->cannotBeEmpty()->end()
                                        ->scalarNode('admin_controller')->defaultValue(JobController::class)->cannotBeEmpty()->end()
                                        ->scalarNode('factory')->defaultValue(JobFactory::class)->cannotBeEmpty()->end()
                                        ->scalarNode('repository')->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addPimcoreResourcesSection(ArrayNodeDefinition $node)
    {
        $node->children()
            ->arrayNode('pimcore_admin')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('js')
                        ->addDefaultsIfNotSet()
                        ->ignoreExtraKeys(false)
                        ->children()
                            ->scalarNode('startup')->defaultValue('/bundles/processmanagerqueue/pimcore/js/startup.js')->end()
                            ->scalarNode('panel')->defaultValue('/bundles/processmanagerqueue/pimcore/js/process_manager/panel.js')->end()
                            ->scalarNode('queue')->defaultValue('/bundles/processmanagerqueue/pimcore/js/queue.js')->end()
                            // ->scalarNode('portlet')->defaultValue('/bundles/processmanagerqueue/pimcore/js/portlet.js')->end()
                        ->end()
                    ->end()
                    ->arrayNode('css')
                        ->addDefaultsIfNotSet()
                        ->ignoreExtraKeys(false)
                        ->children()
                            ->scalarNode('process_manager_queue')->defaultValue('/bundles/processmanagerqueue/pimcore/css/processmanagerqueue.css')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();
    }
}
