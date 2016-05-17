<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 17.05.16
 * Time: 11:38
 */

namespace DirectAdminCommands;


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

    public function send($params = [])
    {
        if (!$this->domain) {
            throw new \BadMethodCallException('No domain specified');
        }
        $params = array_replace_recursive(['domain' => $this->domain], $params);
        parent::send($params);
    }


    public function getRecords()
    {
        $this->send();

        $body = $this->response->getBody()
            ->getContents();

        // data parse
        $domainRecords = array_fill_keys($this->supportedRecords, []);

        foreach ($domainRecords as $domainRecordType => $domainRecordTypeContent) {
            $regex = '/(.*)\s+\d+\s+IN\s+' . $domainRecordType . '\s+(.*)/';
            $matches = [];
            preg_match_all($regex, $body, $matches, PREG_SET_ORDER);
            foreach ($matches as $key => $match) {
                $domainRecords[$domainRecordType][$key] = [
                    'key'   => strtolower($domainRecordType) . 'recs' . $key,
                    'name'  => $match[1],
                    'value' => $match[2]
                ];
            }
        }

        return $domainRecords;
    }

    public function addRecord($type, $name, $value)
    {
        $type = strtoupper($type);
        if (!in_array($type, $this->supportedRecords)) {
            throw new \InvalidArgumentException('Unsupported record type');
        }

        $this->send(
            [
                'action' => 'add',
                'type'   => $type,
                'name'   => $name,
                'value'  => $value
            ]
        );

        return true;
    }

    public function deleteRecord($type, $name, $value)
    {
        $type = strtoupper($type);
        if (!in_array($type, $this->supportedRecords)) {
            throw new \InvalidArgumentException('Unsupported record type');
        }

        // query records
        $records = $this->getRecords();

        $record = false;

        // find the one we're trying to drop
        foreach ($records[$type] as $record) {
            if ($record['name'] == $name && $record['value'] == $value) {
                break;
            }
        }
        if (!is_array($record)) {
            throw new \OutOfBoundsException('Record not found');
        }
        $params = [
            'action'       => 'select',
            $record['key'] =>
                    'name=' . $record['name'] . '&' .
                    'value=' . $record['value']
        ];
        $this->send($params);

        return true;
    }
}
