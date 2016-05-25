<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 25.05.16
 * Time: 10:11
 */

namespace DirectAdminCommands\ValueObject;


class DNSZoneData
{
    /**
     * @var string
     */
    private $zoneData;

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

    /**
     * @var \DirectAdminCommands\ValueObject\DNSRecord[]
     */
    private $records = [];


    /**
     * DNSZoneData constructor.
     *
     * @param string $zoneData
     */
    public function __construct($zoneData)
    {
        $this->zoneData = $zoneData;

        foreach ($this->supportedRecords as $domainRecordType) {
            $regex = '/(.*)\s+\d+\s+IN\s+' . $domainRecordType . '\s+(.*)/';
            $matches = [];
            preg_match_all($regex, $zoneData, $matches, PREG_SET_ORDER);
            foreach ($matches as $key => $match) {
                $record = new DNSRecord(
                    $domainRecordType, $match[1], $match[2], strtolower($domainRecordType) . 'recs' . $key
                );
                $this->records[] = $record;
            }
        }
    }

    /**
     * Returns DNSRecord[] of given type
     * 
     * @param string $type
     *
     * @return \DirectAdminCommands\ValueObject\DNSRecord[]
     */
    public function getRecordsByType($type)
    {
        $type = strtoupper($type);
        if (!in_array($type, $this->supportedRecords)) {
            throw new \UnexpectedValueException('Unsupported record type');
        }
        $ret = [];
        foreach ($this->records as $record) {
            if ($record->getType() === $type) {
                $ret[] = $record;
            }
        }
        return $ret;
    }

    /**
     * @return \DirectAdminCommands\ValueObject\DNSRecord[]
     */
    public function getAllRecords()
    {
        return $this->records;
    }

}
