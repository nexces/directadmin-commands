<?php
/**
 * Created by PhpStorm.
 * User: ${AUTHOR}
 * Date: 09.06.16
 * Time: 13:12
 */

namespace DirectAdminCommands;

/**
 * Class CoreTest
 *
 * @package DirectAdminCommands
 */
class CoreTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \DirectAdminCommands\Exception\BadCredentialsException
     */
    public function testBadCredentials()
    {
        $command = new Core(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, '');
        $command->systemInfo();
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testBadCommand()
    {
        $command = new Core(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, '');
        $command->send();
    }

    /**
     * @expectedException \DirectAdminCommands\Exception\MalformedRequestException
     */
    public function testNonApiCommand()
    {
        $command = new Core(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $reflection = new \ReflectionObject($command);
        $commandProperty = $reflection->getProperty('command');
        $commandProperty->setAccessible(true);
        $commandProperty->setValue($command, 'CMD_SYSTEM_INFO');
        $commandProperty->setAccessible(false);
        $command->send();
    }
    
    public function testSystemInfo()
    {
        $command = new Core(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $result = $command->systemInfo();
        $this->assertArrayHasKey('directadmin', $result);
        $this->assertArrayHasKey('numcpus', $result);
    }
}
