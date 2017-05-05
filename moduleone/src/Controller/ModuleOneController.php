<?php

namespace Drupal\moduleone\Controller;

use Drupal\node\NodeInterface;
use Drupal\Core\Access\AccessResult;

class ModuleOneController {
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
		$account = \Drupal::service ( 'current_user' );
		if ($node->getOwnerId () === $account->id ()) {
			return AccessResult::allowed ();
		}
		return AccessResult::forbidden ();
	}
}

