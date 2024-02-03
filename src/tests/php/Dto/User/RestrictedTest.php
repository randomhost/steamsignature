<?php

declare(strict_types=1);

namespace randomhost\Steam\Tests\Dto\User;

use PHPUnit\Framework\TestCase;
use randomhost\Steam\Dto\User\Game;
use randomhost\Steam\Dto\User\Location;
use randomhost\Steam\Dto\User\Restricted;

/**
 * Unit test for {@see Restricted}.
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2024 Random-Host.tv
 * @license   https://opensource.org/licenses/BSD-3-Clause  BSD License (3 Clause)
 *
 * @see https://github.random-host.tv
 */
class RestrictedTest extends TestCase
{
    /**
     * Tests {@see Restricted::setRealName()} and {@see Restricted::getRealName()}.
     */
    public function testSetGetRealName()
    {
        $realName = 'John Doe';

        $restricted = new Restricted();

        $this->assertSame($restricted, $restricted->setRealName($realName));
        $this->assertSame($realName, $restricted->getRealName());
    }

    /**
     * Tests {@see Restricted::setPrimaryGroupId()} and {@see Restricted::getPrimaryGroupId()}.
     */
    public function testSetGetPrimaryGroupId()
    {
        $primaryGroupId = '01234567890';

        $restricted = new Restricted();

        $this->assertSame($restricted, $restricted->setPrimaryGroupId($primaryGroupId));
        $this->assertSame($primaryGroupId, $restricted->getPrimaryGroupId());
    }

    /**
     * Tests {@see Restricted::setTimeCreated()} and {@see Restricted::getTimeCreated()}.
     */
    public function testSetTimeCreated()
    {
        $timeCreated = new \DateTime('now');
        $timeCreated->modify('-1 year');

        $restricted = new Restricted();

        $this->assertSame($restricted, $restricted->setTimeCreated($timeCreated));
        $this->assertSame($timeCreated, $restricted->getTimeCreated());
    }

    /**
     * Tests {@see Restricted::setGameData()} and {@see Restricted::getGameData()}.
     */
    public function testSetGetGameData()
    {
        /**
         * @var Game $gameData Game instance.
         */
        $gameData = $this->getMockBuilder(Game::class)->getMock();

        $restricted = new Restricted();

        $this->assertSame($restricted, $restricted->setGameData($gameData));
        $this->assertSame($gameData, $restricted->getGameData());
    }

    /**
     * Tests {@see Restricted::setLocationData()} and {@see Restricted::getLocationData()}.
     */
    public function testSetGetLocationData()
    {
        /**
         * @var Location $gameData Location instance.
         */
        $gameData = $this->getMockBuilder(Location::class)->getMock();

        $restricted = new Restricted();

        $this->assertSame($restricted, $restricted->setLocationData($gameData));
        $this->assertSame($gameData, $restricted->getLocationData());
    }
}
