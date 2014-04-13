<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Profile class definition
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

use randomhost\Steam\API;

/**
 * Represents a Steam user profile available under a 64 bit Steam community id.
 *
 * @category  Steam
 * @package   PHP_Steam_Signature
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2014 random-host.com
 * @license   http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @version   Release: @package_version@
 * @link      https://pear.random-host.com/
 */
class Profile
{
    /**
     * Error code for invalid arguments.
     *
     * @var int
     */
    const ERROR_INVALID_ARGUMENT = 400;

    /**
     * Static variable cache for object instances.
     *
     * @var array
     */
    protected static $cache = array();

    /**
     * randomhost\Steam\API instance
     *
     * @var null|API
     */
    protected $api = null;

    /**
     * Numeric Steam ID string.
     *
     * This ID is unique among all Steam users and will never change.
     *
     * @var string
     */
    protected $steamId64 = '';

    /**
     * randomhost\Steam\Data\User\General instance
     *
     * @var null|General
     */
    protected $dataUserGeneral = null;

    /**
     * randomhost\Steam\Data\User\Restricted instance
     *
     * @var null|Restricted
     */
    protected $dataUserRestricted = null;

    /**
     * Constructor for this class.
     *
     * @param API    $api randomhost\Steam\API instance.
     * @param string $id  A 64 bit Steam community ID.
     *
     * @throws \InvalidArgumentException Thrown if the Steam ID is invalid.
     */
    public function __construct(API $api, $id)
    {
        if (!is_numeric($id)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid Steam ID "%s". Use %s to resolve vanity URLs ' .
                    'into valid Steam IDs',
                    $id,
                    __CLASS__ . '::resolveVanityUrl(API $api, $vanityUrl)'
                ),
                self::ERROR_INVALID_ARGUMENT
            );
        }

        $this->steamId64 = $id;

        $this->api = $api;

        $this->readProfile();

        $this->cache();
    }

    /**
     * Resolves the vanity URL of a Steam community profile to the corresponding
     * Steam community ID.
     * 
     * @param API    $api       randomhost\Steam\API instance.
     * @param string $vanityUrl Steam community profile vanity URL.
     *
     * @return string
     * @throws \InvalidArgumentException Thrown if the vanity URL was not valid.
     * @throws \RuntimeException Thrown if the API response couldn't be parsed.
     */
    public static function resolveVanityUrl(API $api, $vanityUrl)
    {
        $caching = $api->getMemcachedUsage();
        
        $api->setMemcachedUsage(false);
        
        $result = $api->resolveVanityUrl($vanityUrl);
        
        $api->setMemcachedUsage($caching);
        
        return $result;
    }

    /**
     * Returns general user data.
     *
     * @return null|\randomhost\Steam\Data\User\General
     */
    public function getDataUserGeneral()
    {
        return $this->dataUserGeneral;
    }

    /**
     * Returns restricted user data.
     *
     * @return null|\randomhost\Steam\Data\User\Restricted
     */
    public function getDataUserRestricted()
    {
        return $this->dataUserRestricted;
    }

    /**
     * Writes the active class instance to the internal variable cache.
     *
     * @return void
     */
    protected function cache()
    {
        if (!array_key_exists($this->steamId64, self::$cache)) {
            self::$cache[$this->steamId64] = $this;
            if (!empty($this->customUrl)
                && !array_key_exists($this->customUrl, self::$cache)
            ) {
                self::$cache[$this->customUrl] = $this;
            }
        }
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

    /**
     * Fetches the API data for the active class instance and reads all data
     * into the respective class properties.
     *
     * @return void
     *
     * @throws \RuntimeException
     */
    protected function readProfile()
    {
        $data = $this->api->fetchPlayerSummary($this->steamId64);

        $this->fetchDataUserGeneral($data);
        $this->fetchDataUserRestricted($data);
    }
}
