<?php
namespace randomhost\Steam\Dto\User;

/**
 * Represents private Steam user location data
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2016 random-host.com
 * @license   http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @link      http://php-steam-signature.random-host.com
 */
class Location
{
    /**
     * User's country of residence (ISO country code).
     *
     * @var string
     */
    protected $countryCode = '';

    /**
     * User's state of residence.
     *
     * @var string
     */
    protected $stateCode = '';

    /**
     * User's city of residence.
     *
     * @var int
     */
    protected $cityName = '';

    /**
     * Sets the user's country of residence (ISO country code).
     *
     * @param string $countryCode User's country of residence (ISO country code).
     *
     * @return $this
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Returns the user's country of residence (ISO country code).
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Sets the user's state of residence.
     *
     * @param string $stateCode User's state of residence.
     *
     * @return $this
     */
    public function setStateCode($stateCode)
    {
        $this->stateCode = $stateCode;

        return $this;
    }

    /**
     * Returns the user's state of residence.
     *
     * @return string
     */
    public function getStateCode()
    {
        return $this->stateCode;
    }

    /**
     * Sets the user's city of residence.
     *
     * @param int $cityName User's city of residence.
     *
     * @return $this
     */
    public function setCityName($cityName)
    {
        $this->cityName = $cityName;

        return $this;
    }

    /**
     * Returns the user's city of residence.
     *
     * @return int
     */
    public function getCityName()
    {
        return $this->cityName;
    }
}
