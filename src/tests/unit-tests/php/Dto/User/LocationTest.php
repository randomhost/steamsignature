<?php
namespace randomhost\Steam\Dto\User;

/**
 * Unit test for Location
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2016 random-host.com
 * @license   http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @link      http://php-steam-signature.random-host.com
 */
class LocationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests General::setCountryCode() and General::getCountryCode().
     */
    public function testSetGetCountryCode()
    {
        $countryCode = 'DE';

        $location = new Location();

        $this->assertSame($location, $location->setCountryCode($countryCode));
        $this->assertEquals($countryCode, $location->getCountryCode());
    }

    /**
     * Tests General::setStateCode() and General::getStateCode().
     */
    public function testSetGetStateCode()
    {
        $stateCode = '07';

        $location = new Location();

        $this->assertSame($location, $location->setStateCode($stateCode));
        $this->assertEquals($stateCode, $location->getStateCode());
    }

    /**
     * Tests General::setCityName() and General::getCityName().
     */
    public function testSetGetCityName()
    {
        $cityName = 'Cologne';

        $location = new Location();

        $this->assertSame($location, $location->setCityName($cityName));
        $this->assertEquals($cityName, $location->getCityName());
    }
}
