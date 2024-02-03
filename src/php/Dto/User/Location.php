<?php

declare(strict_types=1);

namespace randomhost\Steam\Dto\User;

/**
 * Represents private Steam user location data.
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2024 Random-Host.tv
 * @license   https://opensource.org/licenses/BSD-3-Clause  BSD License (3 Clause)
 *
 * @see https://github.random-host.tv
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
    protected $cityId = 0;

    /**
     * Sets the user's country of residence (ISO country code).
     *
     * @param string $countryCode User's country of residence (ISO country code).
     */
    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Returns the user's country of residence (ISO country code).
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * Sets the user's state of residence.
     *
     * @param string $stateCode User's state of residence.
     */
    public function setStateCode(string $stateCode): self
    {
        $this->stateCode = $stateCode;

        return $this;
    }

    /**
     * Returns the user's state of residence.
     */
    public function getStateCode(): string
    {
        return $this->stateCode;
    }

    /**
     * Sets the user's city of residence.
     *
     * @param int $cityId User's city of residence.
     */
    public function setCityId(int $cityId): self
    {
        $this->cityId = $cityId;

        return $this;
    }

    /**
     * Returns the user's city of residence.
     */
    public function getCityId(): int
    {
        return $this->cityId;
    }
}
