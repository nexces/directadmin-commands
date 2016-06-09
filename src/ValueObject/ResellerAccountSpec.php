<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 09.06.16
 * Time: 09:51
 */

namespace DirectAdminCommands\ValueObject;

/**
 * Class ResellerAccountSpec
 *
 * @package DirectAdminCommands\ValueObject
 */
abstract class ResellerAccountSpec extends AccountSpec
{
    /**
     * @var string
     */
    protected $domain;
    /**
     * @var string
     */
    protected $ip;

    /**
     * ResellerAccountSpec constructor.
     *
     * @param string  $username
     * @param string  $email
     * @param string  $password
     * @param boolean $notify
     * @param string  $domain
     * @param string  $ip
     */
    public function __construct($username, $email, $password, $notify, $domain, $ip)
    {
        parent::__construct($username, $email, $password, $notify);
        $this->domain = $domain;
        $this->ip = $ip;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $params = parent::toArray();
        $params['domain'] = $this->domain;
        $params['ip'] = $this->ip;
        return $params;
    }
}
