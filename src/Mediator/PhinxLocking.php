<?php

/*
 * This file is part of the AppMigration package.
 *
 * (c) Thomas Juhnke <dev@van-tomas.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DreadLabs\AppMigration\Mediator;

use DreadLabs\AppMigration\Exception\TopologyViolationException;
use DreadLabs\AppMigration\Exception\MigrationException;
use DreadLabs\AppMigration\Exception\LockingException;
use DreadLabs\AppMigration\LockInterface;
use DreadLabs\AppMigration\LoggerInterface;
use DreadLabs\AppMigration\MediatorInterface;
use DreadLabs\AppMigration\MigratorInterface;

/**
 * PhinxLocking
 *
 * Mediates the phinx migrator and a mutex lock to allow an application to
 * switch to maintenance mode if something went wrong.
 *
 * @author Thomas Juhnke <dev@van-tomas.de>
 */
class PhinxLocking implements MediatorInterface
{

    /**
     * @var MigratorInterface
     */
    private $migrator;

    /**
     * The mutex
     *
     * @var LockInterface
     */
    private $mutex;

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
     * @param LockInterface $mutex The Mutex
     * @param LoggerInterface $logger The logger
     */
    public function __construct(
        MigratorInterface $migrator,
        LockInterface $mutex,
        LoggerInterface $logger
    ) {
        $this->migrator = $migrator;
        $this->mutex = $mutex;
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
            $this->mutex->acquire(1000);
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

        $this->mutex->release();

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
