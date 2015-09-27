<?php

/*
 * This file is part of the AppMigration package.
 *
 * (c) Thomas Juhnke <dev@van-tomas.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DreadLabs\AppMigration\Lock;

use DreadLabs\AppMigration\Exception\LockingException;
use DreadLabs\AppMigration\Lock\NinjaMutex\TimeoutInterface;
use DreadLabs\AppMigration\LockInterface;
use NinjaMutex\Lock\LockInterface as NinjaMutexLockInterface;
use NinjaMutex\Mutex;

/**
 * NinjaMutex
 *
 * Thin wrapper around the NinjaMutex\Mutex to allow usage
 * within frameworks without proper DIC.
 *
 * Basically, this swaps the constructor arguments to play
 * nicely with frameworks which doesn't allow scalar value
 * injection into services.
 *
 * @author Thomas Juhnke <dev@van-tomas.de>
 */
class NinjaMutex implements LockInterface
{

    /**
     * @var Mutex
     */
    private $lock;

    /**
     * @var TimeoutInterface
     */
    private $timeout;

    /**
     * Constructor
     *
     * @param NinjaMutexLockInterface $backend
     * @param NameInterface $name
     * @param TimeoutInterface $timeout
     */
    public function __construct(NinjaMutexLockInterface $backend, NameInterface $name, TimeoutInterface $timeout)
    {
        $this->lock = new Mutex((string) $name, $backend);
        $this->timeout = $timeout;
    }

    /**
     * @return void
     *
     * @throws LockingException If the lock is not acquirable
     */
    public function acquire()
    {
        $isAcquired = $this->lock->acquireLock($this->timeout->getValue());

        if (!$isAcquired) {
            throw new LockingException('Lock cannot be acquired.', 1438871269);
        }
    }

    /**
     * @return void
     */
    public function release()
    {
        $this->lock->releaseLock();
    }
}
