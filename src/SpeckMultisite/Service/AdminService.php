<?php

namespace SpeckMultisite\Service;

class AdminService
{
    protected $mapper;

    public function getAllSites()
    {
        return $this->getMapper()->getAllSites();
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
    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }
}
