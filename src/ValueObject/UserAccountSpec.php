<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 09.06.16
 * Time: 10:21
 */

namespace DirectAdminCommands\ValueObject;

/**
 * Class UserAccountSpec
 *
 * @package DirectAdminCommands\ValueObject
 */
abstract class UserAccountSpec extends AccountSpec
{
    /**
     * https://www.directadmin.com/features.php?id=1500
     */
    const ACCOUNT_IP_SERVER = 'server';
    const ACCOUNT_IP_SHARED = 'shared';
    const ACCOUNT_IP_ASSIGN = 'assign';

    /**
     * @var string
     */
    protected $domain;
    /**
     * @var string
     */
    protected $ip;

    /**
     * UserAccountSpec constructor.
     *
     * @param string  $username
     * @param string  $email
     * @param string  $password
     * @param boolean $notify
     * @param string  $domain
     * @param string  $ip Can use ACCOUNT_IP_ constants instead of actual IP
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
