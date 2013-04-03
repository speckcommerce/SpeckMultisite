<?php

namespace SpeckMultisite\Mapper;

use Zend\Db\Resultset\ResultSet;
use Zend\Db\Adapter\AdapterAwareInterface;

class AdminMapper extends ZfcBase\Mapper\AbstractDbMapper
    implements AdapterAwareInterface
{
    protected $tableName = 'website';

    public function initialize()
    {
        if ($this->isInitialized) {
            return;
        }

        if (!$this->dbAdapter instanceof Adapter) {
            throw new \Exception('No db adapter present');
        }

        $this->isInitialized = true;
    }

    public function getAll()
    {
        $select = $this->getSelect();
        return $this->select($select);
    }

    public function insert(array $data)
    {

    }

    public function update(array $data)
    {
    }

    public function delete(array $data)
    {
    }

    public function select($select)
    {
        $this->initialize();

        $stmt = $this->getSlaveSql()->prepareStatementForSqlObject($select);

        $resultSet = new ResultSet;
        $resultSet->initialize($stmt->execute());

        return $resultSet;
    }


}
