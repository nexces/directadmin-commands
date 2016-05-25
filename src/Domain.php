<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 25.05.16
 * Time: 10:37
 */

namespace DirectAdminCommands;

/**
 * Class Domain
 *
 * https://www.directadmin.com/features.php?id=498
 *
 * @package DirectAdminCommands
 */
class Domain extends CommandAbstract
{
    /**
     * Issues CMD_API_DOMAIN to create domain
     *
     * @param string $domain
     * @param int    $bandwidth integer, in meg, eg 12345
     * @param int    $quota     integer, in meg, eg 12345
     * @param bool   $ssl
     * @param bool   $cgi
     * @param bool   $php
     *
     * @return bool
     * @throws \DirectAdminCommands\Exception\BadCredentialsException
     * @throws \DirectAdminCommands\Exception\GenericException
     * @throws \DirectAdminCommands\Exception\MalformedRequestException
     */
    public function create($domain, $bandwidth = -1, $quota = -1, $ssl = true, $cgi = true, $php = true)
    {
        if (!is_int($bandwidth)) {
            throw new \UnexpectedValueException('Bandwidth must be integer');
        }
        if (!is_int($quota)) {
            throw new \UnexpectedValueException('Quota must be integer');
        }
        $this->command = 'CMD_API_DOMAIN';

        $params = [
            'action' => 'create',
            'domain' => $domain,
            'ssl'    => $ssl ? 'ON' : 'OFF',
            'cgi'    => $cgi ? 'ON' : 'OFF',
            'php'    => $php ? 'ON' : 'OFF'
        ];
        if ($bandwidth > -1) {
            $params['bandwidth'] = $bandwidth;
        } else {
            $params['ubandwidth'] = 'unlimited';
        }
        if ($quota > -1) {
            $params['quota'] = $quota;
        } else {
            $params['uquota'] = 'unlimited';
        }
        $this->send($params);
        $this->validateResponse();

        return true;
    }

    /**
     * Issues CMD_API_DOMAIN to modify domain
     *
     * @param string $domain
     * @param int    $bandwidth integer, in meg, eg 12345
     * @param int    $quota     integer, in meg, eg 12345
     * @param bool   $ssl
     * @param bool   $cgi
     * @param bool   $php
     *
     * @return bool
     * @throws \DirectAdminCommands\Exception\BadCredentialsException
     * @throws \DirectAdminCommands\Exception\GenericException
     * @throws \DirectAdminCommands\Exception\MalformedRequestException
     */
    public function modify($domain, $bandwidth = -1, $quota = -1, $ssl = true, $cgi = true, $php = true)
    {
        $this->command = 'CMD_API_DOMAIN';

        if (!is_int($bandwidth)) {
            throw new \UnexpectedValueException('Bandwidth must be integer');
        }
        if (!is_int($quota)) {
            throw new \UnexpectedValueException('Quota must be integer');
        }
        $params = [
            'action' => 'modify',
            'domain' => $domain,
            'ssl'    => $ssl ? 'ON' : 'OFF',
            'cgi'    => $cgi ? 'ON' : 'OFF',
            'php'    => $php ? 'ON' : 'OFF'
        ];
        if ($bandwidth > -1) {
            $params['bandwidth'] = $bandwidth;
        } else {
            $params['ubandwidth'] = 'unlimited';
        }
        if ($quota > -1) {
            $params['quota'] = $quota;
        } else {
            $params['uquota'] = 'unlimited';
        }

        $this->send($params);
        $this->validateResponse();

        return true;
    }

    /**
     * Issues CMD_API_CHANGE_DOMAIN to change domain name
     * https://www.directadmin.com/features.php?id=694
     *
     * @param $domain
     * @param $newName
     *
     * @return bool
     * @throws \DirectAdminCommands\Exception\BadCredentialsException
     * @throws \DirectAdminCommands\Exception\GenericException
     * @throws \DirectAdminCommands\Exception\MalformedRequestException
     */
    public function rename($domain, $newName)
    {
        $this->command = 'CMD_API_CHANGE_DOMAIN';
        $this->method = 'POST';
        $this->send(
            [
                'old_domain' => $domain,
                'new_domain' => $newName
            ]
        );
        $this->validateResponse();

        return true;
    }

    /**
     * Issues CMD_API_DOMAIN to delete domain
     *
     * @param string $domain
     *
     * @return bool
     * @throws \DirectAdminCommands\Exception\BadCredentialsException
     * @throws \DirectAdminCommands\Exception\GenericException
     * @throws \DirectAdminCommands\Exception\MalformedRequestException
     */
    public function delete($domain)
    {
        $this->command = 'CMD_API_DOMAIN';

        $this->method = 'POST';
        $params = [
            'delete'    => 'anything',
            'select0'   => $domain,
            'confirmed' => 'anything'
        ];
        $this->send($params);
        $this->validateResponse();

        return true;
    }

    /**
     * Issues CMD_API_SHOW_DOMAINS which returns domain list for user
     *
     * @return string[]
     * @throws \DirectAdminCommands\Exception\BadCredentialsException
     * @throws \DirectAdminCommands\Exception\GenericException
     * @throws \DirectAdminCommands\Exception\MalformedRequestException
     */
    public function listAll()
    {
        $this->command = 'CMD_API_SHOW_DOMAINS';
        $this->send([]);
        $this->validateResponse();

        $data = [];
        $bodyContents = $this->response->getBody()
            ->getContents();
        $bodyContents = $this->decodeResponse($bodyContents);
        parse_str($bodyContents, $data);

        return $data['list'];
    }
}
