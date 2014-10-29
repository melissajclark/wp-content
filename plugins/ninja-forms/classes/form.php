<?php
/**
 * Handles the output of our form, as well as interacting with its settings.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Form
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.7
*/

class NF_Form {

	/**
	 * @var form_id
	 * @since 2.7
	 */
	var $form_id;

	/**
	 * @var settings - Form Settings
	 * @since 2.7
	 */
	var $settings = array();

	/**
	 * @var fields - Form Fields
	 * @since 2.7
	 */
	var $fields = array();

	/**
	 * @var fields - Fields List
	 * @since 2.7
	 */
	var $field_keys = array();

	/**
	 * @var errors - Form errors
	 * @since 2.7
	 */
	var $errors = array();

	/**
	 * Get things started
	 * 
	 * @access public
	 * @since 2.7
	 * @return void
	 */
	public function __construct( $form_id ) {
		// Set our current form id.
		$this->form_id = $form_id;

		$this->fields = nf_get_fields_by_form_id( $form_id );
		$this->settings = nf_get_form_settings( $form_id );
	}

	/**
	 * Get one of our form settings.
	 * 
	 * @access public
	 * @since 2.7
	 * @return string $setting
	 */
	public function get_setting( $setting ) {
		if ( isset ( $this->settings[ $setting ] ) ) {
			return $this->settings[ $setting ];
		} else {
			return false;
		}
	}

	/**
	 * Update a form setting (this doesn't update anything in the database)
	 * Changes are only applied to this object.
	 * 
	 * @access public
	 * @param string $setting
	 * @param mixed $value
	 * @return bool
	 */
	public function update_setting( $setting, $value ) {
		$this->settings[ $setting ] = $value;
		return true;
	}

	/**
	 * Get all the submissions for this form
	 * 
	 * @access public
	 * @since 2.7
	 * @return array $sub_ids
	 */
	public function get_subs( $args = array() ) {
		$args['form_id'] = $this->form_id;
		return Ninja_Forms()->subs()->get( $args );
	}

	/**
	 * Return a count of the submissions this form has had
	 * 
	 * @access public
	 * @param array $args
	 * @since 2.7
	 * @return int $count
	 */
	public function sub_count( $args = array() ) {
		return count( $this->get_subs( $args ) );
	}

}