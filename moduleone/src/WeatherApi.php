<?php

namespace Drupal\moduleone;

use GuzzleHttp\Client;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Component\Serialization\Json;

class WeatherApi {
	public function __construct(Client $client, ConfigFactory $config) {
		$this->client = $client;
		$this->config = $config;
	}
	public function getWeather($cityName) {
		$uri = 'http://api.openweathermap.org/data/2.5/weather';
		$appid = $this->config->get ( 'moduleone.weather_config' )->get ( 'appid' );
		$options = array (
				'query' => array (
						'q' => $cityName,
						'APPID' => $appid
				)
		);
		$response = $this->client->get ( $uri, $options );
		// Convert Json to array.
		return Json::decode ( $response->getBody ()->getContents () );
	}
}