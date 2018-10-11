<?php

namespace ProcessManagerQueueBundle\DependencyInjection\Compiler;

use CoreShop\Bundle\PimcoreBundle\DependencyInjection\Compiler\RegisterSimpleRegistryTypePass;

final class QueueHandlerFactoryTypeRegistryCompilerPass extends RegisterSimpleRegistryTypePass
{
    public function __construct()
    {
        parent::__construct(
            'process_manager_queue.registry.queue_handler_factories',
            'process_manager_queue.queue_handler_factories',
            'process_manager_queue.queue_handler_factory'
        );
    }
}
