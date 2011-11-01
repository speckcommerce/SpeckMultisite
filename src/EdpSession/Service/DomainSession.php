<?php

namespace EdpSession\Service;

use Zend\Session\Container as SessionContainer,
    Zend\Http\PhpEnvironment\Response as HttpResponse,
    Zend\EventManager\StaticEventManager;

class DomainSession
{
    protected $options;
    protected $hostname;
    protected $app;

    public function __construct($options = null)
    {
        $this->options = $options;
    }

    public function initializeSession($e)
    {
        $this->app = $e->getParam('application');
        $request = $this->app->getRequest();
        $this->hostname = $request->uri()->getHost();
        $locator = $this->app->getLocator();
        $sessionManager = $locator->get('session-manager');
        SessionContainer::setDefaultManager($sessionManager);
        if ($request->query()->session !== null) {
            var_dump($request->query()->redirect);
            die();
        }
        if ($request->query()->sid) {
            if ($request->query()->sid !== $sessionManager->getId()) {
                $this->newSession($request->query()->sid);
            }
        } else {
            $this->newSession();
        }
    }

    public function newSession($sid = null)
    {
        $sessionManager = SessionContainer::getDefaultManager();
        if ($sid !== null) {
            $sessionManager->setId($sid);
            $container = new SessionContainer('EdpSession');
            if ($container->valid !== true) {
                $sessionManager->destroy();
                die('Invalid session ID given');
                // go fetch valid session id
            }
        } else {
            $this->fetchMasterSession();
            // go fetch valid session id
            $sessionManager->regenerateId();
            $container = new SessionContainer('EdpSession');
            $container->valid = true;
        }
    }

    public function fetchMasterSession()
    {
        if ($this->isMasterHost() === false) {
            $masterHost = $this->getMasterHost();
            $uri = $this->app->getRequest()->uri();
            $this->app->events()->attach('dispatch', function($e) use ($masterHost, $uri) {
                $response = new HttpResponse();
                $response->headers()->addHeaderLine('Location', 'http://' . $masterHost  . '/?session&redirect='. (string) $uri);
                $response->setStatusCode(302);
                $response->send();die();
                return $response;
            }, 9999);
        }
    }

    public function isMasterHost()
    {
        return ($this->hostname === $this->getMasterHost());
    }

    public function getMasterHost()
    {
        $groupName = $this->options->hosts->{$this->hostname};
        return $this->options->groups->{$groupName}->master;
    }
}
