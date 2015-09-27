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

use DreadLabs\AppMigration\Lock\NinjaMutex\TimeoutInterface;

/**
 * Immediate
 *
 * Immediately applies the selected lock implementation.
 *
 * @author Thomas Juhnke <dev@van-tomas.de>
 */
class Immediate implements TimeoutInterface
{

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return 0;
    }
}
