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
use DirectAdminCommands\Exception\MalformedRequestException;
use DirectAdminCommands\ValueObject\AccountSpec;
use DirectAdminCommands\ValueObject\AdminAccountSpec;
use DirectAdminCommands\ValueObject\ResellerAccountSpec;
use DirectAdminCommands\ValueObject\UserAccountSpec;
use Exception;
use UnexpectedValueException;

/**
 * Class Account
 *
 * @package DirectAdminCommands
 */
class Account extends CommandAbstract
{
    /**
     * @param AccountSpec $accountSpec
     *
     * @return bool
     * @throws BadCredentialsException
     * @throws GenericException
     * @throws MalformedRequestException
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
            throw new UnexpectedValueException(
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
     * @throws BadCredentialsException
     * @throws GenericException
     * @throws MalformedRequestException
     */
    public function delete($username)
    {
        /*
         * This call is due to bug described at http://forum.directadmin.com/showthread.php?t=39710
         * CMD_API_SELECT_USERS throws "Unkown Select Command" on any action.
         * info() gets information about user type and we can use precise command to delete user
         */
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
     * @throws GenericException
     */
    public function exists($accountName)
    {
        $this->command = 'CMD_API_USER_EXISTS';
        try {
            $this->send(
                [
                    'user' => $accountName
                ]
            );
        } catch (GenericException $e) {
            $data = $this->getParsedResponse();
            if ($data['error'] == 1 && $data['text'] === 'reserved username') {
                // for reserved accounts return information that account exists
                return true;
            } else {
                throw $e;
            }
        }
        $data = $this->getParsedResponse();

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
        $data = $this->getParsedResponse();
        if (array_key_exists('usage', $data)) {
            parse_str($data['usage'], $data['usage']);
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
        $data = $this->getParsedResponse();
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
        $data = $this->getParsedResponse();
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
        $data = $this->getParsedResponse();
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
        $data = $this->getParsedResponse();
        if (array_key_exists('list', $data)) {
            $data = $data['list'];
        }

        return $data;
    }

    /**
     * Defunct!
     *
     * @param string $username
     *
     * @return bool
     * @throws BadCredentialsException
     * @throws GenericException
     * @throws MalformedRequestException
     */
    public function suspend($username)
    {
        $this->command = 'CMD_API_SELECT_USERS';
        $this->method = 'POST';
        $this->send(
            [
                'location' => 'CMD_SELECT_USERS', // <- seriously????!! O.o
                'dosuspend' => 'yes',
                'select0' => $username,
                'reason' => 'none'
            ]
        );
        $this->validateResponse();

        return true;
    }

    /**
     * Defunct!
     *
     * @param string $username
     *
     * @return bool
     * @throws BadCredentialsException
     * @throws GenericException
     * @throws MalformedRequestException
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

    /**
     * @param $username
     * @param $bandwidth
     * @return bool
     * @throws BadCredentialsException
     * @throws MalformedRequestException
     * @throws GenericException
     * @throws Exception
     */
    public function addTemporaryBandwidth($username, $bandwidth)
    {
        $this->command = 'CMD_API_MODIFY_USER';
        $this->method = 'POST';
        $this->send(
            [
                'additional_bandwidth' => $bandwidth,
                'additional_bw' => 'anything',
                'action' => 'single',
                'user' => $username
            ]
        );
        $this->validateResponse();

        return true;
    }
}

