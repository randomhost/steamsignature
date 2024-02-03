<?php

declare(strict_types=1);

namespace randomhost\Steam\Dto\User;

/**
 * Represents private Steam user game data.
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2024 Random-Host.tv
 * @license   https://opensource.org/licenses/BSD-3-Clause  BSD License (3 Clause)
 *
 * @see https://github.random-host.tv
 */
class Game
{
    /**
     * Game ID of the game the user is currently playing.
     */
    protected string $id = '0';

    /**
     * IP and port of the game server the user is currently playing on.
     */
    protected string $serverIp = '0.0.0.0:0';

    /**
     * Name of the game the user is playing.
     *
     * This may be the name of a non-Steam game shortcut.
     */
    protected string $extraInfo = '';

    /**
     * Sets the game ID of the game the user is currently playing.
     *
     * @param string $id Game ID of the game the user is currently playing.
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns the game ID of the game the user is currently playing.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Sets IP and port of the game server the user is currently playing on.
     *
     * @param string $serverIp IP and port of the game server the user is
     *                         currently playing on.
     */
    public function setServerIp(string $serverIp): self
    {
        $this->serverIp = $serverIp;

        return $this;
    }

    /**
     * Returns IP and port of the game server the user is currently playing on.
     */
    public function getServerIp(): string
    {
        return $this->serverIp;
    }

    /**
     * Sets the name of the game the user is playing.
     *
     * @param string $extraInfo Name of the game the user is playing.
     */
    public function setExtraInfo(string $extraInfo): self
    {
        $this->extraInfo = $extraInfo;

        return $this;
    }

    /**
     * Returns the name of the game the user is playing.
     */
    public function getExtraInfo(): string
    {
        return $this->extraInfo;
    }

    /**
     * Returns whether the current game session is a multiplayer game session.
     */
    public function isMultiplayer(): bool
    {
        return '0.0.0.0:0' !== $this->getServerIp();
    }

    /**
     * Returns whether the current multiplayer session is joinable.
     */
    public function isJoinable(): bool
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

    /**
     * Returns a "steam://connect/" URL for the current multiplayer session.
     */
    public function getConnectURL(): string
    {
        if (!$this->isJoinable()) {
            return '';
        }

        return 'steam://connect/'.$this->getServerIp();
    }
}
