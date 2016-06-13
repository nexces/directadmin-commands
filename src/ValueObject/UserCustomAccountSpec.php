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
     * @param integer $bandwidth
     * @param integer $quota
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
     * @param boolean $phpEnabled
     * @param boolean $cgiEnabled
     * @param boolean $spamScannerEnabled
     * @param boolean $cronEnabled
     * @param boolean $catchAllCustomizationEnabled
     * @param boolean $sslEnabled
     * @param boolean $sshEnabled
     * @param boolean $systemInfoEnabled
     * @param boolean $dnsControlEnabled
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
        $params['bandwidth'] = $this->bandwidth == INF ? 0 : $this->bandwidth;
        $params['ubandwidth'] = $this->bandwidth == INF ? 'ON' : 'OFF';
        $params['quota'] = $this->quota == INF ? 0 : $this->quota;
        $params['uquota'] = $this->quota == INF ? 'ON' : 'OFF';
        $params['vdomains'] = $this->domains == INF ? 0 : $this->domains;
        $params['uvdomains'] = $this->domains == INF ? 'ON' : 'OFF';
        $params['nsubdomains'] = $this->subDomains == INF ? 0 : $this->subDomains;
        $params['unsubdomains'] = $this->subDomains == INF ? 'ON' : 'OFF';
        $params['nemails'] = $this->emails == INF ? 0 : $this->emails;
        $params['unemails'] = $this->emails == INF ? 'ON' : 'OFF';
        $params['nemailf'] = $this->emailForwarders == INF ? 0 : $this->emailForwarders;
        $params['unemailf'] = $this->emailForwarders == INF ? 'ON' : 'OFF';
        $params['nemailml'] = $this->mailingLists == INF ? 0 : $this->mailingLists;
        $params['unemailml'] = $this->mailingLists == INF ? 'ON' : 'OFF';
        $params['nemailr'] = $this->autoResponders == INF ? 0 : $this->autoResponders;
        $params['unemailr'] = $this->autoResponders == INF ? 'ON' : 'OFF';
        $params['mysql'] = $this->mysqlDatabases == INF ? 0 : $this->mysqlDatabases;
        $params['umysql'] = $this->mysqlDatabases == INF ? 'ON' : 'OFF';
        $params['domainptr'] = $this->domainPointers == INF ? 0 : $this->domainPointers;
        $params['udomainptr'] = $this->domainPointers == INF ? 'ON' : 'OFF';
        $params['ftp'] = $this->ftpAccounts == INF ? 0 : $this->ftpAccounts;
        $params['uftp'] = $this->ftpAccounts == INF ? 'ON' : 'OFF';
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
