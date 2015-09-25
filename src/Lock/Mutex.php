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
use DreadLabs\AppMigration\LockInterface;
use NinjaMutex\Lock\LockInterface as NinjaMutexLockInterface;

/**
 * Mutex
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
class Mutex implements LockInterface
{

    /**
     * @var \NinjaMutex\Mutex
     */
    private $mutex;

    /**
     * @param NinjaMutexLockInterface $lock
     * @param NameInterface $name
     */
    public function __construct(NinjaMutexLockInterface $lock, NameInterface $name)
    {
        $this->mutex = new \NinjaMutex\Mutex((string) $name, $lock);
    }

    /**
     * @param int $timeout Timeout in milliseconds
     *
     * @return void
     *
     * @throws LockingException If the lock is not acquirable
     */
    public function acquire($timeout)
    {
        $isAcquired = $this->mutex->acquireLock($timeout);

        if (!$isAcquired) {
            throw new LockingException('Lock cannot be acquired.', 1438871269);
        }
    }

    /**
     * @return void
     */
    public function release()
    {
        $this->mutex->releaseLock();
    }
}
