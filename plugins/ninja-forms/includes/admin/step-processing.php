<?php

/**
 * Register our step processing admin page.
 * 
 * @since 2.7.6
 * @return void
 */
function nf_register_step_processing_page() {
	// Register our admin page
	$admin_page = add_submenu_page( NULL, __( 'Ninja Forms Processing', 'ninja-forms' ), __( 'Processing', 'ninja-forms' ), apply_filters( 'ninja_forms_admin_menu_capabilities', 'manage_options' ), 'nf-processing', 'nf_output_step_processing_page' );
	
	add_action( 'admin_print_styles-' . $admin_page, 'nf_step_processing_css' );
	add_action( 'admin_print_styles-' . $admin_page, 'nf_step_processing_js' );
}

add_action( 'admin_menu', 'nf_register_step_processing_page' );

/**
 * Enqueue our step processing CSS.
 * 
 * @since 2.7.6
 * @return void
 */
function nf_step_processing_css() {
	wp_enqueue_style( 'jquery-smoothness', NF_PLUGIN_URL .'css/smoothness/jquery-smoothness.css');
}

/**
 * Enqueue our step processing JS.
 * 
 * @since 2.7.6
 * @return void
 */
function nf_step_processing_js() {
	wp_enqueue_script( 'nf-processing',
		NF_PLUGIN_URL . 'assets/js/dev/step-processing.js',
		array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-datepicker', 'jquery-ui-draggable', 'jquery-ui-droppable', 'jquery-ui-progressbar' ) );
}

/**
 * Output our step processing admin page.
 * 
 * @since 2.7.6
 * @return void
 */
function nf_output_step_processing_page() {
	?>
	<style>
		.ui-progressbar {
			position: relative;
			width: 800px;
			max-width: 100%;
			height: 20px;
			
		}

		.progress-label {
			line-height: 12px;
			position: absolute;
			left: 40%;
			top: 4px;
			font-weight: bold;
			text-shadow: 1px 1px 0 #fff;

		}

		.ui-progressbar-value {
			/*background-size: 100% auto;*/
			background-color: #FFF;
			background-repeat: repeat;
			background-image: url(<?php echo NF_PLUGIN_URL . 'assets/images/pbar-ani.gif'; ?>);
		}

	</style>
	<script type="text/javascript">

		<?php
		if ( isset ( $_REQUEST['action'] ) && ! empty ( $_REQUEST['action'] ) ) {
			$action = __( 'Loading...', 'ninja-forms' );
			?>
			var nfProcessingAction = 'nf_<?php echo $_REQUEST['action']; ?>';
			<?php
		} else {
			$action = __( 'No Action Specified...', 'ninja-forms' );
			?>
			var nfProcessingAction = 'none';
			<?php
		}

		$tmp_array = array();
		$url_params = parse_url( add_query_arg( array() ) );
		$query = $url_params['query'];
		$query = parse_str( $query, $tmp_array );
		unset ( $tmp_array['action'] );
		unset ( $tmp_array['page'] );
		?>
		
		var nfProcessingArgs = <?php echo json_encode( $tmp_array ); ?>

	</script>

	<?php
	
	?>

	<div class="wrap">
		<h2><?php _e( 'Ninja Forms - Processing', 'ninja-forms' ); ?></h2>
			<div id="nf-upgrade-status">
				<p><?php _e( 'The process has started, please be patient. This could take several minutes. You will be automatically redirected when the process is finished.', 'ninja-forms' ); ?></p>
				<div id="progressbar">
					<div class="progress-label">
						<?php echo $action; ?>
					</div>
				</div>
			</div>
	</div>
	<?php
}