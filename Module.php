<?php

namespace SpeckMultisite;

use SpeckMultisite\Service\Session;
use SpeckMultisite\Service\DomainResolver;
use Zend\Config\Config;
use Zend\EventManager\EventInterface;
use Zend\Session\Config\SessionConfig;
use Zend\Session\SessionManager;
use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements
        AutoloaderProviderInterface,
        BootstrapListenerInterface,
        ConfigProviderInterface,
        ServiceProviderInterface
{

    protected $serviceLocator;

    public function init($mm)
    {
        $mm->getEventManager()->attach(
            ModuleEvent::EVENT_LOAD_MODULES_POST, array($this, 'loadAdditionalModules')
        );
    }

    public function onBootstrap(EventInterface $mvcEvent)
    {
        $speckSessionService = $mvcEvent->getApplication()->getServiceManager()->get('SpeckMultisite/Service/Session');
        $speckSessionService->initializeSession($mvcEvent);
    }

    public function loadAdditionalModules(EventInterface $e)
    {
        $sm     = $e->getParam('ServiceManager');
        $domain = $sm->get('multisite_domain_data');

        if (isset($domain['additional_modules'])) {
            return;
        }

        $mm = $sm->get('ModuleManager');
        foreach($domain['additional_modules'] as $module) {
            $mm->loadModule($module);
        }
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

    public function getServiceConfig()
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
                    $service->resolveSiteDomain($sm->get('request'));

                    return $service;
                },

                'SpeckMultisite/SessionManager' => function ($sm) {
                    $sessConf = $sm->get('SpeckMultisite/Configuration')->Session->sessionManagerConfiguration;

                    $sessionConf = new SessionConfig($sessConf->toArray());
                    $service     = new SessionManager($sessionConf);

                    return $service;
                },
                'SpeckMultisite/Configuration' => function ($sm) {
                    $config = $sm->get('config');

                    return isset($config['SpeckMultisite']) ? new Config($config['SpeckMultisite']) : new Config(array());
                },
                'multisite_domain_data' => function ($sm) {
                    $config  = $sm->get('SpeckMultisite/Configuration');
                    $domain  = $sm->get('SpeckMultisite/Service/DomainResolver')->getDomain();
                    $domains = $config->get('domain_data');
                    return ($domains->get($domain)->toArray()) ? : array();
                },
            ),
        );
    }
}
