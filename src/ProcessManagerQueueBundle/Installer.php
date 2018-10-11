<?php
/**
 */

namespace ProcessManagerQueueBundle;

use Doctrine\DBAL\Migrations\Version;
use Doctrine\DBAL\Schema\Schema;
use Pimcore\Extension\Bundle\Installer\MigrationInstaller;
use Pimcore\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

use ProcessManagerQueueBundle\Model\Job;

class Installer extends MigrationInstaller
{
    /**
     * {@inheritdoc}
     */
    public function migrateInstall(Schema $schema, Version $version)
    {
        $processTable = $schema->createTable('process_manager_queue_jobs');
        $processTable->addColumn('id', 'integer')
            ->setAutoincrement(true)
        ;
        $processTable->addColumn('name', 'string');
        $processTable->addColumn('executableId', 'integer');
        $processTable->addColumn('scheduledDate', 'integer')
            ->setUnsigned(1)
        ;
        $processTable->addColumn('blocking', 'integer')
            ->setLength(1)
            ->setDefault(0)
            ->setUnsigned(1)
        ;
        $processTable->addColumn('settings', 'text');
        $processTable->addColumn('status', 'integer')
            ->setDefault(Job::STATUS_SCHEDULED)
            ->setUnsigned(1)
        ;
        $processTable->setPrimaryKey(['id']);
        $processTable->addForeignKeyConstraint('process_manager_executables', ['executableId'], ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function migrateUninstall(Schema $schema, Version $version)
    {
        $tables = [
            'process_manager_queue_jobs'
        ];

        foreach ($tables as $table) {
            if ($schema->hasTable($table)) {
                $schema->dropTable($table);
            }
        }
    }
}
