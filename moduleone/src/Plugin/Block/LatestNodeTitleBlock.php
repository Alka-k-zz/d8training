<?php

namespace Drupal\moduleone\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\Session\AccountProxy;

/**
 * Provides a 'LatestNodeTitleBlock' block.
 *
 * @Block(
 * id = "latest_node_title_block",
 * admin_label = @Translation("Latest node title block"),
 * )
 */
class LatestNodeTitleBlock extends BlockBase implements ContainerFactoryPluginInterface {

	/**
	 * Drupal\Core\Database\Driver\mysql\Connection definition.
	 *
	 * @var \Drupal\Core\Database\Driver\mysql\Connection
	 */
	protected $database;
	/**
	 * Construct.
	 *
	 * @param array $configuration
	 *        	A configuration array containing information about the plugin instance.
	 * @param string $plugin_id
	 *        	The plugin_id for the plugin instance.
	 * @param string $plugin_definition
	 *        	The plugin implementation definition.
	 */
	public function __construct(array $configuration, $plugin_id, $plugin_definition, Connection $database, AccountProxy $account) {
		parent::__construct ( $configuration, $plugin_id, $plugin_definition );
		$this->database = $database;
		$this->account = $account;
	}
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
		return new static ( $configuration, $plugin_id, $plugin_definition, $container->get ( 'database' ), $container->get ( 'current_user' ) );
	}
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function build() {
		$build = [ ];
		$node_title = $this->getNodeTitle ();
		$email = $this->account->getEmail ();
		$build ['latest_node_title_block'] = [
				'#markup' => implode ( '|', $node_title ['title'] ) . ' : ' . $email,
				'#cache' => [
						'tags' => $node_title ['nid'],
						'contexts' => [
								'user'
						]
				]
		];
		return $build;
	}
	public function getNodeTitle() {
		$q = $this->database->select ( 'node_field_data', 'nd' )->fields ( 'nd', [
				'nid',
				'title'
		] )->orderBy ( 'nd . created' )->range ( 0, 3 );
		$result = $q->execute ();

		while ( $row = $result->fetchAssoc () ) {
			$nodes ['title'] [] = $row ['title'];
			$nodes ['nid'] [] = 'node:' . $row ['nid'];
		}

		return $nodes;
	}
}
