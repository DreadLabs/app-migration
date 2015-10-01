# AppMigration

Provides an opinionated, ready-to-use way to integrate runtime migration into your 
PHP application.

## Status

[![Build Status](https://travis-ci.org/DreadLabs/app-migration.svg?branch=master)](https://travis-ci.org/DreadLabs/app-migration)
[![Coverage Status](https://coveralls.io/repos/DreadLabs/app-migration/badge.svg?branch=master&service=github)](https://coveralls.io/github/DreadLabs/app-migration?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/312ef624-c317-41c7-859d-bdd270c8b3b4/big.png)](https://insight.sensiolabs.com/projects/312ef624-c317-41c7-859d-bdd270c8b3b4)
[![Code Climate](https://codeclimate.com/github/DreadLabs/app-migration/badges/gpa.svg)](https://codeclimate.com/github/DreadLabs/app-migration)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/DreadLabs/app-migration/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/DreadLabs/app-migration/?branch=master)

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
-  dreadlabs/app-migration-typo3 - An integration into TYPO3.CMS

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

## License

MIT, © 2015 Thomas Juhnke
