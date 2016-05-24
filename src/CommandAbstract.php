<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 17.05.16
 * Time: 11:35
 */

namespace DirectAdminCommands;

use DirectAdminCommands\Exception\BadCredentialsException;
use GuzzleHttp\Client;
use GuzzleHttp\Message\ResponseInterface;

abstract class CommandAbstract
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;
    
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var string
     */
    protected $command;
    
    private $url;
    private $adminName;
    private $adminPassword;
    private $clientName;

    /**
     * DaCommandAbstract constructor.
     *
     * @param      $url           string
     * @param      $adminName     string
     * @param      $adminPassword string
     * @param null $clientName    string
     *
     */
    public function __construct($url, $adminName, $adminPassword, $clientName = null)
    {
        $this->url = $url;
        $this->adminName = $adminName;
        $this->adminPassword = $adminPassword;
        $this->clientName = $clientName;

        $this->client = new Client(
            [
                'base_url' => ($this->url),
                'timeout'  => 2.0,
                'defaults' => [
                    'verify' => false,
                    'auth'   => [
                        $clientName ? join('|', [$adminName, $clientName]) : $adminName,
                        $adminPassword
                    ]
                ],
            ]
        );

        return $this;
    }

    public function impersonate($clientName)
    {
        $this->clientName = $clientName;
        $this->client->setDefaultOption(
            'auth',
            [
                $clientName ? join('|', [$this->adminName, $clientName]) : $this->adminName,
                $this->adminPassword
            ]
        );
        
        return $this;
    }
    
    /**
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function getRawResponse()
    {
        return $this->response;
    }

    /**
     * @throws \Exception
     */
    protected function validateResponse()
    {
        if ($this->response->getHeader('Content-Type') === 'text/html' && $this->response->getHeader(
                'X-DirectAdmin'
            ) === 'unauthorized'
        ) {
            throw new BadCredentialsException('Bad credentials!');
        }

        if ($this->response->getHeader('Content-Type') !== 'text/plain') {
            throw new \UnexpectedValueException('Unknown error! ' . print_r($this->response, 1));
        }
        $body = $this->response->getBody();
        $body->seek(0);
        if ($body->read(6) === 'error=' && $body->read(1) !== '0') {
            $body->seek(0);
            $bodyContents = $body->getContents();
            $body->seek(0);
            $data = [];
            parse_str($this->decodeResponse($bodyContents), $data);
            throw new Exception\GenericException('Unknown error!', 0, null, $bodyContents, $data);
        }
        $body->seek(0);
    }

    public function send(array $params = [])
    {
        $this->response = null;
        if (!$this->command) {
            throw new \BadMethodCallException('No command specified');
        }
        $this->response = $this->client->get(
            '/' . $this->command,
            [
                'query' => $params
            ]
        );

        $this->validateResponse();
    }
    
    protected function setCommand($command)
    {
        $this->command = $command;
    }
    
    protected function decodeResponse($string)
    {
        $string = preg_replace_callback('/&#([0-9]{2})/', function($val) {
            return chr($val[1]); }, $string);
        return $string;
    }
}
