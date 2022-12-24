<?php

declare(strict_types=1);

namespace randomhost\Steam\Tests\Dto\User;

use PHPUnit\Framework\TestCase;
use randomhost\Steam\Dto\User\Location;

/**
 * Unit test for {@see Location}.
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2022 Random-Host.tv
 * @license   https://opensource.org/licenses/BSD-3-Clause  BSD License (3 Clause)
 *
 * @see https://github.random-host.tv
 */
class LocationTest extends TestCase
{
    /**
     * Tests {@see General::setCountryCode()} and {@see General::getCountryCode()}.
     */
    public function testSetGetCountryCode()
    {
        $countryCode = 'DE';

        $location = new Location();

        $this->assertSame($location, $location->setCountryCode($countryCode));
        $this->assertSame($countryCode, $location->getCountryCode());
    }

    /**
     * Tests {@see General::setStateCode()} and {@see General::getStateCode()}.
     */
    public function testSetGetStateCode()
    {
        $stateCode = '07';

        $location = new Location();

        $this->assertSame($location, $location->setStateCode($stateCode));
        $this->assertSame($stateCode, $location->getStateCode());
    }

    /**
     * Tests {@see General::setCityName()} and {@see General::getCityName()}.
     */
    public function testSetGetCityId()
    {
        $cityId = 12728;

        $location = new Location();

        $this->assertSame($location, $location->setCityId($cityId));
        $this->assertSame($cityId, $location->getCityId());
    }
}
