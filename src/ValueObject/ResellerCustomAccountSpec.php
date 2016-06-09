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
    protected $phpEnabled;
    /**
     * @var boolean
     */
    protected $cgiEnabled;
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
    protected $dnsControlEnabled;
    /**
     * @var string
     */
    protected $customDns;
    /**
     * @var boolean
     */
    protected $serverIpEnabled;

    /**
     * ResellerCustomAccountSpec constructor.
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
     * @param int     $ips
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
     * @param bool    $sslEnabled
     * @param bool    $sshEnabled
     * @param bool    $createUserSshEnabled
     * @param bool    $dnsControlEnabled
     * @param string  $customDns
     * @param bool    $serverIpEnabled
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
        $ips,
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
        $sslEnabled,
        $sshEnabled,
        $createUserSshEnabled,
        $dnsControlEnabled,
        $customDns,
        $serverIpEnabled
    ) {
        parent::__construct($username, $email, $password, $notify, $domain, $ip);
        $this->bandwidth = $bandwidth;
        $this->quota = $quota;
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
        $this->phpEnabled = $phpEnabled;
        $this->cgiEnabled = $cgiEnabled;
        $this->sslEnabled = $sslEnabled;
        $this->sshEnabled = $sshEnabled;
        $this->createUserSshEnabled = $createUserSshEnabled;
        $this->dnsControlEnabled = $dnsControlEnabled;
        $this->customDns = $customDns;
        $this->serverIpEnabled = $serverIpEnabled;
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
        $params['ips'] = $this->ips;
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
        $params['ssl'] = $this->sslEnabled ? 'ON' : 'OFF';
        $params['ssh'] = $this->sshEnabled ? 'ON' : 'OFF';
        $params['userssh'] = $this->createUserSshEnabled ? 'ON' : 'OFF';
        $params['dnscontrol'] = $this->dnsControlEnabled ? 'ON' : 'OFF';
        $params['dns'] = $this->customDns;
        $params['serverip'] = $this->serverIpEnabled ? 'ON' : 'OFF';
        return $params;
    }
}
