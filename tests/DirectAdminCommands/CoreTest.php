<?php
/**
 * Created by PhpStorm.
 * User: ${AUTHOR}
 * Date: 09.06.16
 * Time: 13:12
 */

namespace DirectAdminCommands;

use BadMethodCallException;
use DirectAdminCommands\Exception\BadCredentialsException;
use DirectAdminCommands\Exception\MalformedRequestException;
use PHPUnit\Framework\TestCase;
use ReflectionObject;

/**
 * Class CoreTest
 *
 * @package DirectAdminCommands
 */
class CoreTest extends TestCase
{
    public function testBadCredentials()
    {
        $this->expectException(BadCredentialsException::class);
        $command = new Core(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, '');
        $command->systemInfo();
    }

    public function testBadCommand()
    {
        $this->expectException(BadMethodCallException::class);
        $command = new Core(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, '');
        $command->send();
    }

    /**
     * @expectedException MalformedRequestException
     */
    public function testNonApiCommand()
    {
        $this->expectException(MalformedRequestException::class);
        $command = new Core(DIRECTADMIN_URL, MASTER_ADMIN_USERNAME, MASTER_ADMIN_PASSWORD);
        $reflection = new ReflectionObject($command);
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
