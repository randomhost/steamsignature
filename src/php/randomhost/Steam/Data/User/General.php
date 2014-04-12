<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * General class definition
 *
 * PHP version 5
 *
 * @category  Steam
 * @package   PHP_Steam_Signature
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2014 random-host.com
 * @license   http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @link      https://pear.random-host.com/
 */
namespace randomhost\Steam\Data\User;

/**
 * Represents public Steam user data
 *
 * @category  Steam
 * @package   PHP_Steam_Signature
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2014 random-host.com
 * @license   http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @version   Release: @package_version@
 * @link      https://pear.random-host.com/
 */
class General
{
    /**
     * Persona state constants.
     *
     * @var int
     */
    const PERSONA_STATE_OFFLINE = 0;
    const PERSONA_STATE_ONLINE = 1;
    const PERSONA_STATE_BUSY = 2;
    const PERSONA_STATE_AWAY = 3;
    const PERSONA_STATE_SNOOZE = 4;
    const PERSONA_STATE_LOOKING_TO_TRADE = 5;
    const PERSONA_STATE_LOOKING_TO_PLAY = 6;

    /**
     * Community visibility state constants.
     *
     * @var int
     */
    const COMMUNITY_VISIBILITY_STATE_PRIVATE = 1;
    const COMMUNITY_VISIBILITY_STATE_PUBLIC = 3;

    /**
     * Mapping of persona state integer values to strings.
     *
     * @var array
     */
    protected static $personaStateMapping
        = array(
            self::PERSONA_STATE_OFFLINE => 'offline',
            self::PERSONA_STATE_ONLINE => 'online',
            self::PERSONA_STATE_BUSY => 'busy',
            self::PERSONA_STATE_AWAY => 'away',
            self::PERSONA_STATE_SNOOZE => 'snooze',
            self::PERSONA_STATE_LOOKING_TO_TRADE => 'looking to trade',
            self::PERSONA_STATE_LOOKING_TO_PLAY => 'looking to play'
        );
    
    /**
     * Mapping of community visibility state integer values to strings.
     *
     * @var array
     */
    protected static $communityVisibilityStateMapping
        = array(
            self::COMMUNITY_VISIBILITY_STATE_PRIVATE => 'private',
            self::COMMUNITY_VISIBILITY_STATE_PUBLIC => 'public',
        );

    /**
     * 64bit SteamID of the user.
     *
     * This is of type string to be compatible with 32-bit systems
     *
     * @var string
     */
    protected $steamId = '';

    /**
     * Users's display name.
     *
     * @var string
     */
    protected $displayName = '';

    /**
     * Full URL of the user's Steam community profile.
     *
     * @var string
     */
    protected $profileUrl = '';

    /**
     * Full URL of the user's 32x32px avatar.
     *
     * If the user hasn't configured an avatar, this will be the default ? avatar.
     *
     * @var string
     */
    protected $avatar = '';

    /**
     * Full URL of the user's 64x64px avatar.
     *
     * If the user hasn't configured an avatar, this will be the default ? avatar.
     *
     * @var string
     */
    protected $avatarMedium = '';

    /**
     * Full URL of the users's 184x184px avatar.
     *
     * If the user hasn't configured an avatar, this will be the default ? avatar.
     *
     * @var string
     */
    protected $avatarFull = '';

    /**
     * User's current status.
     *
     * 0 - offline
     * 1 - online
     * 2 - busy
     * 3 - away
     * 4 - snooze
     * 5 - looking to trade
     * 6 - looking to play
     *
     * If the user's profile is private, this will always be "0".
     *
     * @var int
     */
    protected $personaState = 0;

    /**
     * This represents whether the profile is visible or not.
     *
     * Note that because the WebAPI does not use authentication, there are only
     * two possible values returned:
     *
     * 1 - profile is not visible (Private, Friends Only, etc.)
     * 3 - profile is "Public"
     *
     * @var int
     */
    protected $communityVisibilityState = 0;

    /**
     * Indicates if the user has a community profile configured.
     *
     * @var bool
     */
    protected $profileState = false;

    /**
     * Last time the user was online as unix timestamp.
     *
     * @var int
     */
    protected $lastLogoff = 0;

    /**
     * Indicates if the profile allows public comments.
     *
     * @var bool
     */
    protected $commentPermission = false;

    /**
     * Sets the 64bit SteamID of the user.
     *
     * @param string $steamId 64bit SteamID of the user.
     *
     * @return $this
     */
    public function setSteamId($steamId)
    {
        $this->steamId = $steamId;

        return $this;
    }

    /**
     * Returns the 64bit SteamID of the user.
     *
     * @return string
     */
    public function getSteamId()
    {
        return $this->steamId;
    }

