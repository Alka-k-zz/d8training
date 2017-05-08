<?php

namespace Drupal\moduleone\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\StateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class MiscForm.
 *
 * @package Drupal\moduleone\Form
 */
class MiscForm extends FormBase {
	private $state;
	public function __construct(StateInterface $state) {
		$this->state = $state;
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function getFormId() {
		return 'misc_form';
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function buildForm(array $form, FormStateInterface $form_state) {
		$form ['qualifications'] = [
				'#type' => 'select',
				'#title' => $this->t ( 'Qualifications' ),
				'#options' => array (
						'ug' => $this->t ( 'UG' ),
						'pg' => $this->t ( 'PG' ),
						'other' => $this->t ( 'Other' )
				),
				'#size' => 5
		];
		$form ['qualifications_other'] = [
				'#type' => 'textfield',
				'#title' => $this->t ( 'Qualifications' ),
				'#maxlength' => 64,
				'#size' => 64,
				'#states' => [
						'visible' => [
								':input[name=qualifications]' => array (
										'value' => 'other'
								)
						]
				]
		];
		$form ['country'] = [
				'#type' => 'select',
				'#title' => $this->t ( 'Select Country' ),
				'#options' => [
						'india' => $this->t ( 'India' ),
						'uk' => $this->t ( 'UK' )
				],
				'#default' => $this->state->get ( $country ),
				'#ajax' => [
						'callback' => 'Drupal\moduleone\Form\MiscForm::populateStates',
						'wrapper' => 'ajax-callback-wrapper'
				]
		];
		// Ajax container with 'id' as 'wrapper' value.
		$form ['ajax-container'] = [
				'#type' => 'container',
				'#attributes' => [
						'id' => 'ajax-callback-wrapper'
				]
		];

		$form ['submit'] = [
				'#type' => 'submit',
				'#value' => $this->t ( 'Submit' )
		];

		return $form;
	}

	/**
	 * Ajax call to states depending on country selected.
	 */
	public function populateStates(array &$form, FormStateInterface $form_state) {
		$country = $form_state->getValue ( 'country' );
		$states ['india'] = [
				'MH',
				'TN',
				'MP'
		];
		$states ['uk'] = [
				'ENG',
				'SCO',
				'WAL'
		];
		$form ['ajax-container'] ['states'] = [
				'#type' => 'select',
				'#options' => $states [$country]
		];
		return $form ['ajax-container'];
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function validateForm(array &$form, FormStateInterface $form_state) {
		parent::validateForm ( $form, $form_state );
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {
		// Display result.
		foreach ( $form_state->getValues () as $key => $value ) {
			drupal_set_message ( $key . ': ' . $value );
		}
		$this->state->set ( $key, $value );
	}
	public static function create(ContainerInterface $container) {
		return new static ( $container->get ( 'state' ) );
	}
}
