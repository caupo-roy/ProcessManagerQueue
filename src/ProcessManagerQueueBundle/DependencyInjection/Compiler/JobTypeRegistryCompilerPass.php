<?php

namespace ProcessManagerQueueBundle\DependencyInjection\Compiler;

use CoreShop\Bundle\PimcoreBundle\DependencyInjection\Compiler\RegisterSimpleRegistryTypePass;

final class JobTypeRegistryCompilerPass extends RegisterSimpleRegistryTypePass
{
    public function __construct()
    {
        parent::__construct(
            'process_manager_queue.registry.job',
            'process_manager_queue.jobs',
            'process_manager_queue.job'
        );
    }
}
