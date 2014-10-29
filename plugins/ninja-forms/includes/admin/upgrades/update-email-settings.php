<?php


class NF_Update_Email_Settings extends NF_Step_Processing {

	function __construct() {
		$this->action = 'update_email_settings';

		parent::__construct();
	}

	public function loading() {

		// Remove old email settings.
		nf_change_email_fav();

		// Get our total number of forms.
		$form_count = nf_get_form_count();

		// Get all our forms
		$forms = ninja_forms_get_all_forms( true );

		$x = 1;
		if ( is_array( $forms ) ) {
			foreach ( $forms as $form ) {
				$this->args['forms'][$x] = $form['id'];
				$x++;
			}
		}

		if( empty( $this->total_steps ) || $this->total_steps <= 1 ) {
			$this->total_steps = $form_count;
		}

		$args = array(
			'total_steps' 	=> $this->total_steps,
			'step' 			=> 1,
		);

		$this->redirect = admin_url( 'admin.php?page=ninja-forms' );

		return $args;
	}

	public function step() {
		// Get our form ID
		$form_id = $this->args['forms'][ $this->step ];
		nf_remove_old_email_settings( $form_id );
	}

	public function complete() {
		update_option( 'nf_update_email_settings_complete', true );
	}
}