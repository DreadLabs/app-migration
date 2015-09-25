<?php

/*
 * This file is part of the AppMigration package.
 *
 * (c) Thomas Juhnke <dev@van-tomas.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DreadLabs\AppMigration\Tests\Unit\Mediator;

use DreadLabs\AppMigration\Exception\InvalidDirectionException;
use DreadLabs\AppMigration\Exception\LockingException;
use DreadLabs\AppMigration\Exception\MigrationException;
use DreadLabs\AppMigration\LockInterface;
use DreadLabs\AppMigration\LoggerInterface;
use DreadLabs\AppMigration\Mediator\PhinxLocking;
use DreadLabs\AppMigration\MigratorInterface;

/**
 * PhinxLockingTest
 *
 * @author Thomas Juhnke <dev@van-tomas.de>
 */
class PhinxLockingTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var MigratorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $migrator;

    /**
     * @var LockInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $mutex;

    /**
     * @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $logger;

    public function setUp()
    {
        $this->migrator = $this->getMock(MigratorInterface::class);
        $this->mutex = $this->getMock(LockInterface::class);
        $this->logger = $this->getMock(LoggerInterface::class);
    }

    public function testItLogsEmergencyIfMutexIsLocked()
    {
        $this->setExpectedException(LockingException::class);

        $this->mutex->expects($this->once())->method('acquireLock')->willThrowException(new LockingException());
        $this->mutex->expects($this->once())->method('releaseLock')->willReturn(true);

        $this->logger->expects($this->once())->method('emergency');

        $mediator = new PhinxLocking($this->migrator, $this->mutex, $this->logger);
        $mediator->negotiate();
    }

    public function testItLogsEmergencyIfInvalidMigrationDirectionIsDetermined()
    {
        $this->setExpectedException(InvalidDirectionException::class);

        $this->migrator->expects($this->once())->method('needsToRun')->willReturn(true);
        $this->migrator->expects($this->once())->method('migrate')->willThrowException(new InvalidDirectionException());

        $this->mutex->expects($this->once())->method('acquireLock')->willReturn(true);
        $this->mutex->expects($this->once())->method('releaseLock')->willReturn(true);

        $this->logger->expects($this->once())->method('emergency');

        $mediator = new PhinxLocking($this->migrator, $this->mutex, $this->logger);
        $mediator->negotiate();
    }

    public function testItLogsEmergencyIfAMigrationExceptionOccurs()
    {
        $this->setExpectedException(MigrationException::class);

        $this->migrator->expects($this->once())->method('needsToRun')->willReturn(true);
        $this->migrator->expects($this->once())->method('migrate')->willThrowException(new MigrationException());

        $this->mutex->expects($this->once())->method('acquireLock')->willReturn(true);
        $this->mutex->expects($this->once())->method('releaseLock')->willReturn(true);

        $this->logger->expects($this->once())->method('emergency');

        $mediator = new PhinxLocking($this->migrator, $this->mutex, $this->logger);
        $mediator->negotiate();
    }

    public function testItLogsInfoIfAllMigrationsWereSuccessfullyExecuted()
    {
        $this->migrator->expects($this->once())->method('needsToRun')->willReturn(true);
        $this->migrator->expects($this->once())->method('migrate')->willReturn(42);

        $this->mutex->expects($this->once())->method('acquireLock')->willReturn(true);
        $this->mutex->expects($this->once())->method('releaseLock')->willReturn(true);

        $this->logger->expects($this->once())->method('info')->with($this->stringContains('42'));

        $mediator = new PhinxLocking($this->migrator, $this->mutex, $this->logger);
        $mediator->negotiate();
    }
}
