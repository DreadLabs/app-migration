# AppMigration

Provides an opinionated, ready-to-use way to integrate runtime migration into your 
PHP application.

## Installation

    ~ $ php composer.phar require dreadlabs/app-migration:~0.1.0

## Components

### Interfaces

-  LockInterface - Adapter interface to locking library
-  LoggerInterface - An slimmed down version of the PSR-3 logger interface
-  MediatorInterface - This is the glue between lock, logger and migrator
-  MigratorInterface -Adapter interface to migration library

### Exceptions

-  LockingException - If anything goes wrong during locking
-  MigrationException - If a migration can't be executed. Exception code is the version 
   number of the migration which produced the exception.
-  TopologyViolationException - If one or more unprocessed migrations are younger than 
   the latest processed migration.
   
## Companion packages

-  dreadlabs/app-migration-lock-ninjamutex - A lock adapter for `arvenil/ninja-mutex`
-  dreadlabs/app-migration-migrator-phinx - A migrator adapter for `robmorgan/phinx`
-  dreadlabs/app-migration-app-typo3 - An integration into TYPO3.CMS

## Opinionated - why?

### Topological assumption

I believe, there should be only one direction during migration: "up". This belief comes
from looking to migrations like they are ordered on a time axis. You can't go back in 
time - can you? - and therefore no way to migrate "down".

If you have the need to migrate down (e.g. during testing), just create another 
migration which rolls back the last one. Then decide which migrations to drop and which 
can go  into CVS.

### Logging

Logging is essential during migration. If something went wrong, you need to know as 
soon as possible what is the problem. Logging is a first class citizen in the mediator. 
If you don't need logging, just pass in a NullLogger and you're good to go. 
