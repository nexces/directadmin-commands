<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 09.06.16
 * Time: 09:59
 */

namespace DirectAdminCommands\ValueObject;

/**
 * Class ResellerPackageAccountSpec
 *
 * @package DirectAdminCommands\ValueObject
 */
class ResellerPackageAccountSpec extends ResellerAccountSpec
{
    /**
     * @var string
     */
    protected $package;

    /**
     * ResellerPackageAccountSpec constructor.
     *
     * @param string  $username
     * @param string  $email
     * @param string  $password
     * @param boolean $notify
     * @param string  $domain
     * @param string  $ip
     * @param string  $package
     */
    public function __construct($username, $email, $password, $notify, $domain, $ip, $package)
    {
        parent::__construct($username, $email, $password, $notify, $domain, $ip);
        $this->package = $package;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $params = parent::toArray();
        $params['package'] = $this->package;
        return $params;
    }
}
