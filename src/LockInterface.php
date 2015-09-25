<?php

/*
 * This file is part of the AppMigration package.
 *
 * (c) Thomas Juhnke <dev@van-tomas.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DreadLabs\AppMigration;

use DreadLabs\AppMigration\Exception\LockingException;

/**
 * LockInterface
 *
 * @author Thomas Juhnke <dev@van-tomas.de>
 */
interface LockInterface
{

    /**
     * Acquires a lock
     *
     * @param int $timeout
     *
     * @return bool
     *
     * @throws LockingException If the lock is not acquirable
     */
    public function acquireLock($timeout);

    /**
     * Releases a lock
     *
     * @return bool
     */
    public function releaseLock();
}
