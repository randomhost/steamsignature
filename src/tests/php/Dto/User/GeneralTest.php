<?php

declare(strict_types=1);

namespace randomhost\Steam\Tests\Dto\User;

use PHPUnit\Framework\TestCase;
use randomhost\Steam\Dto\User\General;

/**
 * Unit test for {@see General}.
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2024 Random-Host.tv
 * @license   https://opensource.org/licenses/BSD-3-Clause  BSD License (3 Clause)
 *
 * @see https://github.random-host.tv
 */
class GeneralTest extends TestCase
{
    /**
     * Tests {@see General::setSteamId()} and {@see General::getSteamId()}.
     */
    public function testSetGetSteamId()
    {
        $id = '1234567890';

        $general = new General();

        $this->assertSame($general, $general->setSteamId($id));
        $this->assertSame($id, $general->getSteamId());
    }

    /**
     * Tests {@see General::setDisplayName()} and {@see General::getDisplayName()}.
     */
    public function testSetGetDisplayName()
    {
        $displayName = '0815 Gamer';

        $general = new General();

        $this->assertSame($general, $general->setDisplayName($displayName));
        $this->assertSame($displayName, $general->getDisplayName());
    }

    /**
     * Tests {@see General::setProfileUrl()} and {@see General::getProfileUrl()}.
     */
    public function testSetGetProfileUrl()
    {
        $profileUrl = 'https://steamcommunity.com/id/0815gamer';

        $general = new General();

        $this->assertSame($general, $general->setProfileUrl($profileUrl));
        $this->assertSame($profileUrl, $general->getProfileUrl());
    }

    /**
     * Tests {@see General::setAvatar()} and {@see General::getAvatar()}.
     */
    public function testSetGetAvatar()
    {
        $avatar = 'https://steamcdn-a.akamaihd.net/steamcommunity/public/'.
            'images/avatars/12/1234567890abcdefghijklmnopqrstuvwxyz.jpg';

        $general = new General();

        $this->assertSame($general, $general->setAvatar($avatar));
        $this->assertSame($avatar, $general->getAvatar());
    }

    /**
     * Tests {@see General::setAvatarMedium()} and {@see General::getAvatarMedium()}.
     */
    public function testSetGetAvatarMedium()
    {
        $avatar = 'https://steamcdn-a.akamaihd.net/steamcommunity/public/'.
            'images/avatars/12/1234567890abcdefghijklmnopqrstuvwxyz_medium.jpg';

        $general = new General();

        $this->assertSame($general, $general->setAvatarMedium($avatar));
        $this->assertSame($avatar, $general->getAvatarMedium());
    }

    /**
     * Tests {@see General::setAvatarFull()} and {@see General::getAvatarFull()}.
     */
    public function testSetGetAvatarFull()
    {
        $avatar = 'https://steamcdn-a.akamaihd.net/steamcommunity/public/'.
            'images/avatars/12/1234567890abcdefghijklmnopqrstuvwxyz_full.jpg';

        $general = new General();

        $this->assertSame($general, $general->setAvatarFull($avatar));
        $this->assertSame($avatar, $general->getAvatarFull());
    }

    /**
     * Tests {@see General::setPersonaState()} and {@see General::getPersonaState()}.
     */
    public function testSetGetPersonaState()
    {
        $personaState = 0;

        $general = new General();

        $this->assertSame($general, $general->setPersonaState($personaState));
        $this->assertSame($personaState, $general->getPersonaState());
    }

    /**
     * Tests {@see General::getPersonaStateString()}.
     *
     * @param int    $personaState   User's current status.
     * @param string $expectedResult User's current status as human-readable string.
     *
     * @dataProvider providerPersonaStateMappings
     */
    public function testGetPersonaStateString(int $personaState, string $expectedResult)
    {
        $general = new General();

        $this->assertSame($general, $general->setPersonaState($personaState));
        $this->assertSame($expectedResult, $general->getPersonaStateString());
    }

