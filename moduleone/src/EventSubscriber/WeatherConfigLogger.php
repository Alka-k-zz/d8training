<?php

namespace Drupal\moduleone\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\moduleone\Event\WeatherConfigEvent;

class WeatherConfigLogger implements EventSubscriberInterface {
	public static function getSubscribedEvents() {
		return [
				WeatherConfigEvent::WEATHER_CONFIG_UPDATE => [
						'getWeatherConfigUpdate'
				]
		];
	}
	public function getWeatherConfigUpdate(WeatherConfigEvent $event) {
		$appid = $event->getAppid ();
		drupal_set_message ( 'Weather Appid set to ' . $appid );
	}
}