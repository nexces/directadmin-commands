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
     * No DNS will be created
     */
    const CUSTOM_DNS_OFF = 'OFF';
    /**
     * Domain will use same IP as NS1, NS2 will use second IP
     */
    const CUSTOM_DNS_DOMAIN_ON_NS1 = 'TWO';
    /**
     * Domain, NS1, NS2 on separate addresses
     */
    const CUSTOM_DNS_DOMAIN_SEPARATE = 'THREE';

    /**
     * IP will be shared with main server
     */
    const ACCOUNT_IP_SHARED = 'shared';
    /**
     * IP will be shared with reseller IP
     */
    const ACCOUNT_IP_SHARED_RESELLER = 'sharedreseller';
    /**
     * IP will be assigned from free pool
     */
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
