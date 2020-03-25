<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 17.05.16
 * Time: 11:35
 */

namespace DirectAdminCommands;

use BadMethodCallException;
use DirectAdminCommands\Exception\BadCredentialsException;
use DirectAdminCommands\Exception\GenericException;
use DirectAdminCommands\Exception\MalformedRequestException;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

/**
 * Class CommandAbstract
 *
 * @package DirectAdminCommands
 */
abstract class CommandAbstract
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var string
     */
    protected $command;

    /**
     * Default method to use in calls
     *
     * @var string
     */
    protected $method = 'GET';

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

        $this->client = $this->getClient();

        return $this;
    }

    /**
     * @param $clientName
     *
     * @return $this
     */
    public function impersonate($clientName)
    {
        $this->clientName = $clientName;
        $this->client = $this->getClient();

        return $this;
    }

    /**
     * @param array $params
     *
     * @throws BadCredentialsException
     * @throws GenericException
     * @throws MalformedRequestException
     */
    public function send(array $params = [])
    {
        $this->response = null;
        if (!$this->command) {
            throw new BadMethodCallException('No command specified');
        }

        $this->response = $this->client->request(
            $this->method,
            '/' . $this->command,
            [
                'query' => $params,
                'auth'   => [
                    $this->clientName ? join('|', [$this->adminName, $this->clientName]) : $this->adminName,
                    $this->adminPassword
                ]
            ]);

        $this->validateResponse();
    }

    /**
     * @throws Exception
     */
    protected function validateResponse()
    {
        $contentType = $this->response->getHeaderLine('Content-Type');
        if ($contentType === 'text/html'
            && strtolower($this->response->getHeaderLine('X-DirectAdmin')) === 'unauthorized'
        ) {
            throw new BadCredentialsException(
                sprintf(
                    'Bad credentials! Could not login as "%s" with "***" at "%s"',
                    $this->clientName ? join('|', [$this->adminName, $this->clientName]) : $this->adminName,
                    $this->url
                )
            );
        }

        if ($contentType !== 'text/plain') {
            throw new MalformedRequestException('We\'re not talking to API!', 0, null, $this->response);
        }
        $body = $this->response->getBody();
        $body->seek(0);
        $bodyContents = $body->getContents();
        $body->seek(0);
        if (substr($bodyContents, 0, 6) === 'error='
            && substr($bodyContents, 6, 1) !== '0'
            && substr($bodyContents, 6, 3) !== '%30'
        ) {
            $data = [];
            parse_str($this->decodeResponse($bodyContents), $data);
            $body->seek(0);
            throw new GenericException(
                'Unknown error! ' . $bodyContents,
                0,
                null,
                $this->response,
                $bodyContents,
                $data
            );
        }
    }

    /**
     * @param $string
     *
     * @return mixed
     */
    protected function decodeResponse($string)
    {
        $string = preg_replace_callback(
            '/&#([0-9]{2})/',
            function ($val) {
                return chr($val[1]);
            },
            $string
        );

        return $string;
    }

    /**
     * Returns parsed API response
     *
     * @return array
     */
    protected function getParsedResponse()
    {
        $body = $this->response->getBody();
        $body->seek(0);
        $bodyContents = $body->getContents();
        $body->seek(0);
        $bodyContents = $this->decodeResponse($bodyContents);
        $data = [];
        parse_str($bodyContents, $data);

        return $data;
    }

    /**
     * @return Client
     */
    private function getClient(): Client
    {
        return new Client(
            [
                'base_uri' => ($this->url),
                'timeout'  => 20.0,

            ]
        );
    }
}
