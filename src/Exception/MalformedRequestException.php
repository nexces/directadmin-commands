<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 25.05.16
 * Time: 09:00
 */

namespace DirectAdminCommands\Exception;

use Exception;
use GuzzleHttp\Message\ResponseInterface;

/**
 * Class MalformedRequestException
 *
 * @package DirectAdminCommands\Exception
 */
class MalformedRequestException extends \Exception
{
    private $response = null;

    /**
     * @return \GuzzleHttp\Message\ResponseInterface|null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * MalformedRequestException constructor.
     *
     * @param string                                     $message
     * @param int                                        $code
     * @param \Exception|null                            $previous
     * @param \GuzzleHttp\Message\ResponseInterface|null $response
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null, ResponseInterface $response = null)
    {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
    }
}
