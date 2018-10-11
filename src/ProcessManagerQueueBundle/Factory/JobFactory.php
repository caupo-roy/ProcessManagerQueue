<?php
/**
 */

namespace ProcessManagerQueueBundle\Factory;

use ProcessManagerQueueBundle\Model\Job;

class JobFactory implements JobFactoryInterface
{
    /**
     * @var string
     */
    private $model;

    /**
     * @param string $model
     */
    public function __construct(string $model)
    {
        $this->model = $model;
    }

    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        throw new \InvalidArgumentException('use createJob instead');
    }

    /**
     * {@inheritdoc}
     */
    public function createJob(
        string $name, 
        int $executableId,
        int $scheduledDate,
        array $settings,
        bool $blocking,
        int $status=Job::STATUS_SCHEDULED

    ) {
        return new $this->model(
            $name, 
            $executableId,
            $scheduledDate,
            $settings,
            $blocking,
            $status
        );
    }
}