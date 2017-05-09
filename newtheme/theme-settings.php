<?php
use Drupal\Core\Form\FormStateInterface;
function newtheme_form_system_theme_settings_alter(&$form, FormStateInterface $form_state) {
	$form ['site_sub_slogon'] = array (
			'#type' => 'textfield',
			"#title" => t ( 'Site Sub-slogon' ),
			'#default_value' => theme_get_setting ( 'site_sub_slogon' ),
			'#description' => t ( 'Place this text in the header on the website' )
	);
}