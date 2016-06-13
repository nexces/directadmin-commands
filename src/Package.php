<?php
/**
 * Created by PhpStorm.
 * User: Adrian 'Nexces' Piotrowicz
 * Date: 10.06.16
 * Time: 07:21
 */

namespace DirectAdminCommands;

use DirectAdminCommands\ValueObject\PackageSpec;
use DirectAdminCommands\ValueObject\UserPackageSpec;
use DirectAdminCommands\ValueObject\ResellerPackageSpec;

/**
 * Class Package
 *
 * @package DirectAdminCommands
 */
class Package extends CommandAbstract
{
    /**
     * Creates new package
     * 
     * @param \DirectAdminCommands\ValueObject\PackageSpec $package
     *
     * @return bool
     * @throws \DirectAdminCommands\Exception\BadCredentialsException
     * @throws \DirectAdminCommands\Exception\GenericException
     * @throws \DirectAdminCommands\Exception\MalformedRequestException
     */
    public function create(PackageSpec $package)
    {
        $this->method = 'POST';
        if ($package instanceof ResellerPackageSpec) {
            $this->command = 'CMD_API_MANAGE_RESELLER_PACKAGES';
        } else if ($package instanceof UserPackageSpec) {
            $this->command = 'CMD_API_MANAGE_USER_PACKAGES';
        }
        $params = $package->toArray();
        $params['add'] = 'yes';
        $this->send($params);
        $this->validateResponse();
        
        return true;
    }

    /**
     * Deletes package - provide new package spec with name only
     * 
     * @param \DirectAdminCommands\ValueObject\PackageSpec $package
     *
     * @return bool
     * @throws \DirectAdminCommands\Exception\BadCredentialsException
     * @throws \DirectAdminCommands\Exception\GenericException
     * @throws \DirectAdminCommands\Exception\MalformedRequestException
     */
    public function delete(PackageSpec $package)
    {
        $this->method = 'POST';
        if ($package instanceof ResellerPackageSpec) {
            $this->command = 'CMD_API_MANAGE_RESELLER_PACKAGES';
        } else if ($package instanceof UserPackageSpec) {
            $this->command = 'CMD_API_MANAGE_USER_PACKAGES';
        }
        $params = [
            'delete' => 'yes',
            'delete0' => $package->getName()
        ];
        $this->send($params);
        $this->validateResponse();

        return true;
    }

    /**
     * Returns array with package specification
     *
     * @param \DirectAdminCommands\ValueObject\PackageSpec $package
     *
     * @return array
     * @throws \DirectAdminCommands\Exception\BadCredentialsException
     * @throws \DirectAdminCommands\Exception\GenericException
     * @throws \DirectAdminCommands\Exception\MalformedRequestException
     */
    public function get(PackageSpec $package)
    {
        if ($package instanceof ResellerPackageSpec) {
            $this->command = 'CMD_API_PACKAGES_RESELLER';
        } else if ($package instanceof UserPackageSpec) {
            $this->command = 'CMD_API_PACKAGES_USER';
        }
        $this->send(
            [
                'package' => $package->getName()
            ]
        );
        $this->validateResponse();
        // TODO adapt this to use PackageSpec
        return $this->getParsedResponse();
    }

    /**
     * Lists reseller packages with full specs
     * 
     * @return array
     * @throws \DirectAdminCommands\Exception\BadCredentialsException
     * @throws \DirectAdminCommands\Exception\GenericException
     * @throws \DirectAdminCommands\Exception\MalformedRequestException
     */
    public function listReseller()
    {
        $this->command = 'CMD_API_PACKAGES_RESELLER';
        $this->send();
        $this->validateResponse();
        $data = $this->getParsedResponse();
        return $data['list'];
    }

    /**
     * Lists user packages with full specs
     * @return array
     * @throws \DirectAdminCommands\Exception\BadCredentialsException
     * @throws \DirectAdminCommands\Exception\GenericException
     * @throws \DirectAdminCommands\Exception\MalformedRequestException
     */
    public function listUser()
    {
        $this->command = 'CMD_API_PACKAGES_USER';
        $this->send();
        $this->validateResponse();
        $data = $this->getParsedResponse();
        return $data['list'];
    }
}
