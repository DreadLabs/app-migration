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

use DreadLabs\AppMigration\Exception\InvalidDirectionException;
use DreadLabs\AppMigration\Exception\MigrationException;

/**
 * MigratorInterface
 *
 * @author Thomas Juhnke <dev@van-tomas.de>
 */
interface MigratorInterface
{

   /**
    * Flags if migrations need to be executed
    *
    * @return bool
    */
    public function needsToRun();

    /**
     * Executes migrations
     *
     * @return int Version of the latest migration executed
     *
     * @throws InvalidDirectionException If the current migration version is
     *                                   older than the migration version
     *                                   to migrate to
     * @throws MigrationException If a migration cannot be executed due of
     *                            errors (syntax, ...)
     */
    public function migrate();
}
