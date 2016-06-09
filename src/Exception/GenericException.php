<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 24.05.16
 * Time: 13:59
 */

namespace DirectAdminCommands\Exception;


use Exception;
use GuzzleHttp\Message\ResponseInterface;

/**
 * Class GenericException
 *
 * @package DirectAdminCommands\Exception
 */
class GenericException extends \Exception
{
    /**
     * @var string
     */
    private $rawResponse;
    /**
     * @var array
     */
    private $parsedResponse;

    /**
     * @var ResponseInterface
     */
    private $response = null;

    /**
     * GenericException constructor.
     *
     * @param string                                     $message
     * @param int                                        $code
     * @param \Exception|null                            $previous
     * @param \GuzzleHttp\Message\ResponseInterface|null $response
     * @param string                                     $rawResponse
     * @param array                                      $parsedResponse
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null, ResponseInterface $response = null, $rawResponse = '', $parsedResponse = [])
    {
        $this->response = $response;
        $this->rawResponse = $rawResponse;
        $this->parsedResponse = $parsedResponse;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    /**
     * @return array
     */
    public function getParsedResponse()
    {
        return $this->parsedResponse;
    }

    
}
