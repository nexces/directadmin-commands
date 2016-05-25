<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 25.05.16
 * Time: 05:41
 */

namespace DirectAdminCommands;


class DomainOwners extends CommandAbstract
{
    public function __construct($url, $adminName, $adminPassword, $clientName = null)
    {
        $this->setCommand('CMD_API_DOMAIN_OWNERS');
        parent::__construct($url, $adminName, $adminPassword, $clientName);
    }

    /**
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
     *
     * @param string [$domain] optional name of a single domain to check
     *
     * @return array
     */
    public function get($domain = null)
    {
        $params = [];
        if (is_string($domain) && strlen($domain) > 0) {
            $params = [
                'domain' => $domain
            ];
        }
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

        return $fixedDomains;
    }
}
