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

use DreadLabs\AppMigration\Exception\MigrationException;

/**
 * MediatorInterface
 *
 * @author Thomas Juhnke <dev@van-tomas.de>
 */
interface MediatorInterface
{

    /**
     * Negotiates the migration process
     *
     * @return void
     *
     * @throws MigrationException If something went wrong with the involved
     *                            components
     */
    public function negotiate();
}
