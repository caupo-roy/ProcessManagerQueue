<?php
/**
 */

namespace ProcessManagerQueueBundle\Factory;

use ProcessManagerQueueBundle\Model\Queue;

class QueueFactory implements QueueFactoryInterface
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
        throw new \InvalidArgumentException('use createQueue instead');
    }

    /**
     * {@inheritdoc}
     */
    public function createQueue(
        string $name, 
        int $executableId,
        int $scheduledDate,
        array $settings,
        bool $blocking,
        int $status=Queue::STATUS_SCHEDULED

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