<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 25.05.16
 * Time: 06:02
 */

namespace DirectAdminCommands;


class DNSAdmin extends CommandAbstract
{
    public function __construct($url, $adminName, $adminPassword, $clientName = null)
    {
        $this->setCommand('CMD_API_DNS_ADMIN');
        parent::__construct($url, $adminName, $adminPassword, $clientName);
    }

    /**
     * CMD_API_DNS_ADMIN
     * method: GET or POST
     *
     * domain=domain.com
     * action=exists
     *
     * result: exists=1 or exists=0
     * else error=1&details=some text
     *
     *
     * Note:
     * This checks the dns (named.conf), so it's only looking to see if the zone exists.
     * The domain itself may not be on the server.
     *
     * Also, if the Multi Server Setup is enabled, and "Domain Check" is enabled, this will also check the dns in all remote servers specific on the M.S.S. page.
     * https://www.directadmin.com/features.php?id=532
     *
     * @param $domain
     *
     * @return bool
     */
    public function exists($domain)
    {
        $this->send(
            [
                'domain' => $domain,
                'action' => 'exists'
            ]
        );
        $this->validateResponse();
        $bodyContents = $this->response->getBody()->getContents();
        $data = [];
        parse_str($this->decodeResponse($bodyContents), $data);
        return $data['exists'] === "1";
    }

    /**
     * Ability to pass the entire zone file (domain.com.db).
     *
     * CMD_API_DNS_ADMIN
     * method: POST
     *
     * GET values:
     * domain=domain.com
     * action=rawsave
     *
     * POST value:
     *
     * the plaintext domain.com.db file.
     *
     * This will not trigger the dns_write_post.sh.
     * It will also not trigger dns clustering (to prevent loops)
     *
     * This function will also add the domain to the named.conf if it doesn't exist
     * https://www.directadmin.com/features.php?id=531
     *
     * @param $domain
     * @param $zoneContents
     *
     * @throws \Exception
     */
    public function rawSave($domain, $zoneContents)
    {
        // TODO implement DNSAdmin->rawSave()
        throw new \Exception('Function not implemented!');
    }
}
