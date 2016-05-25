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
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $domain
     * @param string $package
     * @param string $ip
     * @param bool   $notify
     *
     * @return bool
     * @throws \DirectAdminCommands\Exception\BadCredentialsException
     * @throws \DirectAdminCommands\Exception\GenericException
     * @throws \DirectAdminCommands\Exception\MalformedRequestException
     */
    public function create($username, $email, $password, $domain, $package, $ip, $notify = true)
    {
        $this->send(
            [
                'action'   => 'create',
                'add'      => 'Submit',
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
        $this->validateResponse();

        return true;
    }

    /**
     * @param string $username
     *
     * @return bool
     * @throws \DirectAdminCommands\Exception\BadCredentialsException
     * @throws \DirectAdminCommands\Exception\GenericException
     * @throws \DirectAdminCommands\Exception\MalformedRequestException
     */
    public function delete($username)
    {
        $this->send(
            [
                'action'   => 'delete',
                'username' => $username
            ]
        );
        $this->validateResponse();

        return true;
    }
}
