<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Game class definition
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
 * Represents private Steam user game data
 *
 * @category  Steam
 * @package   PHP_Steam_Signature
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2014 random-host.com
 * @license   http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @version   Release: @package_version@
 * @link      https://pear.random-host.com/
 */
class Game
{
    /**
     * Game ID of the game the user is currently playing.
     *
     * @var int
     */
    protected $id = 0;

    /**
     * IP and port of the game server the user is currently playing on.
     *
     * @var string
     */
    protected $serverIp = '0.0.0.0:0';

    /**
     * Name of the game the user is playing.
     *
     * This may be the name of a non-Steam game shortcut.
     *
     * @var string
     */
    protected $extraInfo = '';

    /**
     * Sets the game ID of the game the user is currently playing.
     *
     * @param int $id Game ID of the game the user is currently playing.
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns the game ID of the game the user is currently playing.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets IP and port of the game server the user is currently playing on.
     *
     * @param string $serverIp IP and port of the game server the user is
     *                         currently playing on.
     *
     * @return $this
     */
    public function setServerIp($serverIp)
    {
        $this->serverIp = $serverIp;

        return $this;
    }

    /**
     * Returns IP and port of the game server the user is currently playing on.
     *
     * @return string
     */
    public function getServerIp()
    {
        return $this->serverIp;
    }

    /**
     * Sets the name of the game the user is playing.
     *
     * @param string $extraInfo Name of the game the user is playing.
     *
     * @return $this;
     */
    public function setExtraInfo($extraInfo)
    {
        $this->extraInfo = $extraInfo;

        return $this;
    }

    /**
     * Returns the name of the game the user is playing.
     *
     * @return string
     */
    public function getExtraInfo()
    {
        return $this->extraInfo;
    }

    /**
     * Returns whether the current game session is a multiplayer game session.
     *
     * @return bool
     */
    public function isMultiplayer()
    {
        return ($this->getServerIp() !== '0.0.0.0:0');
    }

    /**
     * Returns whether the current multiplayer session is joinable.
     *
     * @return bool
     */
    public function isJoinable()
    {
        if (!$this->isMultiplayer()) {
            return false;
        }
        $ipAddress = parse_url($this->getServerIp());
        return false !== filter_var(
            $ipAddress['host'],
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        );
    }
} 
