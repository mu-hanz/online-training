<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Connect extends CI_Controller
{


    public function index()
    {
        $service = new \SocialConnect\Auth\Service(
            $httpStack,
            new \SocialConnect\Provider\Session\Session(),
            $this->config(),
            $collectionFactory
        );

        $collectionFactory = null;

        $service = new \SocialConnect\Auth\Service(
            $httpClient,
            new \SocialConnect\Provider\Session\Session(),
            $this->config(),
            $collectionFactory
        );


        $providerName = 'google';

        $provider = $service->getProvider($providerName);
        header('Location: ' . $provider->makeAuthUrl());

    }


    public function config()
    {
        return [
            'redirectUri' => 'http://localhost:8000/auth/cb/${provider}/',
                'google' => [
                    'applicationId' => '1035051390977-4h6pcc65vscg7nagnmbmasdld8lkl1m2.apps.googleusercontent.com',
                    'applicationSecret' => '_fDI-jgYOYjD_wAFMZGc9eIa',
                    'scope' => [
                        'https://www.googleapis.com/auth/userinfo.email',
                        'https://www.googleapis.com/auth/userinfo.profile'
                    ],
                ],
            ];
    }
}