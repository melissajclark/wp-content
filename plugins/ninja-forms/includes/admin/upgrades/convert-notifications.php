<?php

class NF_Convert_Notifications extends NF_Step_Processing {

	function __construct() {
		$this->action = 'convert_notifications';

		parent::__construct();
	}

	public function loading() {
		global $wpdb;

		/**
	 	 * Add our table structure for version 2.8.
	 	 */

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	 	// Create our object meta table
	 	$sql = "CREATE TABLE IF NOT EXISTS ". NF_OBJECT_META_TABLE_NAME . " (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `object_id` bigint(20) NOT NULL,
		  `meta_key` varchar(255) NOT NULL,
		  `meta_value` longtext NOT NULL,
		  PRIMARY KEY (`id`)
		) DEFAULT CHARSET=utf8;";
	
		dbDelta( $sql );

		// Create our object table
		$sql = "CREATE TABLE IF NOT EXISTS " . NF_OBJECTS_TABLE_NAME . " (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `type` varchar(255) NOT NULL,
		  PRIMARY KEY (`id`)
		) DEFAULT CHARSET=utf8;";
	
		dbDelta( $sql );

		// Create our object relationships table

		$sql = "CREATE TABLE IF NOT EXISTS " . NF_OBJECT_RELATIONSHIPS_TABLE_NAME . " (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `child_id` bigint(20) NOT NULL,
		  `parent_id` bigint(20) NOT NULL,
		  `child_type` varchar(255) NOT NULL,
		  `parent_type` varchar(255) NOT NULL,
		  PRIMARY KEY (`id`)
		) DEFAULT CHARSET=utf8;";

		dbDelta( $sql );

		// Remove old email settings.
		nf_change_email_fav();
		nf_remove_old_email_settings();

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

		$this->redirect = admin_url( 'index.php?page=nf-about' );

		return $args;
	}

	public function step() {
		global $ninja_forms_fields;

		// Get our form ID
		$form_id = $this->args['forms'][ $this->step ];

		// Get a list of forms that we've already converted.
		$completed_forms = get_option( 'nf_convert_notifications_forms', array() );

		// Bail if we've already converted the notifications for this form.
		if ( in_array( $form_id, $completed_forms ) )
			return false;

		// Grab our form from the database
		$form_settings = Ninja_Forms()->form( $form_id )->settings;

		$fields = Ninja_Forms()->form( $form_id )->fields;

		$process_fields = array();
		foreach( $fields as $field_id => $field ) {
			$label = strip_tags( nf_get_field_admin_label( $field_id ) );

			if ( strlen( $label ) > 30 ) {
				$tmp_label = substr( $label, 0, 30 );
			} else {
				$tmp_label = $label;
			}

			$tmp_array = array( 'value' => $field_id, 'label' => $tmp_label . ' - ID: ' . $field_id );

			$admin_label = $label;

			$label = isset( $field['data']['label'] ) ? $field['data']['label'] : '';

			// Check to see if this field is supposed to be "processed"
			$type = $field['type'];
			if ( isset ( $ninja_forms_fields[ $type ]['process_field'] ) && $ninja_forms_fields[ $type ]['process_field'] ) {
				$process_fields[ $field_id ] = array( 'field_id' => $field_id, 'label' => $label, 'admin_label' => $admin_label );
			}
		}

		// Create a notification for our admin email
		if ( isset ( $form_settings['admin_mailto'] ) && ! empty ( $form_settings['admin_mailto'] ) ) {
			// Create a notification
			$n_id = nf_insert_notification( $form_id );

			// Update our notification type
			nf_update_object_meta( $n_id, 'type', 'email' );

			// Activate our notification
			Ninja_Forms()->notification( $n_id )->activate();

			// Update our notification name
			Ninja_Forms()->notification( $n_id )->update_setting( 'name', __( 'Admin Email', 'ninja-forms' ) );

			// Implode our admin email addresses
			$to = implode('`', $form_settings['admin_mailto'] );
			// Update our to setting
			Ninja_Forms()->notification( $n_id )->update_setting( 'to', $to );

			// Update our Format Setting
			Ninja_Forms()->notification( $n_id )->update_setting( 'email_format', $form_settings['email_type'] );

			// Update our attach csv option
			Ninja_Forms()->notification( $n_id )->update_setting( 'attach_csv', $form_settings['admin_attach_csv'] );

			// Update our subject
			$subject = $this->replace_shortcodes( $form_settings['admin_subject'] );
						
			Ninja_Forms()->notification( $n_id )->update_setting( 'email_subject', $subject );
				
			// Update our From Name
			if ( isset ( $form_settings['email_from_name'] ) ) {
				Ninja_Forms()->notification( $n_id )->update_setting( 'from_name', $form_settings['email_from_name'] );
			}

			foreach ( $fields as $field ) {
				if ( isset ( $field['data']['from_name'] ) && $field['data']['from_name'] == 1 ) {
					// Update our From Name
					Ninja_Forms()->notification( $n_id )->update_setting( 'from_name', 'field_' . $field['id'] );
					break;
				}
			}

			// Update our From Address
			Ninja_Forms()->notification( $n_id )->update_setting( 'from_address', $form_settings['email_from'] );

			// Get our reply-to address
			foreach ( $fields as $field ) {
				if ( isset ( $field['data']['replyto_email'] ) && $field['data']['replyto_email'] == 1 ) {
					Ninja_Forms()->notification( $n_id )->update_setting( 'reply_to', 'field_' . $field['id'] );
					break;
				}
			}

			$email_message = $form_settings['admin_email_msg'];

			// Check to see if the "include list of fields" checkbox was checked.
			if ( isset ( $form_settings['admin_email_fields'] ) && $form_settings['admin_email_fields'] == 1 ) {
				$email_message .= '<br />[ninja_forms_all_fields]';
			}

			// Update our email message
			Ninja_Forms()->notification( $n_id )->update_setting( 'email_message', $email_message );

			Ninja_Forms()->notification( $n_id )->update_setting( 'admin_email', true );
		}

		// Create a notification for our user email
		if ( ! empty ( $fields ) ) {
			$addresses = array();
			foreach ( $fields as $field_id => $field ) {
				if ( isset ( $field['data']['send_email'] ) && $field['data']['send_email'] == 1 ) {
					// Add this field to our $addresses variable.
					$addresses[] = $field_id;
					unset( $field['data']['send_email'] );
					unset( $field['data']['replyto_email'] );
					unset( $field['data']['from_name'] );

					$args = array(
						'update_array'	=> array(
							'data'		=> serialize( $field['data'] ),
						),
						'where'			=> array(
							'id' 		=> $field_id,
						),
					);

					ninja_forms_update_field( $args );
				}
			}

			if ( ! empty ( $addresses ) ) {
				// We have a user email, so create a notification
				$n_id = nf_insert_notification( $form_id );

				// Update our notification type
				nf_update_object_meta( $n_id, 'type', 'email' );

				// Activate our notification
				Ninja_Forms()->notification( $n_id )->activate();

				// Update our notification name
				Ninja_Forms()->notification( $n_id )->update_setting( 'name', __( 'User Email', 'ninja-forms' ) );

				// Implode our admin email addresses
				$n_var = count ( $addresses ) > 1 ? 'bcc' : 'to';
				$addresses = implode( '`', $addresses );
				Ninja_Forms()->notification( $n_id )->update_setting( $n_var, $addresses );

				// Update our Format Setting
				Ninja_Forms()->notification( $n_id )->update_setting( 'email_format', $form_settings['email_type'] );

				// Update our subject
				$subject = $this->replace_shortcodes( $form_settings['user_subject'] );
							
				Ninja_Forms()->notification( $n_id )->update_setting( 'email_subject', $subject );

				// Update our From Name
				if ( isset ( $form_settings['email_from_name'] ) ) {
					Ninja_Forms()->notification( $n_id )->update_setting( 'from_name', $form_settings['email_from_name'] );
				}
				
				// Update our From Address
				Ninja_Forms()->notification( $n_id )->update_setting( 'from_address', $form_settings['email_from'] );

				$email_message = $form_settings['user_email_msg'];

				// Check to see if the "include list of fields" checkbox was checked. If so, add our table to the end of the email message.
				if ( isset ( $form_settings['user_email_fields'] ) && $form_settings['user_email_fields'] == 1 ) {
					$email_message .= '<br />[ninja_forms_all_fields]';
				}

				// Update our email message
				Ninja_Forms()->notification( $n_id )->update_setting( 'email_message', $email_message );

				Ninja_Forms()->notification( $n_id )->update_setting( 'user_email', true );
			}
		}

		if ( isset ( $form_settings['success_msg'] ) && ! empty( $form_settings['success_msg'] ) ) {
			// Create a notification for our success message
			$n_id = nf_insert_notification( $form_id );
			nf_update_object_meta( $n_id, 'name', __( 'Success Message', 'ninja-forms' ) );
			nf_update_object_meta( $n_id, 'type', 'success_message' );
			nf_update_object_meta( $n_id, 'active', 1 );
			nf_update_object_meta( $n_id, 'success_msg', $form_settings['success_msg'] );
		}

		if ( isset ( $form_settings['landing_page'] ) && ! empty( $form_settings['landing_page'] ) ) {
			// Create a notification for our redirect
			$n_id = nf_insert_notification( $form_id );
			nf_update_object_meta( $n_id, 'name', __( 'Redirect', 'ninja-forms' ) );
			nf_update_object_meta( $n_id, 'type', 'redirect' );
			nf_update_object_meta( $n_id, 'active', 1 );
			nf_update_object_meta( $n_id, 'redirect_url', $form_settings['landing_page'] );
		}

		$completed_forms = get_option( 'nf_convert_notifications_forms' );
		if ( ! is_array( $completed_forms ) || empty ( $completed_forms ) ) {
			$completed_forms = array( $form_id );
		} else {
			$completed_forms[] = $form_id;
		}
		update_option( 'nf_convert_notifications_forms', $completed_forms );

		// Unset our admin email settings and save the form.
		if ( isset ( $form_settings['admin_mailto'] ) ) {
			unset( $form_settings['admin_mailto'] );
			unset( $form_settings['admin_attach_csv'] );
			unset( $form_settings['admin_subject'] );
			unset( $form_settings['admin_email_msg'] );
			unset( $form_settings['admin_email_fields'] );
			unset( $form_settings['success_msg'] );
			unset( $form_settings['user_email_msg'] );
			unset( $form_settings['user_subject'] );
			unset( $form_settings['landing_page'] );

			$args = array(
				'update_array' 	=> array(
					'data'		=> serialize( $form_settings ),
				),
				'where'		   	=> array(
					'id'	=> $form_id,
				),
			);

			ninja_forms_update_form( $args );
		}
	}

	public function complete() {
		update_option( 'nf_convert_notifications_complete', true );
	}

	private function replace_shortcodes( $text ) {
		$matches = array();
		$pattern = get_shortcode_regex();
		preg_match_all('/'.$pattern.'/s', $text, $matches);

		if ( is_array( $matches ) && ! empty( $matches[2] ) ) {
			foreach ( $matches[2] as $key => $shortcode ) {
				if ( $shortcode == 'ninja_forms_field' ) {
					if ( isset ( $matches[3][ $key ] ) ) {
						$atts = shortcode_parse_atts( $matches[3][ $key ] );
						$id = $atts['id'];
						$text = str_replace( $matches[0][ $key ], '`field_' . $id . '`', $text );
					}		
				}
			}
		}
		return $text;
	}
}