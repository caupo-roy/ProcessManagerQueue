<?php

namespace ProcessManagerQueueBundle\DependencyInjection\Compiler;

use CoreShop\Bundle\PimcoreBundle\DependencyInjection\Compiler\RegisterSimpleRegistryTypePass;

final class QueueTypeRegistryCompilerPass extends RegisterSimpleRegistryTypePass
{
    public function __construct()
    {
        parent::__construct(
            'process_manager_queue.registry.queue',
            'process_manager_queue.queues',
            'process_manager_queue.queue'
        );
    }
}
