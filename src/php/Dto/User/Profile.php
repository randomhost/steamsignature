<?php
namespace randomhost\Steam\Dto\User;

/**
 * Represents a Steam user profile available under a 64 bit Steam community id.
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2016 random-host.com
 * @license   http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @link      http://github.random-host.com/steamsignature/
 */
class Profile
{
    /**
     * General instance.
     *
     * @var null|General
     */
    protected $dataUserGeneral = null;

    /**
     * Restricted instance.
     *
     * @var null|Restricted
     */
    protected $dataUserRestricted = null;

    /**
     * Constructor for this class.
     *
     * @param \stdClass $data \stdClass instance holding data.
     */
    public function __construct(\stdClass $data)
    {
        $this->fetchDataUserGeneral($data);
        $this->fetchDataUserRestricted($data);
    }

    /**
     * Returns general user data.
     *
     * @return null|General
     */
    public function getDataUserGeneral()
    {
        return $this->dataUserGeneral;
    }

    /**
     * Returns restricted user data.
     *
     * @return null|Restricted
     */
    public function getDataUserRestricted()
    {
        return $this->dataUserRestricted;
    }

    /**
     * Sets general publicly accessible user data.
     *
     * @param \stdClass $data \stdClass instance holding data.
     *
     * @return void
     */
    protected function fetchDataUserGeneral(\stdClass $data)
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
            ->setLastLogoff(new \DateTime('@' . $data->lastlogoff))
            ->setCommentPermission(!empty($data->commentpermission));
    }

    /**
     * If visible, sets private publicly accessible data.
     *
     * @param \stdClass $data \stdClass instance holding data.
     *
     * @return void
     */
    protected function fetchDataUserRestricted(\stdClass $data)
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
                    new \DateTime('@' . $data->timecreated)
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
                $locationData->setCityName($data->loccityid);
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
