<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 09.06.16
 * Time: 10:23
 */

namespace DirectAdminCommands\ValueObject;

/**
 * Class UserCustomAccountSpec
 *
 * @package DirectAdminCommands\ValueObject
 */
class UserCustomAccountSpec extends UserAccountSpec
{
    /**
     * @var integer
     */
    protected $bandwidth;
    /**
     * @var integer
     */
    protected $quota;
    /**
     * @var integer
     */
    protected $domains;
    /**
     * @var integer
     */
    protected $subDomains;
    /**
     * @var integer
     */
    protected $emails;
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
    protected $mysqlDatabases;
    /**
     * @var integer
     */
    protected $domainPointers;
    /**
     * @var integer
     */
    protected $ftpAccounts;
    /**
     * @var boolean
     */
    protected $anonymousFtpEnabled;
    /**
     * @var boolean
     */
    protected $phpEnabled;
    /**
     * @var boolean
     */
    protected $cgiEnabled;
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
    protected $catchAllCustomizationEnabled;
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
    protected $systemInfoEnabled;
    /**
     * @var boolean
     */
    protected $dnsControlEnabled;

    /**
     * UserCustomAccountSpec constructor.
     *
     * @param string  $username
     * @param string  $email
     * @param string  $password
     * @param boolean $notify
     * @param string  $domain
     * @param string  $ip
     * @param int     $bandwidth
     * @param int     $quota
     * @param int     $domains
     * @param int     $subDomains
     * @param int     $emails
     * @param int     $emailForwarders
     * @param int     $mailingLists
     * @param int     $autoResponders
     * @param int     $mysqlDatabases
     * @param int     $domainPointers
     * @param int     $ftpAccounts
     * @param bool    $anonymousFtpEnabled
     * @param bool    $phpEnabled
     * @param bool    $cgiEnabled
     * @param bool    $spamScannerEnabled
     * @param bool    $cronEnabled
     * @param bool    $catchAllCustomizationEnabled
     * @param bool    $sslEnabled
     * @param bool    $sshEnabled
     * @param bool    $systemInfoEnabled
     * @param bool    $dnsControlEnabled
     */
    public function __construct(
        $username,
        $email,
        $password,
        $notify,
        $domain,
        $ip,
        $bandwidth,
        $quota,
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
        $phpEnabled,
        $cgiEnabled,
        $spamScannerEnabled,
        $cronEnabled,
        $catchAllCustomizationEnabled,
        $sslEnabled,
        $sshEnabled,
        $systemInfoEnabled,
        $dnsControlEnabled
    ) {
        parent::__construct($username, $email, $password, $notify, $domain, $ip);
        $this->bandwidth = $bandwidth;
        $this->quota = $quota;
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
        $this->cronEnabled = $cronEnabled;
        $this->catchAllCustomizationEnabled = $catchAllCustomizationEnabled;
        $this->sslEnabled = $sslEnabled;
        $this->sshEnabled = $sshEnabled;
        $this->systemInfoEnabled = $systemInfoEnabled;
        $this->dnsControlEnabled = $dnsControlEnabled;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $params = parent::toArray();
        $params['bandwidth'] = $this->bandwidth < 0 ? 0 : $this->bandwidth;
        $params['ubandwidth'] = $this->bandwidth < 0 ? 'ON' : 'OFF';
        $params['quota'] = $this->quota < 0 ? 0 : $this->quota;
        $params['uquota'] = $this->quota < 0 ? 'ON' : 'OFF';
        $params['vdomains'] = $this->domains < 0 ? 0 : $this->domains;
        $params['uvdomains'] = $this->domains < 0 ? 'ON' : 'OFF';
        $params['nsubdomains'] = $this->subDomains < 0 ? 0 : $this->subDomains;
        $params['unsubdomains'] = $this->subDomains < 0 ? 'ON' : 'OFF';
        $params['nemails'] = $this->emails < 0 ? 0 : $this->emails;
        $params['unemails'] = $this->emails < 0 ? 'ON' : 'OFF';
        $params['nemailf'] = $this->emailForwarders < 0 ? 0 : $this->emailForwarders;
        $params['unemailf'] = $this->emailForwarders < 0 ? 'ON' : 'OFF';
        $params['nemailml'] = $this->mailingLists < 0 ? 0 : $this->mailingLists;
        $params['unemailml'] = $this->mailingLists < 0 ? 'ON' : 'OFF';
        $params['nemailr'] = $this->autoResponders < 0 ? 0 : $this->autoResponders;
        $params['unemailr'] = $this->autoResponders < 0 ? 'ON' : 'OFF';
        $params['mysql'] = $this->mysqlDatabases < 0 ? 0 : $this->mysqlDatabases;
        $params['umysql'] = $this->mysqlDatabases < 0 ? 'ON' : 'OFF';
        $params['domainptr'] = $this->domainPointers < 0 ? 0 : $this->domainPointers;
        $params['udomainptr'] = $this->domainPointers < 0 ? 'ON' : 'OFF';
        $params['ftp'] = $this->ftpAccounts < 0 ? 0 : $this->ftpAccounts;
        $params['uftp'] = $this->ftpAccounts < 0 ? 'ON' : 'OFF';
        $params['aftp'] = $this->anonymousFtpEnabled ? 'ON' : 'OFF';
        $params['php'] = $this->phpEnabled ? 'ON' : 'OFF';
        $params['cgi'] = $this->cgiEnabled ? 'ON' : 'OFF';
        $params['spam'] = $this->spamScannerEnabled ? 'ON' : 'OFF';
        $params['cron'] = $this->cronEnabled ? 'ON' : 'OFF';
        $params['catchall'] = $this->catchAllCustomizationEnabled ? 'ON' : 'OFF';
        $params['ssl'] = $this->sslEnabled ? 'ON' : 'OFF';
        $params['ssh'] = $this->sshEnabled ? 'ON' : 'OFF';
        $params['sysinfo'] = $this->systemInfoEnabled ? 'ON' : 'OFF';
        $params['dnscontrol'] = $this->dnsControlEnabled ? 'ON' : 'OFF';
        return $params;
    }
}
