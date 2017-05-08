<?php

namespace Drupal\moduleone\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class AccessHeaderInjector implements EventSubscriberInterface {
	public static function getSubscribedEvents() {
		return [
				KernelEvents::RESPONSE => [
						'addAccessHeader'
				]
		];
	}
	public function addAccessHeader(FilterResponseEvent $event) {
		$response = $event->getResponse ();
		$response->headers->add ( [
				'access-control-allow-origin' => '*'
		] );
	}
}

