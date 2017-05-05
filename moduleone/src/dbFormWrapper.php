<?php

namespace Drupal\moduleone;

use Drupal\Core\Database\Connection;

class dbFormWrapper {

	/**
	 * DbWrapper constructor.
	 *
	 * @param \Drupal\Core\Database\Driver\mysql\Connection $connection
	 */
	public function __construct(Connection $connection) {
		$this->connection = $connection;
	}
	public function getData() {
		$result = $this->connection->select ( 'data_form', 'df' )->fields ( 'df', array (
				'first_name',
				'last_name'
		) )->execute ();
		return $result->fetchAssoc ();
	}
	public function setData($first_name, $last_name) {
		$this->connection->insert ( 'data_form' )->fields ( [
				'first_name',
				'last_name'
		], [
				$first_name,
				$last_name
		] )->execute ();
	}
}