<?php

namespace SpeckMultisite;

use Zend\Config\Config,
        Zend\EventManager\Event,
        Zend\ModuleManager\ModuleManager,
    Zend\EventManager\StaticEventManager,
    Zend\ModuleManager\Feature\AutoloaderProviderInterface,
    Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements
        \Zend\ModuleManager\Feature\BootstrapListenerInterface,
                        \Zend\ModuleManager\Feature\ConfigProviderInterface,
                        AutoloaderProviderInterface,
                        ServiceProviderInterface
{

    public function onBootstrap(Event $mvcEvent)
    {
        $ms = $mvcEvent->getApplication()->getServiceManager()->get('SpeckMultisite.Service');
        $ms->initializeSession($mvcEvent);
    }


    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfiguration()
    {
        return array(
            'aliases' => array(
            ),
            'factories' => array(
                'SpeckMultisite.Service' => function ($sm) {
                    $serviceConf = new Config($sm->get('SpeckMultisite.serviceConfiguration'));
                    $service     = new \SpeckMultisite\Service\DomainSession($serviceConf);

                    return $service;
                },
                'SpeckMultisite.SessionManager' => function ($sm) {
                    $sessionConf = new \Zend\Session\Configuration\SessionConfiguration($sm->get('SpeckMultisite.sessionConfiguration'));
                    $service     = new \Zend\Session\SessionManager($sessionConf);

                    return $service;
                },
                'SpeckMultisite.serviceConfiguration' => function ($sm) {
                    $config = $sm->get('config');

                    return $config['SpeckMultisite.serviceConfiguration'];
                },
                'SpeckMultisite.sessionConfiguration' => function ($sm) {
                    $config = $sm->get('config');

                    return $config['SpeckMultisite.sessionConfiguration'];
                },
            ),
        );
    }
}
