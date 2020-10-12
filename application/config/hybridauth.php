<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['hybridauth'] = [
    'callback' => 'http://onlinetraining.mz/socialconnect/auth/Google/',
    'providers' => [
        'Google' => [
            'enabled' => true,
            'keys' => [
                'id'     => '1035051390977-4h6pcc65vscg7nagnmbmasdld8lkl1m2.apps.googleusercontent.com',
                'secret' => '_fDI-jgYOYjD_wAFMZGc9eIa',
            ]
        ],
	],
	
	'debug_mode' => ENVIRONMENT === 'development',
	'debug_file' => APPPATH . 'logs/hybridauth.log',

];