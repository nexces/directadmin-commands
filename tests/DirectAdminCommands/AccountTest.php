<?php

/**
 * Created by PhpStorm.
 * User: ${AUTHOR}
 * Date: 09.06.16
 * Time: 12:30
 */
class AccountTest extends PHPUnit_Framework_TestCase
{
    /**
     * This function is explicitly implemented as setup, not teardown, so in case of failed tests you may investigate
     * the accounts in DirectAdmin to see what's wrong.
     */
    public static function setUpBeforeClass()
    {
        try {
            // Ensure all test accounts are gone
            $account = new \DirectAdminCommands\Account(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
            $account->delete(USER_USERNAME);
            $account->delete(RESELLER_USERNAME);
            $account->delete(ADMIN_USERNAME);
        } catch (\Exception $e) {
            // Silently fail as this is expected behaviour
        }
    }

    public function testCreateAdmin()
    {
        $account = new \DirectAdminCommands\Account(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $result = $account->create(
            new \DirectAdminCommands\ValueObject\AdminAccountSpec(
                ADMIN_USERNAME, TEST_EMAIL, ADMIN_PASSWORD, false
            )
        );
        $this->assertTrue($result, 'Could not create admin ' . ADMIN_USERNAME);
    }

    /**
     * @expectedException \DirectAdminCommands\Exception\GenericException
     */
    public function testCreateExistingAdmin()
    {
        $account = new \DirectAdminCommands\Account(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $account->create(
            new \DirectAdminCommands\ValueObject\AdminAccountSpec(
                ADMIN_USERNAME, TEST_EMAIL, ADMIN_PASSWORD, false
            )
        );
    }

    /**
     * @depends testCreateAdmin
     */
    public function testImpersonateAdmin()
    {
        $account = new \DirectAdminCommands\Account(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $account->impersonate(ADMIN_USERNAME);
        $result = $account->loginTest();
        $this->assertTrue($result, 'Could not impersonate admin: ' . ADMIN_USERNAME);
    }

    /**
     * @depends testCreateAdmin
     */
    public function testDeleteAccounts()
    {
        $account = new \DirectAdminCommands\Account(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $result = $account->delete(ADMIN_USERNAME);
        $this->assertTrue($result, 'Could not delete admin account: ' . ADMIN_USERNAME);
    }
}
