<?php

/*
 * This file is part of the AppMigration package.
 *
 * (c) Thomas Juhnke <dev@van-tomas.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DreadLabs\AppMigration\Exception;

/**
 * TopologyViolationException
 *
 * Must be thrown if an unprocessed migration is younger than
 * the latest processed migration.
 *
 * @author Thomas Juhnke <dev@van-tomas.de>
 */
class TopologyViolationException extends MigrationException
{
}
