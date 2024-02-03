<?php

declare(strict_types=1);

namespace randomhost\Steam\Dto\User;

/**
 * Represents private Steam user data.
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2024 Random-Host.tv
 * @license   https://opensource.org/licenses/BSD-3-Clause  BSD License (3 Clause)
 *
 * @see https://github.random-host.tv
 */
class Restricted
{
    /**
     * Player's "Real Name".
     */
    protected string $realName = '';

    /**
     * Player's primary group ID.
     */
    protected string $primaryGroupId = '';

    /**
     * Time the player's account was created.
     */
    protected ?\DateTime $timeCreated = null;

    /**
     * Game data of the game the user is currently playing.
     */
    protected ?Game $gameData = null;

    /**
     * Player's location data.
     */
    protected ?Location $locationData = null;

    /**
     * Sets the player's "Real Name".
     *
     * @param string $realName Player's "Real Name".
     */
    public function setRealName(string $realName): self
    {
        $this->realName = $realName;

        return $this;
    }

    /**
     * Returns the player's "Real Name".
     */
    public function getRealName(): string
    {
        return $this->realName;
    }

    /**
     * Sets the player's primary group ID.
     *
     * @param string $primaryGroup Player's primary group ID.
     */
    public function setPrimaryGroupId(string $primaryGroup): self
    {
        $this->primaryGroupId = $primaryGroup;

        return $this;
    }

    /**
     * Returns the player's primary group ID.
     */
    public function getPrimaryGroupId(): string
    {
        return $this->primaryGroupId;
    }

    /**
     * Sets the time the player's account was created.
     *
     * @param \DateTime $timeCreated Time the player's account was created.
     */
    public function setTimeCreated(\DateTime $timeCreated): self
    {
        $this->timeCreated = $timeCreated;

        return $this;
    }

    /**
     * Returns the time the player's account was created.
     */
    public function getTimeCreated(): ?\DateTime
    {
        return $this->timeCreated;
    }

    /**
     * Sets the game data of the game the user is currently playing.
     *
     * @param Game $gameData Game data of the game the user is currently playing.
     */
    public function setGameData(Game $gameData): self
    {
        $this->gameData = $gameData;

        return $this;
    }

    /**
     * Returns the game data of the game the user is currently playing.
     */
    public function getGameData(): ?Game
    {
        return $this->gameData;
    }

    /**
     * Sets the player's location data.
     *
     * @param Location $locationData Player's location data.
     */
    public function setLocationData(Location $locationData): self
    {
        $this->locationData = $locationData;

        return $this;
    }

    /**
     * Returns the player's location data.
     */
    public function getLocationData(): ?Location
    {
        return $this->locationData;
    }
}
