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

use DreadLabs\AppMigration\Lock\NinjaMutex\Timeout\Blocking;

/**
 * BlockingTest
 *
 * @author Thomas Juhnke <dev@van-tomas.de>
 */
class BlockingTest extends \PHPUnit_Framework_TestCase
{

    public function testItReturnsNull()
    {
        $blockingTimeout = new Blocking();
        $this->assertNull($blockingTimeout->getValue());
    }
}
