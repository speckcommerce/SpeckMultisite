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
        $ms = $mvcEvent->getApplication()->getServiceManager()->get('EdpSession.Service');
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
                    'EdpSession' => __DIR__ . '/src/EdpSession',
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
                'EdpSession.Service' => function ($sm) {
                    $serviceConf = new Config($sm->get('EdpSession.serviceConfiguration'));
                    $service     = new \EdpSession\Service\DomainSession($serviceConf);

                    return $service;
                },
                'EdpSession.SessionManager' => function ($sm) {
                    $sessionConf = new \Zend\Session\Configuration\SessionConfiguration($sm->get('EdpSession.sessionConfiguration'));
                    $service     = new \Zend\Session\SessionManager($sessionConf);

                    return $service;
                },
                'EdpSession.serviceConfiguration' => function ($sm) {
                    $config = $sm->get('config');

                    return $config['EdpSession.serviceConfiguration'];
                },
                'EdpSession.sessionConfiguration' => function ($sm) {
                    $config = $sm->get('config');

                    return $config['EdpSession.sessionConfiguration'];
                },
            ),
        );
    }
}
