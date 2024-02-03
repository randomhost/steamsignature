<?php

declare(strict_types=1);

namespace randomhost\Steam\Tests\Dto\User;

use PHPUnit\Framework\TestCase;
use randomhost\Steam\Dto\User\General;
use randomhost\Steam\Dto\User\Profile;
use randomhost\Steam\Dto\User\Restricted;

/**
 * Unit test for {@see Profile}.
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2024 Random-Host.tv
 * @license   https://opensource.org/licenses/BSD-3-Clause  BSD License (3 Clause)
 *
 * @see https://github.random-host.tv
 */
class ProfileTest extends TestCase
{
    /**
     * Test data JSON.
     */
    private const TEST_JSON = <<< 'JSON'
        {
            "steamid": "1234567890",
            "communityvisibilitystate": 3,
            "profilestate": 1,
            "personaname": "Random-Host.tv",
            "realname": "The Random-Host.tv Website",
            "lastlogoff": 1474092701,
            "profileurl": "https://steamcommunity.com/id/randomhosttv/",
            "avatar": "https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/12/1234567890abcdefghijklmnopqrstuvwxyz.jpg",
            "avatarmedium": "https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/12/1234567890abcdefghijklmnopqrstuvwxyz_medium.jpg",
            "avatarfull": "https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/12/1234567890abcdefghijklmnopqrstuvwxyz_full.jpg",
            "personastate": 1,
            "primaryclanid": "1234567890",
            "timecreated": 1070306852,
            "personastateflags": 0,
            "gameextrainfo": "Generic Shooter",
            "gameid": "123456789",
            "gameserverip": "127.0.0.1:80",
            "loccountrycode": "DE",
            "locstatecode": "07",
            "loccityid": 12728
        }
        JSON;

    /**
     * Decoded test data JSON.
     *
     * @var \stdClass
     */
    private $testData;

    /**
     * Sets up the test data.
     */
    protected function setUp(): void
    {
        $decoded = json_decode(self::TEST_JSON);
        if (!$decoded instanceof \stdClass) {
            throw new \RuntimeException('Failed to decode test JSON: '.json_last_error_msg());
        }

        $this->testData = $decoded;
    }

    /**
     * Tests {@see Restricted::getDataUserGeneral()}.
     *
     * @throws \Exception
     */
    public function testGetDataUserGeneral()
    {
        $profile = new Profile($this->testData);

        $this->assertInstanceOf(
            General::class,
            $profile->getDataUserGeneral()
        );
    }

    /**
     * Tests {@see Restricted::getDataUserRestricted()}.
     *
     * @throws \Exception
     */
    public function testGetDataUserRestricted()
    {
        $profile = new Profile($this->testData);

        $this->assertInstanceOf(
            Restricted::class,
            $profile->getDataUserRestricted()
        );
    }
}
