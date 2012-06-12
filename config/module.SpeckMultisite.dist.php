<?php

return array(
    'SpeckMultisite' => array(
        'Session' => array(
            'domainMap' => array(
                'groups' => array(
                    'groupName' => array(
                        'master' => 'mydomain.tld',
                    )
                ),
                'hosts'  => array(
                    'mydomain.tld'                => 'groupName',
                    'myotherdomain.tld'           => 'groupName',
                ),
            ),
            'sessionManagerConfiguration' => array(
            //'cookieDomain' => '.tld.nl',
            ),
        ),
        'DomainResolver' => array(
            'domainMap' => array(
                'mydomain.tld'      => 'MYDOMAIN',
                'myotherdomain.tld' => 'OTHERDOMAIN',
            )
        )
    )
);
