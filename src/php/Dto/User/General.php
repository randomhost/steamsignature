<?php

declare(strict_types=1);

namespace randomhost\Steam\Dto\User;

/**
 * Represents public Steam user data.
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2024 Random-Host.tv
 * @license   https://opensource.org/licenses/BSD-3-Clause  BSD License (3 Clause)
 *
 * @see https://github.random-host.tv
 */
class General
{
    /**
     * Persona state constants.
     *
     * @var int
     */
    public const PERSONA_STATE_OFFLINE = 0;
    public const PERSONA_STATE_ONLINE = 1;
    public const PERSONA_STATE_BUSY = 2;
    public const PERSONA_STATE_AWAY = 3;
    public const PERSONA_STATE_SNOOZE = 4;
    public const PERSONA_STATE_LOOKING_TO_TRADE = 5;
    public const PERSONA_STATE_LOOKING_TO_PLAY = 6;

    /**
     * Community visibility state constants.
     *
     * @var int
     */
    public const COMMUNITY_VISIBILITY_STATE_PRIVATE = 1;
    public const COMMUNITY_VISIBILITY_STATE_PUBLIC = 3;

    /**
     * Mapping of persona state integer values to strings.
     *
     * @var array
     */
    protected const PERSONA_STATE_MAPPING = [
        self::PERSONA_STATE_OFFLINE => 'offline',
        self::PERSONA_STATE_ONLINE => 'online',
        self::PERSONA_STATE_BUSY => 'busy',
        self::PERSONA_STATE_AWAY => 'away',
        self::PERSONA_STATE_SNOOZE => 'snooze',
        self::PERSONA_STATE_LOOKING_TO_TRADE => 'looking to trade',
        self::PERSONA_STATE_LOOKING_TO_PLAY => 'looking to play',
    ];

    /**
     * Mapping of community visibility state integer values to strings.
     *
     * @var array
     */
    protected const COMMUNITY_VISIBILITY_STATE_MAPPING = [
        self::COMMUNITY_VISIBILITY_STATE_PRIVATE => 'private',
        self::COMMUNITY_VISIBILITY_STATE_PUBLIC => 'public',
    ];

    /**
     * 64bit SteamID of the user.
     *
     * This is of type string to be compatible with 32-bit systems
     */
    protected string $steamId = '';

    /**
     * User's display name.
     */
    protected string $displayName = '';

    /**
     * Full URL of the user's Steam community profile.
     */
    protected string $profileUrl = '';

    /**
     * Full URL of the user's 32x32px avatar.
     *
     * If the user hasn't configured an avatar, this will be the default ? avatar.
     */
    protected string $avatar = '';

    /**
     * Full URL of the user's 64x64px avatar.
     *
     * If the user hasn't configured an avatar, this will be the default ? avatar.
     */
    protected string $avatarMedium = '';

    /**
     * Full URL of the user's 184x184px avatar.
     *
     * If the user hasn't configured an avatar, this will be the default ? avatar.
     */
    protected string $avatarFull = '';

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
     */
    protected int $personaState = 0;

    /**
     * This represents whether the profile is visible or not.
     *
     * Note that because the WebAPI does not use authentication, there are only
     * two possible values returned:
     *
     * 1 - profile is not visible (Private, Friends Only, etc.)
     * 3 - profile is "Public"
     */
    protected int $communityVisibilityState = 0;

    /**
     * Indicates if the user has a community profile configured.
     */
    protected bool $profileState = false;

    /**
     * Last time the user was online as \DateTime object.
     */
    protected ?\DateTime $lastLogoff;

    /**
     * Indicates if the profile allows public comments.
     */
    protected bool $commentPermission = false;

    /**
     * Sets the 64bit SteamID of the user.
     *
     * @param string $steamId 64bit SteamID of the user.
     */
    public function setSteamId(string $steamId): self
    {
        $this->steamId = $steamId;

        return $this;
    }

    /**
     * Returns the 64bit SteamID of the user.
     */
    public function getSteamId(): string
    {
        return $this->steamId;
    }

    /**
     * Sets the user's display name.
     *
     * @param string $displayName User's display name
     */
    public function setDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * Returns the user's display name.
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * Sets the full URL of the user's Steam community profile.
     *
     * @param string $profileUrl Full URL of the user's Steam community profile.
     */
    public function setProfileUrl(string $profileUrl): self
    {
        $this->profileUrl = $profileUrl;

        return $this;
    }

    /**
     * Returns the full URL of the user's Steam community profile.
     */
    public function getProfileUrl(): string
    {
        return $this->profileUrl;
    }

