<?php

namespace ProcessManagerQueueBundle\Model;

use CoreShop\Component\Resource\Model\ResourceInterface;

interface JobInterface extends ResourceInterface
{
    const STATUS_SCHEDULED  = 1;
    const STATUS_RUNNING    = 2;
    const STATUS_COMPLETED  = 3;
    
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return int
     */
    public function getExecutableId();

    /**
     * @param int $executableId
     */
    public function setExecutableId($executableId);

    /**
     * @return int
     */
    public function getScheduledDate();

    /**
     * @param int $scheduledDate
     */
    public function setScheduledDate($scheduledDate);

    /**
     * @return array
     */
    public function getSettings();

    /**
     * @param array $settings
     */
    public function setSettings($settings);

    /**
     * @return int
     */
    public function getBlocking();

    /**
     * @param int $blocking
     */
    public function setBlocking($blocking);

    /**
     * @return int
     */
    public function getStatus();

    /**
     * @param int $status
     */
    public function setStatus($status);

}