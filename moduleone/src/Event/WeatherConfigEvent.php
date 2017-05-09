<?php

namespace Drupal\moduleone\Event;

use Symfony\Component\EventDispatcher\Event;

class WeatherConfigEvent extends Event {
	const WEATHER_CONFIG_UPDATE = 'weather.config.update';
	private $appid;
	public function __construct($appid) {
		$this->appid = $appid;
	}
	public function getAppid() {
		return $this->appid;
	}
}

