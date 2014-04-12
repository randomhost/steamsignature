<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Restricted class definition
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
 * Represents private Steam user data
 *
 * @category  Steam
 * @package   PHP_Steam_Signature
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2014 random-host.com
 * @license   http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @version   Release: @package_version@
 * @link      https://pear.random-host.com/
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
     * Player's primary group.
     *
     * @var int
     */
    protected $primaryGroup = 0;

    /**
     * Time the player's account was created.
     *
     * @var int
     */
    protected $timeCreated = 0;

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
     * Sets the player's primary group.
     *
     * @param int $primaryGroup Player's primary group.
     *
     * @return $this
     */
    public function setPrimaryGroup($primaryGroup)
    {
        $this->primaryGroup = $primaryGroup;

        return $this;
    }

    /**
     * Returns the player's primary group.
     *
     * @return int
     */
    public function getPrimaryGroup()
    {
        return $this->primaryGroup;
    }

    /**
     * Sets the time the player's account was created.
     *
     * @param int $timeCreated Time the player's account was created.
     *
     * @return $this
     */
    public function setTimeCreated($timeCreated)
    {
        $this->timeCreated = $timeCreated;

        return $this;
    }

    /**
     * Returns the time the player's account was created.
     *
     * @return int
     */
    public function getTimeCreated()
    {
        return $this->timeCreated;
    }

    /**
     * Sets the game data of the game the user is currently playing.
     *
     * @param null|\randomhost\Steam\Data\User\Game $gameData Game data of the
     *                                                        game the user is
     *                                                        currently playing.
     *
     * @return $this
     */
    public function setGameData($gameData)
    {
        $this->gameData = $gameData;

        return $this;
    }

    /**
     * Returns the game data of the game the user is currently playing.
     *
     * @return null|\randomhost\Steam\Data\User\Game
     */
    public function getGameData()
    {
        return $this->gameData;
    }

    /**
     * Sets the player's location data.
     *
     * @param null|\randomhost\Steam\Data\User\Location $locationData Player's
     *                                                                location
     *                                                                data.
     *
     * @return $this
     */
    public function setLocationData($locationData)
    {
        $this->locationData = $locationData;

        return $this;
    }

    /**
     * Returns the player's location data.
     *
     * @return null|\randomhost\Steam\Data\User\Location
     */
    public function getLocationData()
    {
        return $this->locationData;
    }
}
