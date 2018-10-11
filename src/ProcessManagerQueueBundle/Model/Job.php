<?php
/**
 */

namespace ProcessManagerQueueBundle\Model;

use Pimcore\Logger;
use Pimcore\Model\AbstractModel;

class Job extends AbstractModel implements JobInterface
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $executableId;

    /**
     * @var int
     */
    public $scheduledDate;

    /**
     * @var array
     */
    public $settings;

    /**
     * @var int
     */
    public $blocking;

    /**
     * @var int
     */
    public $status;

    /**
     * @param string      $name
     */
    public function __construct(
        string $name, 
        int $executableId,
        int $scheduledDate,
        array $settings,
        bool $blocking,
        int $status
    )
    {
        $this->name = $name;
        $this->executableId = $executableId;
        $this->scheduledDate = $scheduledDate;
        $this->settings = $settings;
        $this->blocking = $blocking;
        $this->status = $status;
    }

    /**
     * get Log by id
     *
     * @param $id
     * @return null|Process
     */
    public static function getById($id)
    {
        try {
            $reflection = new \ReflectionClass(get_called_class());
            $obj = $reflection->newInstanceWithoutConstructor();
            $obj->getDao()->getById($id);
            return $obj;
        } catch (\Exception $ex) {

        }

        return null;
    }

    // /**
    //  * {@inheritdoc}
    //  */
    // public function delete()
    // {
    //     $registry = \Pimcore::getContainer()->get('process_manager.registry.process_handler_factories');

    //     if ($this->getType() && $registry->has($this->getType())) {
    //         $registry->get($this->getType())->cleanup($this);
    //     }
    //     else {
    //         \Pimcore::getContainer()->get('process_manager.default_handler_factory')->cleanup($this);
    //     }

    //     parent::delete();
    // }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getExecutableId()
    {
        return $this->executableId;
    }

    /**
     * @param int $executableId
     */
    public function setExecutableId($executableId)
    {
        $this->executableId = $executableId;
    }

    /**
     * @return int
     */
    public function getScheduledDate()
    {
        return $this->scheduledDate;
    }

    /**
     * @param int $scheduledDate
     */
    public function setScheduledDate($scheduledDate)
    {
        $this->scheduledDate = $scheduledDate;
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param array $settings
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return int
     */
    public function getBlocking()
    {
        return $this->blocking;
    }

    /**
     * @param int $blocking
     */
    public function setBlocking($blocking)
    {
        $this->blocking = $blocking;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

}
