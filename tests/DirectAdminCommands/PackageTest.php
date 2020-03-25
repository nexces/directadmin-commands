<?php
/**
 * Created by PhpStorm.
 * User: ${AUTHOR}
 * Date: 10.06.16
 * Time: 09:03
 */

namespace DirectAdminCommands;

use PHPUnit\Framework\TestCase;

/**
 * Class PackageTest
 *
 * @package DirectAdminCommands
 */
class PackageTest extends TestCase
{
    public function testCreateResellerPackage()
    {
        $command = new Package(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $result = $command->create(new ValueObject\ResellerPackageSpec('testresellerpackage'));
        $this->assertTrue($result, 'Could not create reseller package');
    }
    /**
     * @depends testCreateResellerPackage
     */
    public function testListResellerPackages()
    {
        $command = new Package(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $result = $command->listReseller();
        $this->assertContains('testresellerpackage', $result);
    }
    public function testGetResellerPackage()
    {
        $command = new Package(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $result = $command->get(new ValueObject\ResellerPackageSpec('testresellerpackage'));
        $this->assertIsArray($result);
        $this->assertArrayHasKey('bandwidth', $result);
        $this->assertEquals('unlimited', $result['bandwidth']);
        $this->assertArrayHasKey('quota', $result);
        $this->assertEquals('unlimited', $result['quota']);
    }
    /**
     * @depends testCreateResellerPackage
     */
    public function testDeleteResellerPackage()
    {
        $command = new Package(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $result = $command->delete(new ValueObject\ResellerPackageSpec('testresellerpackage'));
        $this->assertTrue($result, 'Could not delete reseller package');
    }

    public function testCreateUserPackage()
    {

        $command = new Package(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $result = $command->create(new ValueObject\UserPackageSpec('testuserpackage'));
        $this->assertTrue($result, 'Could not create user package');
    }

    /**
     * @depends testCreateUserPackage
     */
    public function testListUserPackages()
    {
        $command = new Package(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $result = $command->listUser();
        $this->assertContains('testuserpackage', $result);
    }

    /**
     * @depends testCreateUserPackage
     */
    public function testDeleteUserPackage()
    {
        $command = new Package(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $result = $command->delete(new ValueObject\UserPackageSpec('testuserpackage'));
        $this->assertTrue($result, 'Could not delete user package');
    }
}
