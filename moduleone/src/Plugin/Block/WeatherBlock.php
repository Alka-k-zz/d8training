<?php

namespace Drupal\moduleone\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\moduleone\WeatherApi;

/**
 * @Block(
 * id="weather_block",
 * admin_label="Weather Block"
 * )
 */
class WeatherBlock extends BlockBase implements ContainerFactoryPluginInterface {

	// Keep defination same as base plugin class if it is not required to do something different.
	public function __construct($configuration, $plugin_id, $plugin_definition, WeatherApi $weather) {
		parent::__construct ( $configuration, $plugin_id, $plugin_definition );
		$this->weatherapi = $weather;
	}
	/**
	 * Builds and returns the renderable array for this block plugin.
	 *
	 * If a block should not be rendered because it has no content, then this
	 * method must also ensure to return no content: it must then only return an
	 * empty array, or an empty array with #cache set (with cacheability metadata
	 * indicating the circumstances for it being empty).
	 *
	 * @return array A renderable array representing the content of the block.
	 *
	 * @see \Drupal\block\BlockViewBuilder
	 */
	public function build() {
		$weather_data = $this->weatherapi->getWeather ( $this->configuration ['city_name'] );
		return [
				'#theme' => 'weather_widget',
				'#weather_data' => $weather_data,
				'#attached' => [
						'library' => 'moduleone/weather-widget'
				]
		];
	}

	/**
	 * Returns the configuration form elements specific to this block plugin.
	 *
	 * Blocks that need to add form elements to the normal block configuration
	 * form should implement this method.
	 *
	 * @param array $form
	 *        	The form definition array for the block configuration form.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *        	The current state of the form.
	 *
	 * @return array $form
	 *         The renderable form array representing the entire configuration form.
	 */
	public function blockForm($form, FormStateInterface $form_state) {
		$form ['city_name'] = [
				'#type' => 'textfield',
				'#title' => 'City Name',
				'#default_value' => $this->configuration ['city_name']
		];
		return $form;
	}
	public function blockSubmit($form, FormStateInterface $form_state) {
		$this->configuration ['city_name'] = $form_state->getValue ( 'city_name' );
	}
	public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
		return new static ( $configuration, $plugin_id, $plugin_definition, $container->get ( 'moduleone.weatherapi' ) );
	}
}

