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

    /**
     * Returns array of owners of domains [domain_name => owner]
     *
     * dump the /etc/virtual/domainowners file.
     *
     * Outputs a standard list:
     * domain.com=user&domain2.com=user2&...
     *
     * if an Admin calls it, he'll get all the domains.
     *
     * If a Reseller calls it, he'll get the domains/users that he controls (including himself).
     *
     * @return array
     */
    public function owners()
    {
        $this->command = 'CMD_API_DOMAIN_OWNERS';
        $this->send([]);
        $data = [];
        $bodyContents = $this->response->getBody()
            ->getContents();
        $bodyContents = $this->decodeResponse($bodyContents);
        parse_str($bodyContents, $data);
        $fixedDomains = [];
        foreach ($data as $key => $value) {
            $fixedDomains[str_replace('_', '.', $key)] = $value;
        }

        return $fixedDomains;
    }

    /**
     * Returns owner of a given domain
     *
     * Relating to:
     * http://www.directadmin.com/features.php?id=579
     *
     * You can now specify a specific domain, eg:
     * CMD_API_DOMAIN_OWNERS?domain=domain.com
     *
     * which will make the CMD_API_DOMAIN_OWNERS filter out all other domains, giving you just:
     * domain.com=username
     *
     * Both Admin and Resellers can run this, but the Reseller can only do lookups on domains under their control (including their Users)
     *
     * If a domain does not exist, an error is returned, eg:
     * error=1&text=Cannot find that domain&details=
     * https://www.directadmin.com/features.php?id=1684
     * @param string $domain
     *
     * @return string
     */
    public function owner($domain) {
        $this->command = 'CMD_API_DOMAIN_OWNERS';
        $params = [
            'domain' => $domain
        ];
        $this->send($params);
        $data = [];
        $bodyContents = $this->response->getBody()
            ->getContents();
        $bodyContents = $this->decodeResponse($bodyContents);
        parse_str($bodyContents, $data);
        $fixedDomains = [];
        foreach ($data as $key => $value) {
            $fixedDomains[str_replace('_', '.', $key)] = $value;
        }
        return $fixedDomains[$domain];
    }
}
