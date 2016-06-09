<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 09.06.16
 * Time: 09:33
 */

namespace DirectAdminCommands\ValueObject;

/**
 * Class AccountSpec
 *
 * @package DirectAdminCommands\ValueObject
 */
abstract class AccountSpec
{
    /**
     * @var string
     */
    protected $username;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $password;
    /**
     * @var boolean
     */
    protected $notify;

    /**
     * AccountSpec constructor.
     *
     * @param string  $username
     * @param string  $email
     * @param string  $password
     * @param boolean $notify
     */
    public function __construct($username, $email, $password, $notify)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->notify = $notify;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'username' => $this->username,
            'email' => $this->email,
            'passwd' => $this->password,
            'passwd2' => $this->password,
            'notify' => $this->notify ? 'yes' : 'no'
        ];
    }

}
