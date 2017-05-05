<?php

namespace Drupal\moduleone\Controller;

use Drupal\node\NodeInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountProxy;

class ModuleOneController implements ContainerInjectionInterface {
	public function __construct(AccountProxy $account) {
		$this->account = $account;
	}
	public function staticContent() {
		return [
				'#markup' => "Hello! I am you node listing page."
		];
	}
	public function dynamicContent($arg) {
		return [
				'#markup' => "Value passed = " . $arg
		];
	}
	public function entityUpcaster(NodeInterface $node) {
		return [
				'#theme' => 'item_list',
				'#items' => [
						$node->getTitle (),
						$node->get ( 'body' )->getValue ()
				]
		];
	}
	public function nodeCreatorCheck(NodeInterface $node) {
		if ($node->getOwnerId () === $this->account->id ()) {
			return AccessResult::allowed ();
		}
		return AccessResult::forbidden ();
	}
	public static function create(ContainerInterface $container) {
		return new static ( $container->get ( 'current_user' ) );
	}
}

