<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 10.06.16
 * Time: 07:24
 */

namespace DirectAdminCommands\ValueObject;

/**
 * Class ResellerPackageSpec
 *
 * @package DirectAdminCommands
 */
class ResellerPackageSpec extends PackageSpec
{
    /**
     * No DNS will be created
     */
    const CUSTOM_DNS_OFF = 'OFF';
    /**
     * Domain will use same IP as NS1, NS2 will use second IP
     */
    const CUSTOM_DNS_DOMAIN_ON_NS1 = 'TWO';
    /**
     * Domain, NS1, NS2 on separate addresses
     */
    const CUSTOM_DNS_DOMAIN_SEPARATE = 'THREE';

    /**
     * @var integer
     */
    protected $ips;
    /**
     * @var boolean
     */
    protected $serverIpEnabled;
    /**
     * @var boolean
     */
    protected $createUserSshEnabled;
    /**
     * @var boolean
     */
    protected $oversellEnabled;
    /**
     * @var boolean
     */
    protected $loginKeysEnabled;
    /**
     * @var string
     */
    protected $customDns;

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
     * @param integer $ips
     * @param boolean $createUserSshEnabled
     * @param boolean $oversellEnabled
     * @param boolean $loginKeysEnabled
     * @param string  $customDns
     * @param boolean $serverIpEnabled
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
        $dnsControlEnabled = true,
        $ips = 0,
        $createUserSshEnabled = true,
        $oversellEnabled = true,
        $loginKeysEnabled = true,
        $customDns = self::CUSTOM_DNS_OFF,
        $serverIpEnabled = true
    ) {
        parent::__construct(
            $name,
            $bandwidth,
            $quota,
            $inodes,
            $domains,
            $subDomains,
            $emails,
            $emailForwarders,
            $mailingLists,
            $autoResponders,
            $mysqlDatabases,
            $domainPointers,
            $ftpAccounts,
            $anonymousFtpEnabled,
            $cgiEnabled,
            $phpEnabled,
            $spamScannerEnabled,
            $catchAllCustomizationEnabled,
            $sslEnabled,
            $sshEnabled,
            $cronEnabled,
            $systemInfoEnabled,
            $dnsControlEnabled
        );
        $this->ips = $ips;
        $this->createUserSshEnabled = $createUserSshEnabled;
        $this->oversellEnabled = $oversellEnabled;
        $this->loginKeysEnabled = $loginKeysEnabled;
        $this->customDns = $customDns;
        $this->serverIpEnabled = $serverIpEnabled;
    }


}
