<?php
namespace randomhost\Steam\Dto\User;

/**
 * Unit test for Profile
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2016 random-host.com
 * @license   http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @link      http://php-steam-signature.random-host.com
 */
class ProfileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Restricted::getDataUserGeneral().
     */
    public function testGetDataUserGeneral()
    {
        $profile = new Profile($this->getData());

        $this->assertInstanceOf(
            'randomhost\\Steam\\Dto\\User\\General',
            $profile->getDataUserGeneral()
        );
    }

    /**
     * Tests Restricted::getDataUserRestricted().
     */
    public function testGetDataUserRestricted()
    {
        $profile = new Profile($this->getData());

        $this->assertInstanceOf(
            'randomhost\\Steam\\Dto\\User\\Restricted',
            $profile->getDataUserRestricted()
        );
    }

    /**
     * @return \stdClass
     */
    protected function getData()
    {
        return json_decode(
            file_get_contents(APP_DATADIR . '/testProfileData.json')
        );
    }
}
