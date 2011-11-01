<?php

namespace EdpSession;

use Zend\Config\Config,
    Zend\Module\Manager,
    Zend\EventManager\StaticEventManager,
    Zend\Loader\AutoloaderFactory;

class Module
{
    public function init(Manager $moduleManager)
    {
        $this->initAutoloader();
        $moduleManager->events()->attach('init.post', array($this, 'prepareSession'));
    }

    public function initAutoloader()
    {
        AutoloaderFactory::factory(array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        ));
    }

    public function getConfig($env = null)
    {
        return new Config(include __DIR__ . '/configs/module.config.php');
    }

    public function prepareSession($e)
    {
        $moduleManager = $e->getTarget();
        $config = $moduleManager->getMergedConfig();
        $sessionService = new Service\DomainSession($config->session);
        $events = StaticEventManager::getInstance();
        $events->attach('bootstrap', 'bootstrap', function($e) use ($sessionService) {
            $sessionService->initializeSession($e);
        });
    }
}
