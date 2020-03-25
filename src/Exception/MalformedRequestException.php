<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 25.05.16
 * Time: 09:00
 */

namespace DirectAdminCommands\Exception;

use Exception;
use GuzzleHttp\Psr7\Response;

/**
 * Class MalformedRequestException
 *
 * @package DirectAdminCommands\Exception
 */
class MalformedRequestException extends Exception
{
    private $response = null;

    /**
     * @return Response|null
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
     * @param Exception|null                            $previous
     * @param Response|null $response
     */
    public function __construct($message = '', $code = 0, Exception $previous = null, Response $response = null)
    {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
    }
}
