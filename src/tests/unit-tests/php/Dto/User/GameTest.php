<?php
namespace randomhost\Steam\Dto\User;

/**
 * Unit test for Game
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2016 random-host.com
 * @license   http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @link      http://php-steam-signature.random-host.com
 */
class GameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Game::setId() and Game::getId().
     */
    public function testSetGetId()
    {
        $id = '1234567890';

        $game = new Game();

        $this->assertSame($game, $game->setId($id));
        $this->assertEquals($id, $game->getId());
    }

    /**
     * Tests Game::setServerIp() and Game::getServerIp().
     */
    public function testSetGetServerIp()
    {
        $serverIp = '0.0.0.0:0';

        $game = new Game();

        $this->assertSame($game, $game->setServerIp($serverIp));
        $this->assertEquals($serverIp, $game->getServerIp());
    }

    /**
     * Tests Game::setExtraInfo() and Game::getExtraInfo().
     */
    public function testSetGetExtraInfo()
    {
        $extraInfo = 'Generic Shooter';

        $game = new Game();

        $this->assertSame($game, $game->setExtraInfo($extraInfo));
        $this->assertEquals($extraInfo, $game->getExtraInfo());
    }

    /**
     * Tests Game::isMultiplayer().
     */
    public function testIsMultiplayer()
    {
        $serverIp = '127.0.0.1:80';

        $game = new Game();

        $this->assertFalse($game->isMultiplayer());

        $this->assertSame($game, $game->setServerIp($serverIp));
        $this->assertTrue($game->isMultiplayer());
    }

    /**
     * Tests Game::isJoinable().
     */
    public function testIsJoinable()
    {
        $serverIpLocal = '127.0.0.1:80';
        $serverIpExternal = '172.217.16.195:80';

        $game = new Game();

        $this->assertFalse($game->isJoinable());

        $this->assertSame($game, $game->setServerIp($serverIpLocal));
        $this->assertFalse($game->isJoinable());

        $this->assertSame($game, $game->setServerIp($serverIpExternal));
        $this->assertTrue($game->isJoinable());
    }

    /**
     * Tests Game::getConnectURL().
     */
    public function testGetConnectURLFormat()
    {
        $serverIpLocal = '127.0.0.1:80';
        $serverIpExternal = '172.217.16.195:80';

        $game = new Game();

        $this->assertFalse($game->isJoinable());

        $this->assertSame($game, $game->setServerIp($serverIpLocal));
        $this->assertEquals('', $game->getConnectURL());

        $this->assertSame($game, $game->setServerIp($serverIpExternal));
        $this->assertEquals(
            'steam://connect/' . $serverIpExternal,
            $game->getConnectURL()
        );
    }
}
