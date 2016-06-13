<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 17.05.16
 * Time: 11:38
 */

namespace DirectAdminCommands;


use DirectAdminCommands\ValueObject\DNSRecord;
use DirectAdminCommands\ValueObject\DNSZoneData;

/**
 * Class DNSControl
 *
 * @package DirectAdminCommands
 */
class DNSControl extends CommandAbstract
{
    private $supportedRecords = [
        'A',
        'NS',
        'MX',
        'CNAME',
        'PTR',
        'TXT',
        'AAAA',
        'SRV'
    ];

    private $domain;

    /**
     * DNSControl constructor.
     *
     * @param string $url
     * @param string $adminName
     * @param string $adminPassword
     * @param null   $clientName
     */
    public function __construct($url, $adminName, $adminPassword, $clientName = null)
    {
        parent::__construct($url, $adminName, $adminPassword, $clientName);

        return $this;
    }

    /**
     * @param mixed $domain
     *
     * @return $this
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @param array $params
     */
    public function send(array $params = [])
    {
        if (!$this->domain) {
            throw new \BadMethodCallException('No domain specified');
        }
        $params = array_replace_recursive(['domain' => $this->domain], $params);
        parent::send($params);
    }

    /**
     * Returns all zone data
     * @return \DirectAdminCommands\ValueObject\DNSZoneData
     */
    public function getRecords()
    {
        $this->command = 'CMD_API_DNS_CONTROL';

        $this->send();

        $body = $this->response->getBody()
            ->getContents();

        $zone = new DNSZoneData($body);

        return $zone;
    }

    /**
     * Adds new record
     * @param \DirectAdminCommands\ValueObject\DNSRecord $record
     *
     * @return bool
     */
    public function addRecord(DNSRecord $record)
    {
        $this->command = 'CMD_API_DNS_CONTROL';

        if (!in_array($record->getType(), $this->supportedRecords)) {
            throw new \InvalidArgumentException('Unsupported record type');
        }
        if ($record->getType() === 'MX') {
            list($val1, $val2) = explode(' ', $record->getValue());
            $this->send(
                [
                    'action'   => 'add',
                    'type'     => $record->getType(),
                    'name'     => $record->getName(),
                    'value'    => $val1,
                    'mx_value' => $val2
                ]
            );
        } else {
            $this->send(
                [
                    'action' => 'add',
                    'type'   => $record->getType(),
                    'name'   => $record->getName(),
                    'value'  => $record->getValue()
                ]
            );
        }

        return true;
    }

    /**
     * Deletes single record
     * @param \DirectAdminCommands\ValueObject\DNSRecord $record
     *
     * @return bool
     */
    public function deleteRecord(DNSRecord $record)
    {
        if (!in_array($record->getType(), $this->supportedRecords)) {
            throw new \InvalidArgumentException('Unsupported record type');
        }

        return $this->deleteRecords([$record]);
    }

    /**
     * Deletes multiple records in one call
     * @param \DirectAdminCommands\ValueObject\DNSRecord[] $records
     *
     * @return bool
     * @throws \DirectAdminCommands\Exception\BadCredentialsException
     * @throws \DirectAdminCommands\Exception\GenericException
     * @throws \DirectAdminCommands\Exception\MalformedRequestException
     */
    public function deleteRecords($records)
    {
        $this->command = 'CMD_API_DNS_CONTROL';

        if (!is_array($records)) {
            throw new \UnexpectedValueException('Array required but "' . gettype($records) . '" was given');
        }
        if (count($records) === 0) {
            return true;
        }
        $params = [
            'action' => 'select'
        ];
        foreach ($records as $record) {
            if ($record->getKey() === '') {
                throw new \UnexpectedValueException('Provided record does not have required "key" value set');
            }
            $params[$record->getKey()] = 'name=' . $record->getName() . '&' . 'value=' . $record->getValue();
        }
        $this->send($params);
        $this->validateResponse();

        return true;
    }

    /**
     * Sets TTL for zone
     * @param int|null $ttl
     *
     * @return bool
     * @throws \DirectAdminCommands\Exception\BadCredentialsException
     * @throws \DirectAdminCommands\Exception\GenericException
     * @throws \DirectAdminCommands\Exception\MalformedRequestException
     */
    public function setTtl($ttl = null)
    {
        $this->command = 'CMD_API_DNS_CONTROL';

        $params = [
            'action' => 'ttl'
        ];
        if (is_int($ttl)) {
            $params['ttl_select'] = 'custom';
            $params['ttl'] = $ttl;
        } else {
            $params['ttl_select'] = 'default';
        }

        $this->send($params);
        $this->validateResponse();

        return true;
    }

    /**
     * Checks whether domain name is configured in named.conf - requires admin privileges
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
     * @return bool
     * @throws \DirectAdminCommands\Exception\BadCredentialsException
     * @throws \DirectAdminCommands\Exception\GenericException
     * @throws \DirectAdminCommands\Exception\MalformedRequestException
     */
    public function exists()
    {
        $this->command = 'CMD_API_DNS_ADMIN';
        $this->send(
            [
                'action' => 'exists'
            ]
        );
        $this->validateResponse();
        $data = $this->getParsedResponse();
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
        // TODO implement DNSControl->rawSave()
        throw new \Exception('Function not implemented! ' . $domain . $zoneContents);
    }
}
