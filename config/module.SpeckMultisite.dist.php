<?php

return array(
    'EdpSession.serviceConfiguration' => array(
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
    'EdpSession.sessionConfiguration'                     => array(
        //'cookieDomain' => '.mydomain.tld',
    ),
);
