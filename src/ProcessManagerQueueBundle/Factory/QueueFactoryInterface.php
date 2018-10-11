<?php
/**
 */

namespace ProcessManagerQueueBundle\Factory;

use CoreShop\Component\Resource\Factory\FactoryInterface;

use ProcessManagerQueueBundle\Model\Queue;

interface QueueFactoryInterface extends FactoryInterface
{
    /**
     * @param string    $name
     * @param int       $executable
     * @param string    $scheduledDate
     * @param array     $settings
     * @param bool      $blocking
     * @param int       $status
     * @return mixed
     */
    public function createQueue(
        string $name, 
        int $executableId,
        int $scheduledDate,
        array $settings,
        bool $blocking,
        int $status=Queue::STATUS_SCHEDULED
    );
}