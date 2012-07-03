<?php

namespace SpeckMultisite\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class SessionController extends AbstractActionController
{
    public function indexAction()
    {
        $request = $this->getRequest();
        var_dump($request->headers());die();
    }
}
