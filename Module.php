<?php

namespace SpeckMultisite;

use SpeckMultisite\Service\Session,
    SpeckMultisite\Service\DomainResolver,
    Zend\Config\Config,
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
        $speckSessionService = $mvcEvent->getApplication()->getServiceManager()->get('SpeckMultisite/Service/Session');
        $speckSessionService->initializeSession($mvcEvent);

        $speckDomainResolverService = $mvcEvent->getApplication()->getServiceManager()->get('SpeckMultisite/Service/DomainResolver');
        $speckDomainResolverService->resolveSiteDomain($mvcEvent->getApplication()->getRequest());
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
                'SpeckMultisite/Service/Session' => function ($sm) {
                    $service     = new Session();
                    $service->setDomainMap($sm->get('SpeckMultisite/Configuration')->Session->domainMap);

                    return $service;
                },
                'SpeckMultisite/Service/DomainResolver' => function ($sm) {
                    $service = new DomainResolver();

                    $service->setDomainMap($sm->get('SpeckMultisite/Configuration')->DomainResolver->domainMap);
                    return $service;
                },

                'SpeckMultisite/SessionManager' => function ($sm) {
                    $sessConf = $sm->get('SpeckMultisite/Configuration')->Session->sessionManagerConfiguration;

                    $sessionConf = new \Zend\Session\Configuration\SessionConfiguration($sessConf->toArray());
                    $service     = new \Zend\Session\SessionManager($sessionConf);

                    return $service;
                },
                'SpeckMultisite/Configuration' => function ($sm) {
                    $config = $sm->get('config');

                    return isset($config['SpeckMultisite']) ? new Config($config['SpeckMultisite']) : new Config(array());
                }
            ),
        );
    }
}
