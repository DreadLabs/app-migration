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

use DreadLabs\AppMigration\Exception\TopologyViolationException;
use DreadLabs\AppMigration\Exception\MigrationException;
use DreadLabs\AppMigration\Exception\LockingException;

/**
 * Mediator
 *
 * Mediates between a migrator,locking and logging.
 *
 * @author Thomas Juhnke <dev@van-tomas.de>
 */
class Mediator implements MediatorInterface
{

    /**
     * @var MigratorInterface
     */
    private $migrator;

    /**
     * The lock
     *
     * @var LockInterface
     */
    private $lock;

    /**
     * The logger
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Constructor
     *
     * @param MigratorInterface $migrator The migrator
     * @param LockInterface $lock The Lock
     * @param LoggerInterface $logger The logger
     */
    public function __construct(
        MigratorInterface $migrator,
        LockInterface $lock,
        LoggerInterface $logger
    ) {
        $this->migrator = $migrator;
        $this->lock = $lock;
        $this->logger = $logger;
    }

    /**
     * Negotiates the migration process
     *
     * @return void
     *
     * @throws MigrationException If something went wrong with the involved
     *                            components
     */
    public function negotiate()
    {
        // This is a workaround for PHP5.5, @see https://github.com/sebastianbergmann/phpunit-mock-objects/issues/143#issuecomment-108148498
        $catchedException = null;

        try {
            $this->lock->acquire();
            $this->executeMigrations();
        } catch (LockingException $exc) {
            $this->logger->emergency($exc->getMessage());

            $catchedException = $exc;
        } catch (TopologyViolationException $exc) {
            $this->logger->emergency('The version to migrate to is older than the current one.');

            $catchedException = $exc;
        } catch (MigrationException $exc) {
            $this->logger->emergency('Migration of version ' . $exc->getCode() . ' failed.', array($exc->getMessage()));

            $catchedException = $exc;
        }

        $this->lock->release();

        if (!is_null($catchedException)) {
            throw $catchedException;
        }
    }

    /**
     * Executes migrations
     *
     * @return void
     */
    private function executeMigrations()
    {
        if ($this->migrator->needsToRun()) {
            $latestVersion = $this->migrator->migrate();
            $this->logger->info('Migrate all migrations up to version ' . $latestVersion . '.');
        }
    }
}
