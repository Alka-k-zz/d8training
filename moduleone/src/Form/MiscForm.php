<?php

namespace Drupal\moduleone\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class MiscForm.
 *
 * @package Drupal\moduleone\Form
 */
class MiscForm extends FormBase {

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
				'#title' => $this->t ( 'Country' ),
				'#options' => array (
						'india' => $this->t ( 'India' ),
						'uk' => $this->t ( 'UK' )
				),
				'#size' => 5
		];

		$form ['submit'] = [
				'#type' => 'submit',
				'#value' => $this->t ( 'Submit' )
		];

		return $form;
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
	}
}
