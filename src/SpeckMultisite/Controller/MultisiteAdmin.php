<?php

namespace SpeckMultisite\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class MultisiteAdmin extends AbstractActionController
{
    protected $adminService;

    public function indexAction()
    {
    }

    /**
     * @return adminService
     */
    public function getAdminService()
    {
        if (null === $this->adminService) {
            $this->adminService = $this->getServiceLocator()->get('multisite_admin_service');
        }
        return $this->adminService;
    }

    /**
     * @param $adminService
     * @return self
     */
    public function setAdminService($adminService)
    {
        $this->adminService = $adminService;
        return $this;
    }
}
