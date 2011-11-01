<?php
return array(
    'session' => array(
        'groups' => array(
            'skeleton' => array(
                'master' => 'zendskeletonapplication.dev',
            ),
        ),
        'hosts' => array(
            'zendskeletonapplication.dev'      => 'skeleton',
            'test.zendskeletonapplication.dev' => 'skeleton',
        ),
    ),
    'di' => array(
        'instance' => array(
            'alias' => array(
                'session-manager' => 'Zend\Session\SessionManager',
                'session'         => 'EdpSession\Controller\SessionController',
            ),
            'session-manager' => array(
                'parameters' => array(
                    'name' => 'test',
                    'config' => 'Zend\Session\Configuration\SessionConfiguration',
                ),
            ),
            'Zend\Session\Configuration\SessionConfiguration' => array(
                'parameters' => array(
                    //'cookieDomain' => '.mydomain.tld',
                ),
            ),
        ),
    ),
);
