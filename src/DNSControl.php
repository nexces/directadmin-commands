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

    public function __construct($url, $adminName, $adminPassword, $clientName = null)
    {
        $this->command = 'CMD_API_DNS_CONTROL';
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

    public function send(array $params = [])
    {
        if (!$this->domain) {
            throw new \BadMethodCallException('No domain specified');
        }
        $params = array_replace_recursive(['domain' => $this->domain], $params);
        parent::send($params);
    }

    /**
     * @return DNSZoneData
     */
    public function getRecords()
    {
        $this->send();

        $body = $this->response->getBody()
            ->getContents();

        $zone = new DNSZoneData($body);

        return $zone;
    }

    public function addRecord(DNSRecord $record)
    {
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

    public function deleteRecord(DNSRecord $record)
    {
        if (!in_array($record->getType(), $this->supportedRecords)) {
            throw new \InvalidArgumentException('Unsupported record type');
        }

        return $this->deleteRecords([$record]);
    }

    /**
     * @param DNSRecord[] $records
     *
     * @return bool
     */
    public function deleteRecords($records)
    {
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

    public function setTtl($ttl = null)
    {
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
}
