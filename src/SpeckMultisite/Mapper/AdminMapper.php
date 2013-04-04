<?php

namespace SpeckMultisite\Mapper;

use Zend\Db\Resultset\ResultSet;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Stdlib\Hydrator\HydratorInterface;

class AdminMapper extends AbstractDbMapper implements AdapterAwareInterface
{
    protected $dbAdapter;
    protected $tableName = 'website';
    protected $isInitialized = false;

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

    public function getAllSites()
    {
        $select = $this->getSelect();
        return $this->select($select);
    }

    public function insert($data, $tableName=null, HydratorInterface $hydrator=null)
    {
        $this->initialize();
        $tableName = $tableName ?: $this->tableName;

        $sql = $this->getSql()->setTable($tableName);
        $insert = $sql->insert();

        $insert->values($data);

        $statement = $sql->prepareStatementForSqlObject($insert);

        return $statement->execute();
    }

    public function update($data, $where=null, $tableName=null, HydratorInterface $hydrator=null)
    {
    }

    public function delete($where, $tableName=null)
    {
    }

    public function select(Select $select, $entityPrototype=null, HydratorInterface $hydrator=null)
    {
        $this->initialize();

        $stmt = $this->getSlaveSql()->prepareStatementForSqlObject($select);

        $resultSet = new ResultSet;
        $resultSet->initialize($stmt->execute());

        return $resultSet->toArray();
    }



    /**
     * @return dbAdapter
     */
    public function getDbAdapter()
    {
        return $this->dbAdapter;
    }

    /**
     * @param $dbAdapter
     * @return self
     */
    public function setDbAdapter(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        return $this;
    }
}
