<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 09.06.16
 * Time: 10:00
 */

namespace DirectAdminCommands\ValueObject;

/**
 * Class ResellerCustomAccountSpec
 *
 * @package DirectAdminCommands\ValueObject
 */
class ResellerCustomAccountSpec extends ResellerAccountSpec
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
    protected $inodes;
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
    protected $ips;
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
    protected $cgiEnabled;
    /**
     * @var boolean
     */
    protected $phpEnabled;
    /**
     * @var boolean
     */
    protected $spamScannerEnabled;
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
    protected $createUserSshEnabled;
    /**
     * @var boolean
     */
    protected $oversellEnabled;
    /**
     * @var boolean
     */
    protected $cronEnabled;
    /**
     * @var boolean
     */
    protected $systemInfoEnabled;
    /**
     * @var boolean
     */
    protected $loginKeysEnabled;
    /**
     * @var boolean
     */
    protected $dnsControlEnabled;
    /**
     * @var string
     */
    protected $customDns;
    /**
     * @var boolean
     */
    protected $shareServerIpEnabled;

    /**
     * ResellerCustomAccountSpec constructor.
     *
     * @param string  $username
     * @param string  $email
     * @param string  $password
     * @param boolean $notify
     * @param string  $domain
     * @param string  $ip
     * @param integer $bandwidth
     * @param integer $quota
     * @param integer $inodes
     * @param integer $domains
     * @param integer $subDomains
     * @param integer $ips
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
     * @param boolean $createUserSshEnabled
     * @param boolean $oversellEnabled
     * @param boolean $cronEnabled
     * @param boolean $systemInfoEnabled
     * @param boolean $loginKeysEnabled
     * @param boolean $dnsControlEnabled
     * @param string  $customDns
     * @param boolean $shareServerIpEnabled
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
        $inodes,
        $domains,
        $subDomains,
        $ips,
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
        $createUserSshEnabled,
        $oversellEnabled,
        $cronEnabled,
        $systemInfoEnabled,
        $loginKeysEnabled,
        $dnsControlEnabled,
        $customDns,
        $shareServerIpEnabled
    ) {
        parent::__construct($username, $email, $password, $notify, $domain, $ip);
        $this->bandwidth = $bandwidth;
        $this->quota = $quota;
        $this->inodes = $inodes;
        $this->domains = $domains;
        $this->subDomains = $subDomains;
        $this->ips = $ips;
        $this->emails = $emails;
        $this->emailForwarders = $emailForwarders;
        $this->mailingLists = $mailingLists;
        $this->autoResponders = $autoResponders;
        $this->mysqlDatabases = $mysqlDatabases;
        $this->domainPointers = $domainPointers;
        $this->ftpAccounts = $ftpAccounts;
        $this->anonymousFtpEnabled = $anonymousFtpEnabled;
        $this->cgiEnabled = $cgiEnabled;
        $this->phpEnabled = $phpEnabled;
        $this->spamScannerEnabled = $spamScannerEnabled;
        $this->catchAllCustomizationEnabled = $catchAllCustomizationEnabled;
        $this->sslEnabled = $sslEnabled;
        $this->sshEnabled = $sshEnabled;
        $this->createUserSshEnabled = $createUserSshEnabled;
        $this->oversellEnabled = $oversellEnabled;
        $this->cronEnabled = $cronEnabled;
        $this->systemInfoEnabled = $systemInfoEnabled;
        $this->loginKeysEnabled = $loginKeysEnabled;
        $this->dnsControlEnabled = $dnsControlEnabled;
        $this->customDns = $customDns;
        $this->shareServerIpEnabled = $shareServerIpEnabled;

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
        $params['inodes'] = $this->inodes == INF ? 0 : $this->inodes;
        $params['uinodes'] = $this->inodes == INF ? 'ON' : 'OFF';
        $params['vdomains'] = $this->domains == INF ? 0 : $this->domains;
        $params['uvdomains'] = $this->domains == INF ? 'ON' : 'OFF';
        $params['nsubdomains'] = $this->subDomains == INF ? 0 : $this->subDomains;
        $params['unsubdomains'] = $this->subDomains == INF ? 'ON' : 'OFF';
        $params['ips'] = $this->ips;
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
        $params['cgi'] = $this->cgiEnabled ? 'ON' : 'OFF';
        $params['php'] = $this->phpEnabled ? 'ON' : 'OFF';
        $params['span'] = $this->spamScannerEnabled ? 'ON' : 'OFF';
        $params['catchall'] = $this->catchAllCustomizationEnabled ? 'ON' : 'OFF';
        $params['ssl'] = $this->sslEnabled ? 'ON' : 'OFF';
        $params['ssh'] = $this->sshEnabled ? 'ON' : 'OFF';
        $params['userssh'] = $this->createUserSshEnabled ? 'ON' : 'OFF';
        $params['oversell'] = $this->oversellEnabled ? 'ON' : 'OFF';
        $params['cron'] = $this->cronEnabled ? 'ON' : 'OFF';
        $params['sysinfo'] = $this->systemInfoEnabled ? 'ON' : 'OFF';
        $params['login_keys'] = $this->loginKeysEnabled ? 'ON' : 'OFF';
        $params['dnscontrol'] = $this->dnsControlEnabled ? 'ON' : 'OFF';
        $params['dns'] = $this->customDns;
        $params['serverip'] = $this->shareServerIpEnabled ? 'ON' : 'OFF';
        return $params;
    }
}
