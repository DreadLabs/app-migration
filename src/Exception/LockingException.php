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
 * LockingException
 *
 * Is thrown if the locking mechanism during migration is violated,
 * e.g. if two concurrent requests try to lock for migration, but another
 * one is already running.
 *
 * @author Thomas Juhnke <dev@van-tomas.de>
 */
class LockingException extends MigrationException
{
}
