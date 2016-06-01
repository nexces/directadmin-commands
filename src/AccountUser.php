<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 17.05.16
 * Time: 13:36
 */

namespace DirectAdminCommands;

use DirectAdminCommands\Exception\BadCredentialsException;
use DirectAdminCommands\Exception\GenericException;

class AccountUser extends CommandAbstract
{
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
        $this->command = 'CMD_API_ACCOUNT_USER';

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
        $this->command = 'CMD_API_ACCOUNT_USER';

        $this->send(
            [
                'action'   => 'delete',
                'username' => $username
            ]
        );

        return true;
    }

    /**
     * Tests wheather provided credentials are valid
     * https://www.directadmin.com/features.php?id=530
     *
     * @return bool
     */
    public function loginTest()
    {
        $this->command = 'CMD_API_LOGIN_TEST';
        try {
            $this->send([]);
            return true;
        } catch (BadCredentialsException $e) {
            return false;
        }
    }

    /**
     * Checks whether account exists
     * https://www.directadmin.com/features.php?id=1274
     *
     * @param $accountName string
     *
     * @return bool
     * @throws \DirectAdminCommands\Exception\GenericException
     */
    public function exists($accountName)
    {
        $this->command = 'CMD_API_USER_EXISTS';
        $this->send(
            [
                'user' => $accountName
            ]
        );
        $bodyContents = $this->response->getBody()->getContents();
        $data = [];
        parse_str($this->decodeResponse($bodyContents), $data);
        if (!array_key_exists('exists', $data)) {
            throw new GenericException('Malformed response', 0, null, $this->response, $bodyContents, $data);
        }
        return $data['exists'] == 1;
    }
}
