<?php

/*
 * This file is part of the AppMigration package.
 *
 * (c) Thomas Juhnke <dev@van-tomas.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DreadLabs\AppMigration\Tests\Unit\Lock\NinjaMutexTimeout;

use DreadLabs\AppMigration\Exception\LockingException;
use DreadLabs\AppMigration\Lock\NinjaMutex\Timeout\Waiting;

/**
 * WaitingTest
 *
 * @author Thomas Juhnke <dev@van-tomas.de>
 */
class WaitingTest extends \PHPUnit_Framework_TestCase
{

    public function testItThrowsAnExceptionIfConstructionArgumentIsNotGreaterThanZero()
    {
        $this->setExpectedException(LockingException::class);

        new Waiting(0);
    }

    public function testItThrowsAnExceptionIfConstructionArgumentIsAString()
    {
        $this->setExpectedException(LockingException::class);

        new Waiting('foo');
    }

    public function testItThrowsAnExceptionIfConstructionArgumentIsAnArray()
    {
        $this->setExpectedException(LockingException::class);

        new Waiting(array());
    }

    public function testItThrowsAnExceptionIfConstructionArgumentIsAFloatValueBetweenZeroAndOne()
    {
        $this->setExpectedException(LockingException::class);

        new Waiting(0.5);
    }

    public function testItReturnsTheSameIntegerValueAsGivenOnConstruction()
    {
        $waitingTimeout = new Waiting(2);

        $this->assertSame(2, $waitingTimeout->getValue());
    }

    public function testItReturnsTheFloatValueRoundedToInteger()
    {
        $waitingTimeout = new Waiting(3.14);

        $this->assertSame(3, $waitingTimeout->getValue());
    }
}
