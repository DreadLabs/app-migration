<?php

/*
 * This file is part of the AppMigration package.
 *
 * (c) Thomas Juhnke <dev@van-tomas.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DreadLabs\AppMigration\Lock\NinjaMutex\Timeout;

use DreadLabs\AppMigration\Exception\LockingException;
use DreadLabs\AppMigration\Lock\NinjaMutex\TimeoutInterface;

/**
 * Waiting
 *
 * Enables a waiting period (in milliseconds) for the selected
 * lock implementation.
 *
 * @author Thomas Juhnke <dev@van-tomas.de>
 */
class Waiting implements TimeoutInterface
{

    /**
     * Waiting time for the lock
     *
     * @var int
     */
    private $timeout;

    /**
     * Constructor
     *
     * @param int $timeout
     *
     * @throws LockingException If timeout is not greater than 0
     */
    public function __construct($timeout)
    {
        if (!((int) $timeout > 0)) {
            throw new LockingException('Please specify a timeout > 0.', 1443364847);
        }

        $this->timeout = (int) $timeout;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->timeout;
    }
}
