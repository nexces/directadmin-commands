<?php

/**
 * Class InvalidAccountSpec
 */
class InvalidAccountSpec extends \DirectAdminCommands\ValueObject\AccountSpec {}

/**
 * Class AccountTest
 */
class AccountTest extends PHPUnit_Framework_TestCase
{
    /**
     * This function is explicitly implemented as setup, not teardown, so in case of failed tests you may investigate
     * the accounts in DirectAdmin to see what's wrong.
     */
    public static function setUpBeforeClass()
    {
        $command = new \DirectAdminCommands\Account(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        try {
            $command->delete(USER_USERNAME);
        } catch (\Exception $e) {
        }
        try {
            $command->delete(RESELLER_USERNAME);
        } catch (\Exception $e) {
        }
        try {
            $command->delete(ADMIN_USERNAME);
        } catch (\Exception $e) {
        }

    }

    public function testCreateAdmin()
    {
        $command = new \DirectAdminCommands\Account(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $result = $command->create(
            new \DirectAdminCommands\ValueObject\AdminAccountSpec(
                ADMIN_USERNAME, TEST_EMAIL, ADMIN_PASSWORD, false
            )
        );
        $this->assertTrue($result, 'Could not create admin ' . ADMIN_USERNAME);
    }

    /**
     * @depends testCreateAdmin
     */
    public function testAccountExists()
    {
        $command = new \DirectAdminCommands\Account(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $result = $command->exists(ADMIN_USERNAME);
        $this->assertTrue($result, 'Could not verify admin account existence');
    }

    /**
     * @expectedException \DirectAdminCommands\Exception\GenericException
     * @depends testCreateAdmin
     */
    public function testCreateExistingAdmin()
    {
        $command = new \DirectAdminCommands\Account(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $command->create(
            new \DirectAdminCommands\ValueObject\AdminAccountSpec(
                ADMIN_USERNAME, TEST_EMAIL, ADMIN_PASSWORD, false
            )
        );
    }

    public function testLoginTest()
    {
        $command = new \DirectAdminCommands\Account(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, '');
        $result = $command->loginTest();
        $this->assertFalse($result, 'Sucessfully logged in as master admin WITHOUT PASSWORD!');
    }

    /**
     * @depends testCreateAdmin
     */
    public function testListAdministrators()
    {
        $command = new \DirectAdminCommands\Account(DIRECTADMIN_URL, ADMIN_USERNAME, ADMIN_PASSWORD);
        $result = $command->listAdmins();
        $this->assertContains(MASTER_ADMIN_USERNAME, $result, false);
        $this->assertContains(ADMIN_USERNAME, $result, false);
    }

    /**
     * @depends testCreateAdmin
     */
    public function testImpersonateAdmin()
    {
        $command = new \DirectAdminCommands\Account(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $command->impersonate(ADMIN_USERNAME);
        $result = $command->loginTest();
        $this->assertTrue($result, 'Could not impersonate admin: ' . ADMIN_USERNAME);
    }

    /**
     * @depends testImpersonateAdmin
     * @expectedException \UnexpectedValueException
     */
    public function testInvalidAccountSpec()
    {
        $command = new \DirectAdminCommands\Account(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $command->impersonate(ADMIN_USERNAME);
        $invalidAccount = new InvalidAccountSpec('', '', '', false);
        $command->create($invalidAccount);
    }

    /**
     * @depends testImpersonateAdmin
     */
    public function testCreateResellerFromParameters()
    {
        $resellerData = new \DirectAdminCommands\ValueObject\ResellerCustomAccountSpec(
            RESELLER_USERNAME,
            TEST_EMAIL,
            RESELLER_PASSWORD,
            false,
            TEST_RESELLER_DOMAIN,
            \DirectAdminCommands\ValueObject\ResellerAccountSpec::ACCOUNT_IP_SHARED,
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            false,
            false,
            false,
            false,
            false,
            false,
            false,
            \DirectAdminCommands\ValueObject\ResellerAccountSpec::CUSTOM_DNS_OFF,
            false
        );
        $command = new \DirectAdminCommands\Account(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $command->impersonate(ADMIN_USERNAME);
        $result = $command->create($resellerData);
        $this->assertTrue($result);
    }

    /**
     * @depends testCreateResellerFromParameters
     */
    public function testImpersonateReseller()
    {
        $command = new \DirectAdminCommands\Account(DIRECTADMIN_URL, ADMIN_USERNAME, ADMIN_PASSWORD);
        $command->impersonate(RESELLER_USERNAME);
        $result = $command->loginTest();
        $this->assertTrue($result, 'Could not impersonate as reseller');
    }

    /**
     * @depends testCreateResellerFromParameters
     */
    public function testListResellers()
    {
        $command = new \DirectAdminCommands\Account(DIRECTADMIN_URL, ADMIN_USERNAME, ADMIN_PASSWORD);
        $result = $command->listResellers();
        $this->assertContains(RESELLER_USERNAME, $result);
    }

    public function testListAllAccounts()
    {
        $command = new \DirectAdminCommands\Account(DIRECTADMIN_URL, ADMIN_USERNAME, ADMIN_PASSWORD);
        $result = $command->listAll();
        $this->assertInternalType('array', $result);
    }

    /**
     * @depends testCreateResellerFromParameters
     *
     */
    public function testSuspendAccount()
    {
        $this->markTestSkipped('CMD_API_SELECT_USERS does not work!');
        $command = new \DirectAdminCommands\Account(DIRECTADMIN_URL, ADMIN_USERNAME, ADMIN_PASSWORD);
        $result = $command->suspend(RESELLER_USERNAME);
        $this->assertTrue($result, 'Could not suspend account');
    }

    /**
     * @depends testCreateResellerFromParameters
     */
    public function testResumeAccount()
    {
        $this->markTestSkipped('CMD_API_SELECT_USERS does not work!');
        $command = new \DirectAdminCommands\Account(DIRECTADMIN_URL, ADMIN_USERNAME, ADMIN_PASSWORD);
        $result = $command->resume(RESELLER_USERNAME);
        $this->assertTrue($result, 'Could not resume account');
    }

    /**
     * @depends testImpersonateReseller
     * @depends testListResellers
     */
    public function testDeleteReseller()
    {
        $command = new \DirectAdminCommands\Account(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $command->impersonate(ADMIN_USERNAME);
        $result = $command->delete(RESELLER_USERNAME);
        $this->assertTrue($result, 'Could not delete reseller account');
    }

    /**
     * @depends testCreateAdmin
     * @depends testImpersonateAdmin
     * @depends testListAdministrators
     */
    public function testDeleteAdmin()
    {
        $command = new \DirectAdminCommands\Account(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $result = $command->delete(ADMIN_USERNAME);
        $this->assertTrue($result, 'Could not delete admin account: ' . ADMIN_USERNAME);
    }
}
