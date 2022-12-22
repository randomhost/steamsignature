<?php

declare(strict_types=1);

namespace randomhost\Steam\Tests\Dto\User;

use PHPUnit\Framework\TestCase;
use randomhost\Steam\Dto\User\Game;

/**
 * Unit test for {@see Game}.
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2022 Random-Host.tv
 * @license   https://opensource.org/licenses/BSD-3-Clause  BSD License (3 Clause)
 *
 * @see https://github.random-host.tv
 */
class GameTest extends TestCase
{
    /**
     * Tests {@see Game::setId()} and {@see Game::getId()}.
     */
    public function testSetGetId()
    {
        $id = '1234567890';

        $game = new Game();

        $this->assertSame($game, $game->setId($id));
        $this->assertSame($id, $game->getId());
    }

    /**
     * Tests {@see Game::setServerIp()} and {@see Game::getServerIp()}.
     */
    public function testSetGetServerIp()
    {
        $serverIp = '0.0.0.0:0';

        $game = new Game();

        $this->assertSame($game, $game->setServerIp($serverIp));
        $this->assertSame($serverIp, $game->getServerIp());
    }

    /**
     * Tests {@see Game::setExtraInfo()} and {@see Game::getExtraInfo()}.
     */
    public function testSetGetExtraInfo()
    {
        $extraInfo = 'Generic Shooter';

        $game = new Game();

        $this->assertSame($game, $game->setExtraInfo($extraInfo));
        $this->assertSame($extraInfo, $game->getExtraInfo());
    }

    /**
     * Tests {@see Game::isMultiplayer()}.
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
     * Tests {@see Game::isJoinable()}.
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
     * Tests {@see Game::getConnectURL()}.
     */
    public function testGetConnectURLFormat()
    {
        $serverIpLocal = '127.0.0.1:80';
        $serverIpExternal = '172.217.16.195:80';

        $game = new Game();

        $this->assertFalse($game->isJoinable());

        $this->assertSame($game, $game->setServerIp($serverIpLocal));
        $this->assertSame('', $game->getConnectURL());

        $this->assertSame($game, $game->setServerIp($serverIpExternal));
        $this->assertSame(
            'steam://connect/'.$serverIpExternal,
            $game->getConnectURL()
        );
    }
}
