<?php
namespace randomhost\Steam\Dto\User;

/**
 * Unit test for General
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2016 random-host.com
 * @license   http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @link      http://php-steam-signature.random-host.com
 */
class GeneralTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests General::setSteamId() and General::getSteamId().
     */
    public function testSetGetSteamId()
    {
        $id = '1234567890';

        $general = new General();

        $this->assertSame($general, $general->setSteamId($id));
        $this->assertEquals($id, $general->getSteamId());
    }

    /**
     * Tests General::setDisplayName() and General::getDisplayName().
     */
    public function testSetGetDisplayName()
    {
        $displayName = '0815 Gamer';

        $general = new General();

        $this->assertSame($general, $general->setDisplayName($displayName));
        $this->assertEquals($displayName, $general->getDisplayName());
    }

    /**
     * Tests General::setProfileUrl() and General::getProfileUrl().
     */
    public function testSetGetProfileUrl()
    {
        $profileUrl = 'http://steamcommunity.com/id/0815gamer';

        $general = new General();

        $this->assertSame($general, $general->setProfileUrl($profileUrl));
        $this->assertEquals($profileUrl, $general->getProfileUrl());
    }

    /**
     * Tests General::setAvatar() and General::getAvatar().
     */
    public function testSetGetAvatar()
    {
        $avatar = 'https://steamcdn-a.akamaihd.net/steamcommunity/public/' .
            'images/avatars/12/1234567890abcdefghijklmnopqrstuvwxyz.jpg';

        $general = new General();

        $this->assertSame($general, $general->setAvatar($avatar));
        $this->assertEquals($avatar, $general->getAvatar());
    }

    /**
     * Tests General::setAvatarMedium() and General::getAvatarMedium().
     */
    public function testSetGetAvatarMedium()
    {
        $avatar = 'https://steamcdn-a.akamaihd.net/steamcommunity/public/' .
            'images/avatars/12/1234567890abcdefghijklmnopqrstuvwxyz_medium.jpg';

        $general = new General();

        $this->assertSame($general, $general->setAvatarMedium($avatar));
        $this->assertEquals($avatar, $general->getAvatarMedium());
    }

    /**
     * Tests General::setAvatarFull() and General::getAvatarFull().
     */
    public function testSetGetAvatarFull()
    {
        $avatar = 'https://steamcdn-a.akamaihd.net/steamcommunity/public/' .
            'images/avatars/12/1234567890abcdefghijklmnopqrstuvwxyz_full.jpg';

        $general = new General();

        $this->assertSame($general, $general->setAvatarFull($avatar));
        $this->assertEquals($avatar, $general->getAvatarFull());
    }

    /**
     * Tests General::setPersonaState() and General::getPersonaState().
     */
    public function testSetGetPersonaState()
    {
        $personaState = 0;

        $general = new General();

        $this->assertSame($general, $general->setPersonaState($personaState));
        $this->assertEquals($personaState, $general->getPersonaState());
    }

    /**
     * Tests General::getPersonaStateString().
     *
     * @param int    $personaState   User's current status.
     * @param string $expectedResult User's current status as human-readable string.
     *
     * @dataProvider providerPersonaStateMappings
     */
    public function testGetPersonaStateString($personaState, $expectedResult)
    {
        $general = new General();

        $this->assertSame($general, $general->setPersonaState($personaState));
        $this->assertEquals($expectedResult, $general->getPersonaStateString());
    }

    /**
     * Tests General::setCommunityVisibilityState() and General::getCommunityVisibilityState().
     */
    public function testSetGetCommunityVisibilityState()
    {
        $visibilityState = 0;

        $general = new General();

        $this->assertSame(
            $general,
            $general->setCommunityVisibilityState($visibilityState)
        );
        $this->assertEquals(
            $visibilityState,
            $general->getCommunityVisibilityState()
        );
    }

    /**
     * Tests General::getCommunityVisibilityStateString().
     *
     * @param int    $visibilityState Whether the profile is visible or not.
     * @param string $expectedResult  Whether the profile is visible or not as human-readable string.
     *
     * @dataProvider providerCommunityVisibilityStateMapping
     */
    public function testGetCommunityVisibilityStateString(
        $visibilityState,
        $expectedResult
    ) {
        $general = new General();

        $this->assertSame(
            $general,
            $general->setCommunityVisibilityState($visibilityState)
        );
        $this->assertEquals(
            $expectedResult,
            $general->getCommunityVisibilityStateString()
        );
    }

    /**
     * Tests General::setProfileState() and General::getProfileState().
     */
    public function testSetGetProfileState()
    {
        $profileState = true;

        $general = new General();

        $this->assertSame($general, $general->setProfileState($profileState));
        $this->assertEquals($profileState, $general->getProfileState());
    }

    /**
     * Tests General::setLastLogoff() and General::getLastLogoff().
     */
    public function testSetGetLastLogoff()
    {
        $lastLogoff = new \DateTime('now');

        $general = new General();

        $this->assertSame($general, $general->setLastLogoff($lastLogoff));
        $this->assertSame($lastLogoff, $general->getLastLogoff());
    }

    /**
     * Tests General::setCommentPermission() and General::getCommentPermission().
     */
    public function testSetGetCommentPermission()
    {
        $commentPermission = true;

        $general = new General();

        $this->assertSame(
            $general,
            $general->setCommentPermission($commentPermission)
        );
        $this->assertEquals(
            $commentPermission,
            $general->getCommentPermission()
        );
    }

    /**
     * Tests General::isPrivateProfile().
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
     * Tests General::isOnline().
     *
     * @param int $personaState User's current status.
     *
     * @dataProvider providerPersonaStateMappings
     */
    public function testIsOnline($personaState)
    {
        $general = new General();

        $this->assertSame($general, $general->setPersonaState($personaState));
        $this->assertEquals(
            $personaState !== General::PERSONA_STATE_OFFLINE,
            $general->isOnline()
        );
    }

    /**
     * Data provider for persona state mappings.
     *
     * @return array
     */
    public function providerPersonaStateMappings()
    {
        return array(
            array(General::PERSONA_STATE_OFFLINE, 'offline'),
            array(General::PERSONA_STATE_ONLINE, 'online'),
            array(General::PERSONA_STATE_BUSY, 'busy'),
            array(General::PERSONA_STATE_AWAY, 'away'),
            array(General::PERSONA_STATE_SNOOZE, 'snooze'),
            array(General::PERSONA_STATE_LOOKING_TO_TRADE, 'looking to trade'),
            array(General::PERSONA_STATE_LOOKING_TO_PLAY, 'looking to play'),
            array(-1, 'Unknown status: -1')
        );
    }

    /**
     * Data provider for community visibility state mappings.
     *
     * @return array
     */
    public function providerCommunityVisibilityStateMapping()
    {
        return array(
            array(General::COMMUNITY_VISIBILITY_STATE_PRIVATE, 'private'),
            array(General::COMMUNITY_VISIBILITY_STATE_PUBLIC, 'public'),
            array(-1, 'Unknown profile visibility: -1')
        );
    }
}
