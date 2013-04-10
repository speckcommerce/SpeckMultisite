<?php


namespace SpeckMultisite\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class MultisiteAdmin extends AbstractActionController
{
    protected $adminService;

    public function indexAction()
    {
        $domain = $this->getServiceLocator()->get('ServiceManager')->get('multisite_domain_data');
        $sites = $this->getAdminService()->getAllSites();
        $data = $this->getServiceLocator()->get('Config')['SpeckMultisite']['domain_data'];
        $return = array();
        foreach($sites as $i => $site) {
            $return[$site['name']] = (array_key_exists($site['name'], $data))
                ? var_export($data[$site['name']], 1)
                : '';
        }
        return array('sites' => $return, 'current' => $domain);
    }

    public function addSiteAction()
    {
        $prg = $this->prg('zfcadmin/sites/add');

        if ($prg instanceof Response) {
            return $prg;
        } else if ($prg === false) {
            return $this->redirect()->toRoute('zfcadmin/sites');
        }

        $form = new \Zend\Form\Form;
        $form->add(array('name' => 'name', 'type' => 'text'));
        $form->setData($prg);

        if($form->isValid()) {
            $this->getAdminService()->addSite($form->getData());
        }

        return $this->redirect()->toRoute('zfcadmin/sites');
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