    /**
     * Sets the users's display name.
     *
     * @param string $displayName Users's display name
     *
     * @return $this
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * Returns the users's display name.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Sets the full URL of the user's Steam community profile.
     *
     * @param string $profileUrl Full URL of the user's Steam community profile.
     *
     * @return $this
     */
    public function setProfileUrl($profileUrl)
    {
        $this->profileUrl = $profileUrl;

        return $this;
    }

    /**
     * Returns the full URL of the user's Steam community profile.
     *
     * @return string
     */
    public function getProfileUrl()
    {
        return $this->profileUrl;
    }

    /**
     * Sets the full URL of the user's 32x32px avatar.
     *
     * @param string $avatar Full URL of the user's 32x32px avatar.
     *
     * @return $this
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Returns the full URL of the user's 32x32px avatar.
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Sets the full URL of the user's 64x64px avatar.
     *
     * @param string $avatarMedium Full URL of the user's 64x64px avatar.
     *
     * @return $this
     */
    public function setAvatarMedium($avatarMedium)
    {
        $this->avatarMedium = $avatarMedium;

        return $this;
    }

    /**
     * Returns the full URL of the user's 64x64px avatar.
     *
     * @return string
     */
    public function getAvatarMedium()
    {
        return $this->avatarMedium;
    }

    /**
     * Sets the full URL of the users's 184x184px avatar.
     *
     * @param string $avatarFull Full URL of the users's 184x184px avatar.
     *
     * @return $this
     */
    public function setAvatarFull($avatarFull)
    {
        $this->avatarFull = $avatarFull;

        return $this;
    }

    /**
     * Returns the full URL of the users's 184x184px avatar.
     *
     * @return string
     */
    public function getAvatarFull()
    {
        return $this->avatarFull;
    }

    /**
     * Sets the user's current status.
     *
     * @param int $personaState User's current status
     *
     * @return $this
     */
    public function setPersonaState($personaState)
    {
        $this->personaState = $personaState;

        return $this;
    }

    /**
     * Returns the user's current status.
     *
     * If the user's profile is private, this will always be "0".
     *
     * @return int
     */
    public function getPersonaState()
    {
        return $this->personaState;
    }

    /**
     * Returns the user's current status as human-readable string.
     *
     * If the user's profile is private, this will always be "offline".
     *
     * @return string
     */
    public function getPersonaStateString()
    {
        $key = $this->getPersonaState();
        if (!array_key_exists($key, self::$personaStateMapping)) {
            return 'Unknown status: ' . $key;
        }
        return self::$personaStateMapping[$key];
    }

    /**
     * Sets whether the profile is visible or not.
     *
     * @param int $communityVisibilityState Whether the profile is visible or not.
     *
     * @return $this
     */
    public function setCommunityVisibilityState($communityVisibilityState)
    {
        $this->communityVisibilityState = $communityVisibilityState;

        return $this;
    }

    /**
     * Returns whether the profile is visible or not.
     * 
     * @return int
     */
    public function getCommunityVisibilityState()
    {
        return $this->communityVisibilityState;
    }
    
    /**
     * Returns whether the profile is visible or not as human-readable string.
     * 
     * @return int
     */
    public function getCommunityVisibilityStateString()
    {
        $key = $this->getCommunityVisibilityState();
        if (!array_key_exists($key, self::$communityVisibilityStateMapping)) {
            return 'Unknown profile visibility: ' . $key;
        }
        return self::$communityVisibilityStateMapping[$key];
    }

    /**
     * Sets if the user has a community profile configured.
     * 
     * @param boolean $profileState If the user has a community profile configured.
     *
     * @return $this
     */
    public function setProfileState($profileState)
    {
        $this->profileState = $profileState;

        return $this;
    }

    /**
     * Returns if the user has a community profile configured.
     * 
     * @return boolean
     */
    public function getProfileState()
    {
        return $this->profileState;
    }

    /**
     * Sets the last time the user was online as unix timestamp.
     * 
     * @param int $lastLogoff Last time the user was online as unix timestamp.
     *
     * @return $this
     */
    public function setLastLogoff($lastLogoff)
    {
        $this->lastLogoff = $lastLogoff;

        return $this;
    }

    /**
     * Returns the last time the user was online as unix timestamp.
     * 
     * @return int
     */
    public function getLastLogoff()
    {
        return $this->lastLogoff;
    }

    /**
     * Sets if the profile allows public comments.
     * 
     * @param boolean $commentPermission If the profile allows public comments.
     *
     * @return $this
     */
    public function setCommentPermission($commentPermission)
    {
        $this->commentPermission = $commentPermission;

        return $this;
    }

    /**
     * Returns if the profile allows public comments.
     * 
     * @return boolean
     */
    public function getCommentPermission()
    {
        return $this->commentPermission;
    }
}
