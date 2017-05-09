<?php

namespace Drupal\moduleone\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\moduleone\Event\WeatherConfigEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class WeatherConfigForm extends ConfigFormBase {
	public function __construct(ConfigFactoryInterface $config_factory, EventDispatcherInterface $eventDispatcher) {
		parent::__construct ( $config_factory );
		$this->eventDispatcher = $eventDispatcher;
	}

	/**
	 * Returns a unique string identifying the form.
	 *
	 * @return string The unique string identifying the form.
	 */
	public function getFormId() {
		return 'weather_form';
	}

	/**
	 * Form constructor.
	 *
	 * @param array $form
	 *        	An associative array containing the structure of the form.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *        	The current state of the form.
	 *
	 * @return array The form structure.
	 */
	public function buildForm(array $form, FormStateInterface $form_state) {
		$form ['appid'] = [
				'#type' => 'textfield',
				'#title' => 'Weather app API Key',
				'#default_value' => $this->config ( 'moduleone.weather_config' )->get ( 'appid' )
		];

		return parent::buildForm ( $form, $form_state );
	}
	public static function create(ContainerInterface $container) {
		return new static ( $container->get ( 'config.factory' ), $container->get ( 'event_dispatcher' ) );
	}

	/**
	 *
	 * @param array $form
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 */
	public function validateForm(array &$form, FormStateInterface $form_state) {
	}
	public function getEditableConfigNames() {
		return [
				'moduleone.weather_config'
		];
	}

	/**
	 * Form submission handler.
	 *
	 * @param array $form
	 *        	An associative array containing the structure of the form.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *        	The current state of the form.
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {
		// drupal_set_message ( 'Form submitted successfully' );
		$this->config ( 'moduleone.weather_config' )->set ( 'appid', $form_state->getValue ( 'appid' ) )->save ();
		$event = new WeatherConfigEvent ( $form_state->getValue ( 'appid' ) );
		$this->eventDispatcher->dispatch ( WeatherConfigEvent::WEATHER_CONFIG_UPDATE, $event );
		parent::submitForm ( $form, $form_state );
	}
}