<?php

namespace EdpSession\Controller;

use Zend\Mvc\Controller\ActionController;

class SessionController extends ActionController
{
    public function indexAction()
    {
        $request = $this->getRequest();
        var_dump($request->headers());die();
    }
}
