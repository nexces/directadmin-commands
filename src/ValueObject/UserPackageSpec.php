<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 10.06.16
 * Time: 07:52
 */

namespace DirectAdminCommands\ValueObject;

/**
 * Class UserPackageSpec
 *
 * @package DirectAdminCommands\ValueObject
 */
class UserPackageSpec extends PackageSpec
{
    /**
     * @var boolean
     */
    protected $suspendAtLimit;
    /**
     * @var string
     */
    protected $skin;
    /**
     * @var string
     */
    protected $language;

    /**
     * UserPackageSpec constructor.
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
     * @param boolean $suspendAtLimit
     * @param string  $skin
     * @param string  $language
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
        $suspendAtLimit = true,
        $skin = 'enhanced',
        $language = 'en'
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
        $this->suspendAtLimit = $suspendAtLimit;
        $this->skin = $skin;
        $this->language = $language;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $params = parent::toArray();
        $params['suspend_at_limit'] = $this->suspendAtLimit;
        $params['skin'] = $this->skin;
        $params['language'] = $this->language;

        return $params;
    }


}
