<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 17.05.16
 * Time: 13:36
 */

namespace DirectAdminCommands;

class AccountUser extends CommandAbstract
{
    public function __construct($url, $adminName, $adminPassword, $clientName = null)
    {
        $this->command = 'CMD_API_ACCOUNT_USER';
        parent::__construct($url, $adminName, $adminPassword, $clientName);

        return $this;
    }

    /**
     * @param      $username
     * @param      $email
     * @param      $password
     * @param      $domain
     * @param      $package
     * @param      $ip
     * @param bool $notify
     *
     * @return bool
     */
    public function create($username, $email, $password, $domain, $package, $ip, $notify = true)
    {
        $this->send(
            [
                'action'   => 'create',
                'username' => $username,
                'email'    => $email,
                'passwd'   => $password,
                'passwd2'  => $password,
                'domain'   => $domain,
                'package'  => $package,
                'ip'       => $ip,
                'notify'   => $notify ? 'yes' : 'no'
            ]
        );

        return true;
    }

    public function delete($username)
    {
        $this->send(
            [
                'action'   => 'delete',
                'username' => $username
            ]
        );

        return true;
    }
}
