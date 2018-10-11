<?php
/**
 */

namespace ProcessManagerQueueBundle\Model\Job;

use Pimcore\Model\Dao\AbstractDao;
use Pimcore\Tool\Serialize;

class Dao extends AbstractDao
{

    protected $tableName = 'process_manager_queue_jobs';

    /**
     * get log by id
     *
     * @param null $id
     * @throws \Exception
     */
    public function getById($id = null)
    {
        if ($id != null) {
            $this->model->setId($id);
        }

        $data = $this->db->fetchRow('SELECT * FROM '.$this->tableName.' WHERE id = ?', [$this->model->getId()]);

        if (!$data["id"]) {
            throw new \Exception("Job with the ID " . $this->model->getId() . " doesn't exists");
        }

        $this->assignVariablesToModel($data);
    }

    /**
     * @param array $data
     */
    protected function assignVariablesToModel($data)
    {
        foreach($data as $key => &$value) {
            if($key === "settings") {
                $value = Serialize::unserialize($value);
            }
            if($key === "active") {
                $value = boolval($value);
            }
        }

        $this->model->setValues($data);
    }

    /**
     * save log
     *
     * @throws \Exception
     */
    public function save()
    {
        $vars = get_object_vars($this->model);

        $buffer = [];

        $validColumns = $this->getValidTableColumns($this->tableName);

        if (count($vars)) {
            foreach ($vars as $k => $v) {
                if (!in_array($k, $validColumns)) {
                    continue;
                }

                $getter = "get" . ucfirst($k);

                if (!is_callable([$this->model, $getter])) {
                    continue;
                }

                $value = $this->model->$getter();

                if (is_bool($value)) {
                    $value = (int)$value;
                }
                if(is_array($value)) {
                    $value = Serialize::serialize($value);
                }

                $buffer[$k] = $value;
            }
        }

        if ($this->model->getId() !== null) {
            $this->db->update($this->tableName, $buffer, ['id' => $this->model->getId()]);
            return;
        }

        $this->db->insert($this->tableName, $buffer);
        $this->model->setId($this->db->lastInsertId());
    }

    /**
     * delete job
     */
    public function delete()
    {
        $this->db->delete($this->tableName, ['id' => $this->model->getId()]);
    }
}
