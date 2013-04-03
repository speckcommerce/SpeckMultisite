<?php

return array(
    'service_manager' => array(
        'invokables' => array(
            'multisite_admin_service' => 'SpeckMultisite\Service\AdminService',
            'multisite_admin_mapper'  => 'SpeckMultisite\Mapper\AdminMapper',
        ),
    ),
    'navigation' => array(
        'admin' => array(
            'sites' => array(
                'label' => 'Sites',
                'route' => 'zfcadmin/sites',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'multisite_admin' => 'SpeckMultisite\Controller\MultisiteAdmin',
        ),
    ),
    'router' => array(
        'routes' => array(
            'zfcadmin' => array(
                'child_routes' => array(
                    'sites' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/sites',
                            'defaults' => array(
                                'controller' => 'multisite_admin',
                                'action' => 'index'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view'
        ),
    ),
    'SpeckMultisite' => array(
        'Session' => array(
            'domainMap' => array(
                'groups' => array(
                    'groupName' => array(
                        'master' => null,
                    )
                ),
                'hosts'  => array(
                ),
            ),
            'sessionManagerConfiguration' => array(
            //'cookieDomain' => '.tld.nl',
            ),
        ),
        'DomainResolver' => array(
            'domainMap' => array(
            )
        ),
        'domain_data' => array(
            'SPECKCOMMERCE' => array(
                'name' => 'SPECKCOMMERCE',
                'display_name' => 'SpeckCommerce',
                'additional_modules' => array(
                    //'MyDomainLayoutModule',
                ),
            ),
        )
    )
);
