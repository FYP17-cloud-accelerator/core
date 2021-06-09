<?php

namespace OC\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use OCP\Migration\ISchemaMigration;

/**
 * migrate stable9 to stable10
 */
class Version20170101215145 implements ISchemaMigration {
	public function changeSchema(Schema $schema, array $options) {
		$prefix = $options['tablePrefix'];

		if (!$schema->hasTable("${prefix}authtoken")) {
			$authTokenTable = $schema->createTable("${prefix}authtoken");

			$authTokenTable->addColumn(
				'id',
				Types::INTEGER,
				[
					'notnull' => true,
					'autoincrement' => 1,
					'unsigned' => true
				]
			);

			$authTokenTable->addColumn(
				'uid',
				Types::STRING,
				[
					'length' => 64,
					'default' => '',
					'notnull' => true
				]
			);

			$authTokenTable->addColumn(
				'login_name',
				Types::STRING,
				[
					'length' => 64,
					'default' => '',
					'notnull' => true
				]
			);

			$authTokenTable->addColumn(
				'name',
				Types::TEXT,
				[
					'default' => '',
					'notnull' => true
				]
			);

			$authTokenTable->addColumn(
				'token',
				Types::STRING,
				[
					'length' => 200,
					'default' => '',
					'notnull' => true
				]
			);

			$authTokenTable->addColumn(
				'type',
				Types::SMALLINT,
				[
					'unsigned' => true,
					'default' => 0,
					'notnull' => true
				]
			);

			$authTokenTable->addColumn(
				'last_activity',
				Types::INTEGER,
				[
					'unsigned' => true,
					'default' => 0,
					'notnull' => true
				]
			);

			$authTokenTable->addColumn(
				'last_check',
				Types::INTEGER,
				[
					'unsigned' => true,
					'default' => 0,
					'notnull' => true
				]
			);

			$authTokenTable->addColumn(
				'password',
				Types::TEXT,
				[
					'default' => null,
					'notnull' => false
				]
			);

			$authTokenTable->setPrimaryKey(['id']);

			$authTokenTable->addIndex(['last_activity'], 'authtoken_last_activity_index');

			$authTokenTable->addUniqueIndex(['token'], 'authtoken_token_index');
		}

		if (!$schema->hasTable("${prefix}systemtag_group")) {
			$systemTagGroupTable = $schema->createTable("${prefix}systemtag_group");

			$systemTagGroupTable->addColumn(
				'gid',
				Types::STRING,
				[
					'length' => 255,
					'notnull' => true
				]
			);

			$systemTagGroupTable->addColumn(
				'systemtagid',
				Types::INTEGER,
				[
					'unsigned' => true,
					'default' => 0,
					'notnull' => true
				]
			);

			$systemTagGroupTable->setPrimaryKey(['gid', 'systemtagid']);
		}

		if ($schema->hasTable("${prefix}jobs")) {
			$jobsTable = $schema->getTable("${prefix}jobs");

			if (!$jobsTable->hasColumn('last_checked')) {
				$jobsTable->addColumn(
					'last_checked',
					Types::INTEGER,
					[
						'default' => 0,
						'notnull' => false
					]
				);
			}

			if (!$jobsTable->hasColumn('reserved_at')) {
				$jobsTable->addColumn(
					'reserved_at',
					Types::INTEGER,
					[
						'default' => 0,
						'notnull' => false
					]
				);
			}
		}

		if ($schema->hasTable("${prefix}calendarobjects")) {
			$calendarObjectsTable = $schema->getTable("${prefix}calendarobjects");

			if (!$calendarObjectsTable->hasColumn('classification')) {
				$calendarObjectsTable->addColumn(
					'classification',
					Types::INTEGER,
					[
						'default' => 0,
						'notnull' => false
					]
				);
			}

			if ($calendarObjectsTable->hasColumn('componenttype')) {
				$componentType = $calendarObjectsTable->getColumn('componenttype');
				// TODO: check what happens when this contained data with length > 8
				$componentType->setOptions(['length' => 8]);
			}

			if ($calendarObjectsTable->hasColumn('firstoccurence')) {
				$firstOccurence = $calendarObjectsTable->getColumn('firstoccurence');
				$firstOccurence->setType(Type::getType(Types::BIGINT));
			}

			if ($calendarObjectsTable->hasColumn('lastoccurence')) {
				$lastOccurence = $calendarObjectsTable->getColumn('lastoccurence');
				$lastOccurence->setType(Type::getType(Types::BIGINT));
			}
		}

		if ($schema->hasTable("${prefix}calendars")) {
			$calendarsTable = $schema->getTable("${prefix}calendars");

			if ($calendarsTable->hasColumn('components')) {
				$components = $calendarsTable->getColumn('components');
				$components->setOptions(['length' => 20]);
			}
		}

		if ($schema->hasTable("${prefix}calendarsubscriptions")) {
			$calendarSubscriptionsTable = $schema->getTable("${prefix}calendarsubscriptions");

			if ($calendarSubscriptionsTable->hasColumn('lastmodified')) {
				$lastModified = $calendarSubscriptionsTable->getColumn('lastmodified');
				$lastModified->setOptions(
					[
						'notnull' => true
					]
				);
			}
		}
	}
}
