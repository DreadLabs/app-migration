<?php

/*
 * This file is part of the AppMigration package.
 *
 * (c) Thomas Juhnke <dev@van-tomas.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DreadLabs\AppMigration\Lock\NinjaMutex;

/**
 * TimeoutInterface
 *
 * Encapsulates the NinjaMutex lock acquiration argument and allows
 * setting via DIC or during runtime.
 *
 * @author Thomas Juhnke <dev@van-tomas.de>
 */
interface TimeoutInterface
{

    /**
     * Value of the timeout implementation
     *
     * 1. null if you want blocking lock
     * 2. 0 if you want just lock and go
     * 3. $timeout > 0 if you want to wait for lock some time (in milliseconds)
     *
     * @return null|int
     */
    public function getValue();
}