    /**
     * Tests {@see General::setCommunityVisibilityState()} and {@see General::getCommunityVisibilityState()}.
     */
    public function testSetGetCommunityVisibilityState()
    {
        $visibilityState = 0;

        $general = new General();

        $this->assertSame(
            $general,
            $general->setCommunityVisibilityState($visibilityState)
        );
        $this->assertSame(
            $visibilityState,
            $general->getCommunityVisibilityState()
        );
    }

    /**
     * Tests {@see General::getCommunityVisibilityStateString()}.
     *
     * @param int    $visibilityState Whether the profile is visible or not.
     * @param string $expectedResult  Whether the profile is visible or not as human-readable string.
     *
     * @dataProvider providerCommunityVisibilityStateMapping
     */
    public function testGetCommunityVisibilityStateString(int $visibilityState, string $expectedResult)
    {
        $general = new General();

        $this->assertSame(
            $general,
            $general->setCommunityVisibilityState($visibilityState)
        );
        $this->assertSame(
            $expectedResult,
            $general->getCommunityVisibilityStateString()
        );
    }

    /**
     * Tests {@see General::setProfileState()} and {@see General::getProfileState()}.
     */
    public function testSetGetProfileState()
    {
        $general = new General();

        $this->assertSame($general, $general->setProfileState(true));
        $this->assertTrue($general->getProfileState());
    }

    /**
     * Tests {@see General::setLastLogoff()} and {@see General::getLastLogoff()}.
     */
    public function testSetGetLastLogoff()
    {
        $lastLogoff = new \DateTime('now');

        $general = new General();

        $this->assertSame($general, $general->setLastLogoff($lastLogoff));
        $this->assertSame($lastLogoff, $general->getLastLogoff());
    }

    /**
     * Tests {@see General::setCommentPermission()} and {@see General::getCommentPermission()}.
     */
    public function testSetGetCommentPermission()
    {
        $general = new General();

        $this->assertSame(
            $general,
            $general->setCommentPermission(true)
        );
        $this->assertTrue($general->getCommentPermission());
    }

    /**
     * Tests {@see General::isPrivateProfile()}.
     */
    public function testIsPrivateProfile()
    {
        $general = new General();

        $this->assertSame(
            $general,
            $general->setCommunityVisibilityState(
                General::COMMUNITY_VISIBILITY_STATE_PRIVATE
            )
        );
        $this->assertTrue($general->isPrivateProfile());

        $this->assertSame(
            $general,
            $general->setCommunityVisibilityState(
                General::COMMUNITY_VISIBILITY_STATE_PUBLIC
            )
        );
        $this->assertFalse($general->isPrivateProfile());
    }

    /**
     * Tests {@see General::isOnline()}.
     *
     * @param int $personaState User's current status.
     *
     * @dataProvider providerPersonaStateMappings
     */
    public function testIsOnline(int $personaState)
    {
        $general = new General();

        $this->assertSame($general, $general->setPersonaState($personaState));
        $this->assertSame(
            General::PERSONA_STATE_OFFLINE !== $personaState,
            $general->isOnline()
        );
    }

    /**
     * Data provider for persona state mappings.
     */
    public function providerPersonaStateMappings(): \Generator
    {
        yield [General::PERSONA_STATE_OFFLINE, 'offline'];

        yield [General::PERSONA_STATE_ONLINE, 'online'];

        yield [General::PERSONA_STATE_BUSY, 'busy'];

        yield [General::PERSONA_STATE_AWAY, 'away'];

        yield [General::PERSONA_STATE_SNOOZE, 'snooze'];

        yield [General::PERSONA_STATE_LOOKING_TO_TRADE, 'looking to trade'];

        yield [General::PERSONA_STATE_LOOKING_TO_PLAY, 'looking to play'];

        yield [-1, 'Unknown status: -1'];
    }

    /**
     * Data provider for community visibility state mappings.
     */
    public function providerCommunityVisibilityStateMapping(): \Generator
    {
        yield [General::COMMUNITY_VISIBILITY_STATE_PRIVATE, 'private'];

        yield [General::COMMUNITY_VISIBILITY_STATE_PUBLIC, 'public'];

        yield [-1, 'Unknown profile visibility: -1'];
    }
}
