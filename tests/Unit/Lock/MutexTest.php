<?php

/*
 * This file is part of the AppMigration package.
 *
 * (c) Thomas Juhnke <dev@van-tomas.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DreadLabs\AppMigration\Tests\Unit\Lock;

use DreadLabs\AppMigration\Exception\LockingException;
use DreadLabs\AppMigration\Lock\Mutex;
use NinjaMutex\Lock\LockInterface;

/**
 * MutexTest
 *
 * @author Thomas Juhnke <dev@van-tomas.de>
 */
class MutexTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var LockInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $lock;

    public function setUp()
    {
        $this->lock = $this->getMock(LockInterface::class, array('acquireLock', 'releaseLock', 'isLocked'));
    }

    public function testItThrowsALockingExceptionIfLockCantBeAcquired()
    {
        $this->setExpectedException(LockingException::class);

        $this->lock->expects($this->once())->method('acquireLock')->with('typo3-cms-migration', 42)->willReturn(false);
        $this->lock->expects($this->never())->method('releaseLock');

        $mutex = new Mutex($this->lock);
        $mutex->acquire(42);
    }

    public function testItAcquiresLockingOnTheLock()
    {
        $this->lock->expects($this->once())->method('acquireLock')->with('typo3-cms-migration', 42)->willReturn(true);
        $this->lock->expects($this->once())->method('releaseLock')->willReturn(true);

        $mutex = new Mutex($this->lock);
        $mutex->acquire(42);
    }

    public function testItReleasesLockingOnTheLock()
    {
        $this->lock->expects($this->once())->method('acquireLock')->with('typo3-cms-migration', 23)->willReturn(true);
        $this->lock->expects($this->once())->method('releaseLock')->with('typo3-cms-migration')->willReturn(true);

        $mutex = new Mutex($this->lock);
        $mutex->acquire(23);
        $mutex->release();
    }
}
