<?php

namespace Drupal\moduleone\Access;

use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountProxy;
use Drupal\node\NodeInterface;
use Drupal\Core\Access\AccessResult;

class NodeCreatorCheck implements AccessInterface {
	public function __construct(AccountProxy $account) {
		$this->account = $account;
	}
	public function access(NodeInterface $node) {
		kint ( $this->account );
		if ($node->getOwnerId () === $this->account->id ()) {
			return AccessResult::allowed ();
		} else {
			return AccessResult::forbidden ();
		}
	}
}
