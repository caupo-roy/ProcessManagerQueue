<?php

namespace ProcessManagerQueueBundle\DependencyInjection\Compiler;

use CoreShop\Bundle\PimcoreBundle\DependencyInjection\Compiler\RegisterSimpleRegistryTypePass;

final class JobHandlerFactoryTypeRegistryCompilerPass extends RegisterSimpleRegistryTypePass
{
    public function __construct()
    {
        parent::__construct(
            'process_manager_queue.registry.job_handler_factories',
            'process_manager_queue.job_handler_factories',
            'process_manager_queue.job_handler_factory'
        );
    }
}
