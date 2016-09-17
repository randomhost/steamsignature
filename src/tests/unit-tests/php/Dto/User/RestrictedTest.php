<?php
namespace randomhost\Steam\Dto\User;

/**
 * Unit test for Restricted
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2016 random-host.com
 * @license   http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @link      http://php-steam-signature.random-host.com
 */
class RestrictedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Restricted::setRealName() and Restricted::getRealName().
     */
    public function testSetGetRealName()
    {
        $realName = 'John Doe';

        $restricted = new Restricted();

        $this->assertSame($restricted, $restricted->setRealName($realName));
        $this->assertEquals($realName, $restricted->getRealName());
    }

    /**
     * Tests Restricted::setPrimaryGroupId() and Restricted::getPrimaryGroupId().
     */
    public function testSetGetPrimaryGroupId()
    {
        $primaryGroupId = '01234567890';

        $restricted = new Restricted();

        $this->assertSame($restricted, $restricted->setPrimaryGroupId($primaryGroupId));
        $this->assertEquals($primaryGroupId, $restricted->getPrimaryGroupId());
    }

    /**
     * Tests Restricted::setTimeCreated() and Restricted::getTimeCreated().
     */
    public function testSetTimeCreated()
    {
        $timeCreated = new \DateTime('now');
        $timeCreated->modify('-1 year');

        $restricted = new Restricted();

        $this->assertSame($restricted, $restricted->setTimeCreated($timeCreated));
        $this->assertSame($timeCreated, $restricted->getTimeCreated());
    }

    /**
     * Tests Restricted::setGameData() and Restricted::getGameData().
     */
    public function testSetGetGameData()
    {
        /**
         * @var Game $gameData Game instance.
         */
        $gameData = $this->getMockBuilder('randomhost\\Steam\\Dto\\User\\Game')
            ->getMock();

        $restricted = new Restricted();

        $this->assertSame($restricted, $restricted->setGameData($gameData));
        $this->assertSame($gameData, $restricted->getGameData());
    }

    /**
     * Tests Restricted::setLocationData() and Restricted::getLocationData().
     */
    public function testSetGetLocationData()
    {
        /**
         * @var Location $gameData Location instance.
         */
        $gameData = $this->getMockBuilder('randomhost\\Steam\\Dto\\User\\Location')
            ->getMock();

        $restricted = new Restricted();

        $this->assertSame($restricted, $restricted->setLocationData($gameData));
        $this->assertSame($gameData, $restricted->getLocationData());
    }
}
