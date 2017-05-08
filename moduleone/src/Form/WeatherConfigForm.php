<?php

namespace Drupal\moduleone\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;

class WeatherConfigForm extends ConfigFormBase {

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
		parent::submitForm ( $form, $form_state );
	}
}