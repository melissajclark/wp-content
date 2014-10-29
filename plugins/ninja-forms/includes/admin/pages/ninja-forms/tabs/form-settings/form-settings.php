<?php


function ninja_forms_register_tab_form_settings(){
	$all_forms_link = esc_url(remove_query_arg(array('form_id', 'tab')));
	$args = array(
		'name' => __( 'Form Settings', 'ninja-forms' ),
		'page' => 'ninja-forms',
		'display_function' => 'ninja_forms_display_form_settings',
		'save_function' => 'ninja_forms_save_form_settings',
		'tab_reload' => false,
		//'title' => '<h2>Forms <a href="'.$all_forms_link.'" class="add-new-h2">'.__('View All Forms', 'ninja-forms').'</a></h2>',
	);
	ninja_forms_register_tab('form_settings', $args);
}

add_action( 'admin_init', 'ninja_forms_register_tab_form_settings' );

function ninja_forms_display_form_settings($form_id, $data){
	if(isset($data['form_title'])){
		$form_title = $data['form_title'];
		$prompt_text = 'screen-reader-text';
	}else{
		$form_title = '';
		$prompt_text = '';
	}

	if(isset($data['show_title'])){
		$show_title = $data['show_title'];
	}else{
		$show_title = '';
	}
?>
	<div id="titlediv">
		<div id="titlewrap">
			<label class="<?php echo $prompt_text;?>" id="title-prompt-text" for="title"><?php _e( 'Enter form title here', 'ninja-forms' ); ?></label>
			<input type="text" name="form_title" size="30" value="<?php echo esc_attr($form_title); ?>" id="title" autocomplete="off">
		</div>
	</div>
<?php
}

function ninja_forms_register_form_settings_basic_metabox(){

	if( isset( $_REQUEST['form_id'] ) ){
		$form_id = absint( $_REQUEST['form_id'] );
		$form_row = ninja_forms_get_form_by_id( $form_id );
		$form_data = $form_row['data'];
	}else{
		$form_id = '';
		$form_row = '';
		$form_data = '';
	}

	$pages = get_pages();
	$pages_array = array();
	$append_array = array();
	array_push($pages_array, array('name' => __( '- None', 'ninja-forms' ), 'value' => ''));
	array_push($append_array, array('name' => __( '- None', 'ninja-forms' ), 'value' => ''));
	foreach ($pages as $pagg) {
		array_push($pages_array, array('name' => $pagg->post_title, 'value' => get_page_link($pagg->ID)));
		array_push($append_array, array('name' => $pagg->post_title, 'value' => $pagg->ID));
	}

	if( isset( $form_data['ajax'] ) ){
		$ajax = $form_data['ajax'];
	}else{
		$ajax = 0;
	}

	$args = apply_filters( 'ninja_forms_form_settings_basic', array(
		'page' => 'ninja-forms',
		'tab' => 'form_settings',
		'slug' => 'basic_settings',
		'title' => __( 'Basic Form Behavior Settings', 'ninja-forms' ),
		'state' => 'closed',
		'settings' => array(
			array(
				'name' => 'show_title',
				'type' => 'checkbox',
				'label' => __( 'Display Form Title', 'ninja-forms' ),
			),
			array(
				'name' => 'logged_in',
				'type' => 'checkbox',
				'desc' => '',
				'label' => __( 'Require user to be logged in to view form?', 'ninja-forms' ),
				'display_function' => '',
				'help' => __( '', 'ninja-forms' ),
			),
			array(
				'name' => 'append_page',
				'type' => 'select',
				'desc' => '',
				'label' => __( 'Add form to this page', 'ninja-forms' ),
				'display_function' => '',
				'help' => __('', 'ninja-forms'),
				'options' => $append_array,
			),
			array(
				'name' => 'ajax',
				'type' => 'checkbox',
				'desc' => '',
				'label' => __( 'Submit via AJAX (without page reload)?', 'ninja-forms' ),
				'display_function' => '',
				'help' => __( '', 'ninja-forms' )
			),
			array(
				'name' => 'clear_complete',
				'type' => 'checkbox',
				'desc' => '',
				'label' => __( 'Clear successfully completed form?', 'ninja-forms' ),
				'display_function' => '',
				'desc' => __( 'If this box is checked, Ninja Forms will clear the form values after it has been successfully submitted.', 'ninja-forms' ),
				'default_value' => 1,
			),
			array(
				'name' => 'hide_complete',
				'type' => 'checkbox',
				'desc' => '',
				'label' => __( 'Hide successfully completed form?', 'ninja-forms' ),
				'display_function' => '',
				'desc' => __( 'If this box is checked, Ninja Forms will hide the form after it has been successfully submitted.', 'ninja-forms' ),
				'default_value' => 1,
			),
			array(
				'name' => 'sub_limit_number',
				'type' => 'number',
				'desc' => '',
				'label' => __( 'Limit Submissions', 'ninja-forms' ),
				'display_function' => '',
				'desc' => __( 'Select the number of submissions that this form will accept. Leave empty for no limit.', 'ninja-forms' ),
				'default_value' => '',
				'tr_class' => '',
				'min' => 0,
			),
			array(
				'name' => 'sub_limit_msg',
				'type' => 'rte',
				'label' => __( 'Limit Reached Message', 'ninja-forms' ),
				'desc' => __( 'Please enter a message that you want displayed when this form has reached its submission limit and will not accept new submissions.', 'ninja-forms' ),
				'tr_class' => '',
			),
		),
	));
	ninja_forms_register_tab_metabox($args);
}

