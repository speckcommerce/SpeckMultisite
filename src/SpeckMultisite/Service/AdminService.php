<?php

namespace SpeckMultisite\Service;

use ZfcBase\Mapper\AbstractDbMapper;

class AdminService
{
    protected $mapper;

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