    /**
     * Sets the full URL of the user's 32x32px avatar.
     *
     * @param string $avatar Full URL of the user's 32x32px avatar.
     */
    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Returns the full URL of the user's 32x32px avatar.
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * Sets the full URL of the user's 64x64px avatar.
     *
     * @param string $avatarMedium Full URL of the user's 64x64px avatar.
     */
    public function setAvatarMedium(string $avatarMedium): self
    {
        $this->avatarMedium = $avatarMedium;

        return $this;
    }

    /**
     * Returns the full URL of the user's 64x64px avatar.
     */
    public function getAvatarMedium(): string
    {
        return $this->avatarMedium;
    }

    /**
     * Sets the full URL of the user's 184x184px avatar.
     *
     * @param string $avatarFull Full URL of the user's 184x184px avatar.
     */
    public function setAvatarFull(string $avatarFull): self
    {
        $this->avatarFull = $avatarFull;

        return $this;
    }

    /**
     * Returns the full URL of the user's 184x184px avatar.
     */
    public function getAvatarFull(): string
    {
        return $this->avatarFull;
    }

    /**
     * Sets the user's current status.
     *
     * @param int $personaState User's current status
     */
    public function setPersonaState(int $personaState): self
    {
        $this->personaState = $personaState;

        return $this;
    }

    /**
     * Returns the user's current status.
     *
     * If the user's profile is private, this will always be "0".
     */
    public function getPersonaState(): int
    {
        return $this->personaState;
    }

    /**
     * Returns the user's current status as human-readable string.
     *
     * If the user's profile is private, this will always be "offline".
     */
    public function getPersonaStateString(): string
    {
        $key = $this->getPersonaState();
        if (!array_key_exists($key, self::PERSONA_STATE_MAPPING)) {
            return 'Unknown status: '.$key;
        }

        return self::PERSONA_STATE_MAPPING[$key];
    }

    /**
     * Sets whether the profile is visible or not.
     *
     * @param int $communityVisibilityState Whether the profile is visible or not.
     */
    public function setCommunityVisibilityState(int $communityVisibilityState): self
    {
        $this->communityVisibilityState = $communityVisibilityState;

        return $this;
    }

    /**
     * Returns whether the profile is visible or not.
     */
    public function getCommunityVisibilityState(): int
    {
        return $this->communityVisibilityState;
    }

    /**
     * Returns whether the profile is visible or not as human-readable string.
     */
    public function getCommunityVisibilityStateString(): string
    {
        $key = $this->getCommunityVisibilityState();
        if (!array_key_exists($key, self::COMMUNITY_VISIBILITY_STATE_MAPPING)) {
            return 'Unknown profile visibility: '.$key;
        }

        return self::COMMUNITY_VISIBILITY_STATE_MAPPING[$key];
    }

    /**
     * Sets if the user has a community profile configured.
     *
     * @param bool $profileState If the user has a community profile configured.
     */
    public function setProfileState(bool $profileState): self
    {
        $this->profileState = $profileState;

        return $this;
    }

    /**
     * Returns if the user has a community profile configured.
     */
    public function getProfileState(): bool
    {
        return $this->profileState;
    }

    /**
     * Sets the last time the user was online as \DateTime object.
     *
     * @param null|\DateTime $lastLogoff Last time the user was online as
     *                                   \DateTime object.
     */
    public function setLastLogoff(?\DateTime $lastLogoff): self
    {
        $this->lastLogoff = $lastLogoff;

        return $this;
    }

    /**
     * Returns the last time the user was online as \DateTime object.
     */
    public function getLastLogoff(): ?\DateTime
    {
        return $this->lastLogoff;
    }

    /**
     * Sets if the profile allows public comments.
     *
     * @param bool $commentPermission If the profile allows public comments.
     */
    public function setCommentPermission(bool $commentPermission): self
    {
        $this->commentPermission = $commentPermission;

        return $this;
    }

    /**
     * Returns if the profile allows public comments.
     */
    public function getCommentPermission(): bool
    {
        return $this->commentPermission;
    }

    /**
     * Returns whether the user profile is private or not.
     */
    public function isPrivateProfile(): bool
    {
        $visible = $this->getCommunityVisibilityState();

        return self::COMMUNITY_VISIBILITY_STATE_PUBLIC !== $visible;
    }

    /**
     * Returns whether the user is online or not.
     */
    public function isOnline(): bool
    {
        $state = $this->getPersonaState();

        return self::PERSONA_STATE_OFFLINE !== $state;
    }
}
