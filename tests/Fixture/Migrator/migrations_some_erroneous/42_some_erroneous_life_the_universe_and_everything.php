<?php

use Phinx\Migration\AbstractMigration;

class SomeErroneousLifeTheUniverseAndEverything extends AbstractMigration
{

    /**
     * Does nothing
     *
     * @return void
     */
    public function up()
    {
        throw new \PDOException('Life, the universe and everything.');
    }
}
