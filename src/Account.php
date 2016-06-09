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
use DirectAdminCommands\ValueObject\AccountSpec;
use DirectAdminCommands\ValueObject\AdminAccountSpec;
use DirectAdminCommands\ValueObject\ResellerAccountSpec;
use DirectAdminCommands\ValueObject\UserAccountSpec;

/**
 * Class Account
 *
 * @package DirectAdminCommands
 */
class Account extends CommandAbstract
{
    /**
     * @param \DirectAdminCommands\ValueObject\AccountSpec $accountSpec
     *
     * @return bool
     * @throws \DirectAdminCommands\Exception\BadCredentialsException
     * @throws \DirectAdminCommands\Exception\GenericException
     * @throws \DirectAdminCommands\Exception\MalformedRequestException
     */
    public function create(AccountSpec $accountSpec)
    {
        $params = $accountSpec->toArray();
        $params['action'] = 'create';
        $params['add'] = 'Submit';
        if ($accountSpec instanceof AdminAccountSpec) {
            $this->command = 'CMD_API_ACCOUNT_ADMIN';
        } elseif ($accountSpec instanceof ResellerAccountSpec) {
            $this->command = 'CMD_API_ACCOUNT_RESELLER';
        } elseif ($accountSpec instanceof UserAccountSpec) {
            $this->command = 'CMD_API_ACCOUNT_USER';
        } else {
            throw new \UnexpectedValueException(
                'Account specification should be one of: AdminAccountSpec, ResellerAccountSpec, UserAccountSpec'
            );
        }
        $this->send($params);
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
        $user = $this->info($username);

        $this->method = 'POST';

        switch ($user['usertype']) {
            case 'user':
                $this->command = 'CMD_API_ACCOUNT_USER';
                break;
            case 'reseller':
                $this->command = 'CMD_API_ACCOUNT_RESELLER';
                break;
            case 'admin':
                $this->command = 'CMD_API_ACCOUNT_ADMIN';
                break;
            default:
                $this->command = 'CMD_API_SELECT_USERS';
        }
        $this->send(
            [
                'action'   => 'delete',
                'delete'   => 'yes',
                'username' => $username
            ]
        );

        return true;
    }

    /**
     * Tests whether provided credentials are valid
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

    /**
     * Returns account information
     *
     * A version of CMD_API_SHOW_USER_CONFIG for the user so that he can see his own data.
     * Just don't pass any "user=name" value and it will show your own user data from his user.conf file.
     * Can be called by Users.
     *
     * https://www.directadmin.com/features.php?id=389
     * @param null|string $username
     *
     * @return array
     */
    public function info($username = null)
    {
        $this->command = 'CMD_API_SHOW_USER_CONFIG';
        $params = ['both' => 'yes'];
        if ($username !== null) {
            $params['user'] = $username;
        }
        $this->send($params);
        $bodyContents = $this->response->getBody()->getContents();
        $data = [];
        parse_str($this->decodeResponse($bodyContents), $data);
        if (array_key_exists('usage', $data)) {
            $usage = [];
            parse_str($data['usage'], $usage);
            $data['usage'] = $usage;
        }

        return $data;
    }

    /**
     * To get the list of Users currently owned by this reseller. If value reseller is passed, the list of Users
     * created by that Reseller will be shown instead
     *
     * @param null|string $reseller
     *
     * @return array|mixed
     */
    public function listUsers($reseller = null)
    {
        $this->command = 'CMD_API_SHOW_USERS';
        $params = [];
        if ($reseller !== null) {
            $params['reseller'] = $reseller;
        }
        $this->send($params);
        $data = [];
        $bodyContents = $this->response->getBody()->getContents();
        $bodyContents = $this->decodeResponse($bodyContents);
        parse_str($bodyContents, $data);
        if (array_key_exists('list', $data)) {
            $data = $data['list'];
        }

        return $data;
    }

    /**
     * To get the list of all the Users currently on the server.
     *
     * @return array|mixed
     */
    public function listAll()
    {
        $this->command = 'CMD_API_SHOW_ALL_USERS';
        $this->send();
        $data = [];
        $bodyContents = $this->response->getBody()->getContents();
        $bodyContents = $this->decodeResponse($bodyContents);
        parse_str($bodyContents, $data);
        if (array_key_exists('list', $data)) {
            $data = $data['list'];
        }

        return $data;
    }

    /**
     * To get the list of Resellers currently on the server.
     *
     * @return array|mixed
     */
    public function listResellers()
    {
        $this->command = 'CMD_API_SHOW_RESELLERS';
        $this->send();
        $data = [];
        $bodyContents = $this->response->getBody()->getContents();
        $bodyContents = $this->decodeResponse($bodyContents);
        parse_str($bodyContents, $data);
        if (array_key_exists('list', $data)) {
            $data = $data['list'];
        }

        return $data;
    }

    /**
     * To get the list of Admins currently on the server.
     *
     * @return array|mixed
     */
    public function listAdmins()
    {
        $this->command = 'CMD_API_SHOW_ADMINS';
        $this->send();
        $data = [];
        $bodyContents = $this->response->getBody()->getContents();
        $bodyContents = $this->decodeResponse($bodyContents);
        parse_str($bodyContents, $data);
        if (array_key_exists('list', $data)) {
            $data = $data['list'];
        }

        return $data;
    }

    /**
     * @param string $username
     *
     * @return bool
     * @throws \DirectAdminCommands\Exception\BadCredentialsException
     * @throws \DirectAdminCommands\Exception\GenericException
     * @throws \DirectAdminCommands\Exception\MalformedRequestException
     */
    public function suspend($username)
    {
        $this->command = 'CMD_API_SELECT_USERS';
        $this->method = 'POST';
        $this->send(
            [
                'location' => 'CMD_SELECT_USERS', // <- seriously????!! O.o
                'dosuspend' => 'yes',
                'select0' => $username
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
    public function resume($username)
    {
        $this->command = 'CMD_API_SELECT_USERS';
        $this->method = 'POST';
        $this->send(
            [
                'location' => 'CMD_SELECT_USERS', // <- seriously????!! O.o
                'dounsuspend' => 'yes',
                'select0' => $username
            ]
        );
        $this->validateResponse();

        return true;
    }
}