add_action( 'admin_init', 'ninja_forms_register_form_settings_basic_metabox' );

function ninja_forms_admin_email($form_id, $data){
	if(isset($data['admin_mailto'])){
		$admin_mailto = $data['admin_mailto'];
	}else{
		$admin_mailto = '';
	}

	?>
	<label for="">
		<p>
			<a href="#" id="ninja_forms_add_mailto_<?php echo $form_id;?>" name="" class="ninja-forms-add-mailto"><?php _e( 'Add New', 'ninja-forms' ); ?></a>
			<a href="#" class="tooltip">
			    <img id="" class='ninja-forms-help-text' src="<?php echo NINJA_FORMS_URL;?>images/question-ico.gif" title="">
			    <span>
			        <img class="callout" src="<?php echo NINJA_FORMS_URL;?>/images/callout.gif" />
			        <?php _e( 'Please enter all the addresses this form should be sent to.', 'ninja-forms' );?>
			    </span>
			</a>
		</p>
	</label>
	<div id="ninja_forms_mailto">
		<input type="hidden" name="admin_mailto" value="">
		<?php
		if(is_array($admin_mailto) AND !empty($admin_mailto)){
			$x = 0;
			foreach($admin_mailto as $v){
				?>
				<span id="ninja_forms_mailto_<?php echo $x;?>_span">
					<a href="#" id="" class="ninja-forms-remove-mailto">X</a> <input type="text" name="admin_mailto[]" id="" value="<?php echo $v;?>" class="ninja-forms-mailto-address">
				</span>
				<?php
				$x++;
			}
		}
		?>
	</div>
	<br />
	<?php
}

function ninja_forms_save_form_settings( $form_id, $data ){
	global $wpdb, $ninja_forms_admin_update_message;
	$form_row = ninja_forms_get_form_by_id( $form_id );
	$form_data = $form_row['data'];

	foreach ( $data as $key => $val ){
		$form_data[$key] = $val;
	}

	if ( $form_id != 'new' ){

		$email_from = ninja_forms_split_email_from( $form_data['email_from'] );

		$form_data['email_from'] = $email_from['email_from'];

		if ( !isset ( $form_data['email_from_name'] ) or empty( $form_data['email_from_name'] ) ) {
			$form_data['email_from_name'] = $email_from['email_from_name'];
		}

		if ( empty( $form_data['email_from_name'] ) ) {
			$form_data['email_from_name'] = get_option( 'blogname' );
		}
		if ( empty( $form_data['email_from'] ) ) {
			$form_data['email_from'] = get_option( 'admin_email' );
		}

		$date_updated = date( 'Y-m-d H:i:s', strtotime ( 'now' ) );

		$data_array = array( 'data' => serialize( $form_data ), 'date_updated' => $date_updated );
		$wpdb->update( NINJA_FORMS_TABLE_NAME, $data_array, array( 'id' => $form_id ) );
	} else {
		if ( empty( $form_data['admin_mailto'] ) ) {
			$form_data['admin_mailto'] = array( get_option( 'admin_email' ) );
		}
		if ( empty( $form_data['email_from_name'] ) ) {
			$form_data['email_from_name'] = get_option( 'blogname' );
		}
		if ( empty( $form_data['email_from'] ) ) {
			$form_data['email_from'] = get_option( 'admin_email' );
		}
		$data_array = array('data' => serialize( $form_data ) );

		$wpdb->insert( NINJA_FORMS_TABLE_NAME, $data_array );
		$redirect = add_query_arg( array( 'form_id' => $wpdb->insert_id, 'update_message' => urlencode( __( 'Form Settings Saved', 'ninja-forms' ) ) ) );
		do_action( 'ninja_forms_save_new_form_settings', $wpdb->insert_id, $data );
		wp_redirect( $redirect );
		exit();
	}
	$update_msg = __( 'Form Settings Saved', 'ninja-forms' );
	return $update_msg;
}
