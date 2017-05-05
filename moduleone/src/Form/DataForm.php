<?php

namespace Drupal\moduleone\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\moduleone\dbFormWrapper;

class DataForm extends FormBase {
	private $dbFormWrapper;
	public function __construct(dbFormWrapper $dbFormWrapper) {
		$this->dbFormWrapper = $dbFormWrapper;
	}

	/**
	 * Returns a unique string identifying the form.
	 *
	 * @return string The unique string identifying the form.
	 */
	public function getFormId() {
		return 'database_form';
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
		$data = $this->dbFormWrapper->getData ();
		$form ['first_name'] = [
				'#type' => 'textfield',
				'#title' => 'First Name',
				'#required' => TRUE,
				'#default_value' => $data ['first_name'],
				'#description' => 'Enter you first name.'
		];

		$form ['last_name'] = [
				'#type' => 'textfield',
				'#title' => 'Last Name',
				'#required' => TRUE,
				'#default_value' => $data ['last_name'],
				'#description' => 'Enter you last name.'
		];

		$form ['submit'] = [
				'#type' => 'submit',
				'#value' => 'Click me!'
		];

		return $form;
	}

	/**
	 *
	 * @param array $form
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 */
	public function validateForm(array &$form, FormStateInterface $form_state) {
		$name = $form_state->getValue ( 'first_name' );
		if (strlen ( $name ) < 3) {
			$form_state->setErrorByName ( 'first_name', 'Your name should at least have 3 characters!' );
		}
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
		$first_name = $form_state->getValue ( 'first_name' );
		$last_name = $form_state->getValue ( 'last_name' );
		$this->dbFormWrapper->setData ( $first_name, $last_name );
		drupal_set_message ( 'Form submitted successfully' );
	}
	public static function create(ContainerInterface $container) {
		return new static ( $container->get ( 'moduleone.db_form_wrapper' ) );
	}
}