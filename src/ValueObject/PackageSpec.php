<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 10.06.16
 * Time: 07:21
 */

namespace DirectAdminCommands\ValueObject;

/**
 * Class PackageSpec
 *
 * @package DirectAdminCommands\ValueObject
 */
abstract class PackageSpec
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var boolean
     */
    protected $anonymousFtpEnabled;
    /**
     * @var boolean
     */
    protected $cgiEnabled;
    /**
     * @var boolean
     */
    protected $dnsControlEnabled;
    /**
     * @var integer
     */
    protected $bandwidth;
    /**
     * @var integer
     */
    protected $domainPointers;
    /**
     * @var integer
     */
    protected $ftpAccounts;
    /**
     * @var integer
     */
    protected $mysqlDatabases;
    /**
     * @var integer
     */
    protected $emailForwarders;
    /**
     * @var integer
     */
    protected $mailingLists;
    /**
     * @var integer
     */
    protected $autoResponders;
    /**
     * @var integer
     */
    protected $emails;
    /**
     * @var integer
     */
    protected $subDomains;
    /**
     * @var integer
     */
    protected $quota;
    /**
     * @var boolean
     */
    protected $sslEnabled;
    /**
     * @var boolean
     */
    protected $sshEnabled;
    /**
     * @var boolean
     */
    protected $phpEnabled;
    /**
     * @var integer
     */
    protected $domains;
    /**
     * @var integer
     */
    protected $inodes;
    /**
     * @var boolean
     */
    protected $catchAllCustomizationEnabled;
    /**
     * @var boolean
     */
    protected $spamScannerEnabled;
    /**
     * @var boolean
     */
    protected $cronEnabled;
    /**
     * @var boolean
     */
    protected $systemInfoEnabled;

    /**
     * PackageSpec constructor.
     *
     * @param string  $name
     * @param integer $bandwidth
     * @param integer $quota
     * @param integer $inodes
     * @param integer $domains
     * @param integer $subDomains
     * @param integer $emails
     * @param integer $emailForwarders
     * @param integer $mailingLists
     * @param integer $autoResponders
     * @param integer $mysqlDatabases
     * @param integer $domainPointers
     * @param integer $ftpAccounts
     * @param boolean $anonymousFtpEnabled
     * @param boolean $cgiEnabled
     * @param boolean $phpEnabled
     * @param boolean $spamScannerEnabled
     * @param boolean $catchAllCustomizationEnabled
     * @param boolean $sslEnabled
     * @param boolean $sshEnabled
     * @param boolean $cronEnabled
     * @param boolean $systemInfoEnabled
     * @param boolean $dnsControlEnabled
     */
    public function __construct(
        $name,
        $bandwidth = INF,
        $quota = INF,
        $inodes = INF,
        $domains = INF,
        $subDomains = INF,
        $emails = INF,
        $emailForwarders = INF,
        $mailingLists = INF,
        $autoResponders = INF,
        $mysqlDatabases = INF,
        $domainPointers = INF,
        $ftpAccounts = INF,
        $anonymousFtpEnabled = true,
        $cgiEnabled = true,
        $phpEnabled = true,
        $spamScannerEnabled = true,
        $catchAllCustomizationEnabled = true,
        $sslEnabled = true,
        $sshEnabled = true,
        $cronEnabled = true,
        $systemInfoEnabled = true,
        $dnsControlEnabled = true
    ) {
        $this->name = $name;
        $this->bandwidth = $bandwidth;
        $this->quota = $quota;
        $this->inodes = $inodes;
        $this->domains = $domains;
        $this->subDomains = $subDomains;
        $this->emails = $emails;
        $this->emailForwarders = $emailForwarders;
        $this->mailingLists = $mailingLists;
        $this->autoResponders = $autoResponders;
        $this->mysqlDatabases = $mysqlDatabases;
        $this->domainPointers = $domainPointers;
        $this->ftpAccounts = $ftpAccounts;
        $this->anonymousFtpEnabled = $anonymousFtpEnabled;
        $this->phpEnabled = $phpEnabled;
        $this->cgiEnabled = $cgiEnabled;
        $this->spamScannerEnabled = $spamScannerEnabled;
        $this->catchAllCustomizationEnabled = $catchAllCustomizationEnabled;
        $this->sslEnabled = $sslEnabled;
        $this->sshEnabled = $sshEnabled;
        $this->cronEnabled = $cronEnabled;
        $this->systemInfoEnabled = $systemInfoEnabled;
        $this->dnsControlEnabled = $dnsControlEnabled;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'packagename' => $this->name,
            'bandwidth' => $this->bandwidth == INF ? 0 : $this->bandwidth,
            'ubandwidth' => $this->bandwidth == INF ? 'ON' : 'OFF',
            'quota' => $this->quota == INF ? 0 : $this->quota,
            'uquota' => $this->quota == INF ? 'ON' : 'OFF',
            'inodes' => $this->inodes == INF ? 0 : $this->inodes,
            'uinodes' => $this->inodes == INF ? 'ON' : 'OFF',
            'vdomains' => $this->domains == INF ? 0 : $this->domains,
            'uvdomains' => $this->domains == INF ? 'ON' : 'OFF',
            'nsubdomains' => $this->subDomains == INF ? 0 : $this->subDomains,
            'unsubdomains' => $this->subDomains == INF ? 'ON' : 'OFF',
            'nemails' => $this->emails == INF ? 0 : $this->emails,
            'unemails' => $this->emails == INF ? 'ON' : 'OFF',
            'nemailf' => $this->emailForwarders == INF ? 0 : $this->emailForwarders,
            'unemailf' => $this->emailForwarders == INF ? 'ON' : 'OFF',
            'nemailml' => $this->mailingLists == INF ? 0 : $this->mailingLists,
            'unemailml' => $this->mailingLists == INF ? 'ON' : 'OFF',
            'nemailr' => $this->autoResponders == INF ? 0 : $this->autoResponders,
            'unemailr' => $this->autoResponders == INF ? 'ON' : 'OFF',
            'mysql' => $this->mysqlDatabases == INF ? 0 : $this->mysqlDatabases,
            'umysql' => $this->mysqlDatabases == INF ? 'ON' : 'OFF',
            'domainptr' => $this->domainPointers == INF ? 0 : $this->domainPointers,
            'udomainptr' => $this->domainPointers == INF ? 'ON' : 'OFF',
            'ftp' => $this->ftpAccounts == INF ? 0 : $this->ftpAccounts,
            'uftp' => $this->ftpAccounts == INF ? 'ON' : 'OFF',
            'aftp' => $this->anonymousFtpEnabled ? 'ON' : 'OFF',
            'php' => $this->phpEnabled ? 'ON' : 'OFF',
            'cgi' => $this->cgiEnabled ? 'ON' : 'OFF',
            'spam' => $this->spamScannerEnabled ? 'ON' : 'OFF',
            'catchall' => $this->catchAllCustomizationEnabled ? 'ON' : 'OFF',
            'ssl' => $this->sslEnabled ? 'ON' : 'OFF',
            'ssh' => $this->sshEnabled ? 'ON' : 'OFF',
            'cron' => $this->cronEnabled ? 'ON' : 'OFF',
            'sysinfo' => $this->systemInfoEnabled ? 'ON' : 'OFF',
            'dnscontrol' => $this->dnsControlEnabled ? 'ON' : 'OFF',
        ];
    }
}
