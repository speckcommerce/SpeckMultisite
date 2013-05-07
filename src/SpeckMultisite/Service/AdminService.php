<?php

namespace SpeckMultisite\Service;

use ZfcBase\Mapper\AbstractDbMapper;

class AdminService
{
    protected $mapper;

    public function find(array $data)
    {
        $where = array();

        if (isset($data['website_id'])) {
            $where['website_id'] = $data['website_id'];
        }
        if (isset($data['name'])) {
            $where['name'] = $data['name'];
        }

        return $this->getMapper()->find($where);
    }

    public function findByName($name)
    {
        $result = $this->getMapper()->find(array('name' => $name));
        return isset($result[0]) ? $result[0] : null;
    }


    public function getAllSites()
    {
        return $this->getMapper()->getAllSites();
    }

    public function addSite($data)
    {
        return $this->getMapper()->insert($data);
    }

    /**
     * @return mapper
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * @param $mapper
     * @return self
     */
    public function setMapper(AbstractDbMapper $mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }
}
