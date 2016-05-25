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
