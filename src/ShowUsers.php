<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 17.05.16
 * Time: 13:36
 */

namespace DirectAdminCommands;


class ShowUsers extends CommandAbstract
{
    public function __construct($url, $adminName, $adminPassword, $clientName = null)
    {
        $this->command = 'CMD_API_SHOW_USERS';
        parent::__construct($url, $adminName, $adminPassword, $clientName);

        return $this;
    }

    /**
     * @return array
     */
    public function get()
    {
        $this->send();
        $data = [];
        $bodyContents = $this->response->getBody()->getContents();
        $bodyContents = $this->decodeResponse($bodyContents);
        parse_str($bodyContents, $data);
        if (array_key_exists('list', $data)) {
            $data = $data['list'];
        }
        return $data;
    }
}
