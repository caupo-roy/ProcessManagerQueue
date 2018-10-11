<?php
/**
 */

namespace ProcessManagerQueueBundle\Factory;

use CoreShop\Component\Resource\Factory\FactoryInterface;

use ProcessManagerQueueBundle\Model\Job;

interface JobFactoryInterface extends FactoryInterface
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
    public function createJob(
        string $name, 
        int $executableId,
        int $scheduledDate,
        array $settings,
        bool $blocking,
        int $status=Job::STATUS_SCHEDULED
    );
}