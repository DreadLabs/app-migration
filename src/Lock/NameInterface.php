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

/**
 * NameInterface
 *
 * Some lock implementations needs a name. This class
 * provides a wrapper around scalar types for applications
 * which does not support inject scalar arguments in
 * their DICs.
 *
 * @author Thomas Juhnke <dev@van-tomas.de>
 */
interface NameInterface
{

    /**
     * @return string
     */
    public function __toString();
}
