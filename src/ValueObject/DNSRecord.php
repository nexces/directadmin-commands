<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 25.05.16
 * Time: 09:53
 */

namespace DirectAdminCommands\ValueObject;


class DNSRecord
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $key = '';

    /**
     * DNSRecord constructor.
     *
     * @param string $type
     * @param string $name
     * @param string $value
     * @param string $key
     */
    public function __construct($type, $name, $value, $key = '')
    {
        $this->type = strtoupper($type);
        $this->name = $name;
        $this->value = $value;
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }


}
