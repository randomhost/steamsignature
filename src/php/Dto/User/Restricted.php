<?php
namespace randomhost\Steam\Dto\User;

/**
 * Represents private Steam user data
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2016 random-host.com
 * @license   http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @link      http://github.random-host.com/steamsignature/
 */
class Restricted
{
    /**
     * Player's "Real Name".
     *
     * @var string
     */
    protected $realName = '';

    /**
     * Player's primary group ID.
     *
     * @var string
     */
    protected $primaryGroupId = '';

    /**
     * Time the player's account was created.
     *
     * @var null|\DateTime
     */
    protected $timeCreated = null;

    /**
     * Game data of the game the user is currently playing.
     *
     * @var Game|null
     */
    protected $gameData = null;

    /**
     * Player's location data.
     *
     * @var Location|null
     */
    protected $locationData = null;

    /**
     * Sets the player's "Real Name".
     *
     * @param string $realName Player's "Real Name".
     *
     * @return $this
     */
    public function setRealName($realName)
    {
        $this->realName = $realName;

        return $this;
    }

    /**
     * Returns the player's "Real Name".
     *
     * @return string
     */
    public function getRealName()
    {
        return $this->realName;
    }

    /**
     * Sets the player's primary group ID.
     *
     * @param string $primaryGroup Player's primary group ID.
     *
     * @return $this
     */
    public function setPrimaryGroupId($primaryGroup)
    {
        $this->primaryGroupId = $primaryGroup;

        return $this;
    }

    /**
     * Returns the player's primary group ID.
     *
     * @return string
     */
    public function getPrimaryGroupId()
    {
        return $this->primaryGroupId;
    }

    /**
     * Sets the time the player's account was created.
     *
     * @param null|\DateTime $timeCreated Time the player's account was created.
     *
     * @return $this
     */
    public function setTimeCreated(\DateTime $timeCreated)
    {
        $this->timeCreated = $timeCreated;

        return $this;
    }

    /**
     * Returns the time the player's account was created.
     *
     * @return null|\DateTime
     */
    public function getTimeCreated()
    {
        return $this->timeCreated;
    }

    /**
     * Sets the game data of the game the user is currently playing.
     *
     * @param null|Game $gameData Game data of the game the user is currently playing.
     *
     * @return $this
     */
    public function setGameData(Game $gameData)
    {
        $this->gameData = $gameData;

        return $this;
    }

    /**
     * Returns the game data of the game the user is currently playing.
     *
     * @return null|Game
     */
    public function getGameData()
    {
        return $this->gameData;
    }

    /**
     * Sets the player's location data.
     *
     * @param null|Location $locationData  Player's location data.
     *
     * @return $this
     */
    public function setLocationData(Location $locationData)
    {
        $this->locationData = $locationData;

        return $this;
    }

    /**
     * Returns the player's location data.
     *
     * @return null|Location
     */
    public function getLocationData()
    {
        return $this->locationData;
    }
}
