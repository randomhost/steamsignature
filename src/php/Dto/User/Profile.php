<?php

declare(strict_types=1);

namespace randomhost\Steam\Dto\User;

/**
 * Represents a Steam user profile available under a 64 bit Steam community id.
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2022 Random-Host.tv
 * @license   https://opensource.org/licenses/BSD-3-Clause  BSD License (3 Clause)
 *
 * @see https://github.random-host.tv
 */
class Profile
{
    /**
     * General instance.
     *
     * @var null|General
     */
    protected $dataUserGeneral;

    /**
     * Restricted instance.
     *
     * @var null|Restricted
     */
    protected $dataUserRestricted;

    /**
     * Constructor for this class.
     *
     * @param \stdClass $data \stdClass instance holding data.
     *
     * @throws \Exception
     */
    public function __construct(\stdClass $data)
    {
        $this->fetchDataUserGeneral($data);
        $this->fetchDataUserRestricted($data);
    }

    /**
     * Returns general user data.
     */
    public function getDataUserGeneral(): ?General
    {
        return $this->dataUserGeneral;
    }

    /**
     * Returns restricted user data.
     */
    public function getDataUserRestricted(): ?Restricted
    {
        return $this->dataUserRestricted;
    }

    /**
     * Sets general publicly accessible user data.
     *
     * @param \stdClass $data \stdClass instance holding data.
     *
     * @throws \Exception
     */
    protected function fetchDataUserGeneral(\stdClass $data): void
    {
        $this->dataUserGeneral = new General();
        $this->dataUserGeneral
            ->setSteamId($data->steamid)
            ->setDisplayName($data->personaname)
            ->setProfileUrl($data->profileurl)
            ->setAvatar($data->avatar)
            ->setAvatarMedium($data->avatarmedium)
            ->setAvatarFull($data->avatarfull)
            ->setPersonaState($data->personastate)
            ->setCommunityVisibilityState($data->communityvisibilitystate)
            ->setProfileState(!empty($data->profilestate))
            ->setCommentPermission(!empty($data->commentpermission))
        ;

        if (isset($data->lastlogoff)) {
            $this->dataUserGeneral
                ->setLastLogoff(new \DateTime('@'.$data->lastlogoff))
            ;
        }
    }

    /**
     * If visible, sets private publicly accessible data.
     *
     * @param \stdClass $data \stdClass instance holding data.
     *
     * @throws \Exception
     */
    protected function fetchDataUserRestricted(\stdClass $data): void
    {
        if (!empty($this->dataUserGeneral)
            && !$this->dataUserGeneral->isPrivateProfile()
        ) {
            $this->dataUserRestricted = new Restricted();

            // general profile data
            if (!empty($data->realname)) {
                $this->dataUserRestricted->setRealName($data->realname);
            }

            if (!empty($data->primaryclanid)) {
                $this->dataUserRestricted->setPrimaryGroupId(
                    $data->primaryclanid
                );
            }

            if (!empty($data->timecreated)) {
                $this->dataUserRestricted->setTimeCreated(
                    new \DateTime('@'.$data->timecreated)
                );
            }

            // location data
            $locationData = new Location();

            if (!empty($data->loccountrycode)) {
                $locationData->setCountryCode($data->loccountrycode);
            }
            if (!empty($data->locstatecode)) {
                $locationData->setStateCode($data->locstatecode);
            }
            if (!empty($data->loccityid)) {
                $locationData->setCityId($data->loccityid);
            }

            $this->dataUserRestricted->setLocationData($locationData);

            // game data
            if (!empty($data->gameextrainfo)) {
                $gameData = new Game();

                $gameData->setExtraInfo($data->gameextrainfo);

                if (!empty($data->gameid)) {
                    $gameData->setId($data->gameid);
                }
                if (!empty($data->gameserverip)) {
                    $gameData->setServerIp($data->gameserverip);
                }

                $this->dataUserRestricted->setGameData($gameData);
            }
        }
    }
}
