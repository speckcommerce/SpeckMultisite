<?php

return array(
    'SpeckMultisite.serviceConfiguration' => array(
        'groups' => array(
            'groupName' => array(
                'master' => 'mydomain.tld',
            )
        ),
        'hosts'  => array(
            'mydomain.tld'       => 'groupName',
            'myotherdomain.tld'     => 'groupName',
        ),
    ),
    'SpeckMultisite.sessionConfiguration'                     => array(
        //'cookieDomain' => '.mydomain.tld',
    ),
);
