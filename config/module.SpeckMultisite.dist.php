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
        ),
        'domain_data' => array(
            'MYDOMAIN' => array(
                'name' => 'MYDOMAIN',
                'display_name' => 'My Domain',
                'data' => array(
                    //'global_var' = 'foo',
                    //'MyModule' => array(
                    //    'mymodule_somevar' => 'bar',
                    //),
                ),
            ),
            'OTHERDOMAIN' => array(
                'name' => 'OTHERDOMAIN',
                'display_name' => 'Other Domain',
                'data' => array(
                    //'global_var' = 'foo',
                    //'MyModule' => array(
                    //    'mymodule_somevar' => 'bar',
                    //),
                ),
            ),
        )
    )
);
