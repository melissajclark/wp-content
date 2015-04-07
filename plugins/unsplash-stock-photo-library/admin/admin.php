<?php

/* Admin function */
add_action( 'admin_head', 'usp_admin_vars' );
add_action( 'wp_ajax_usp_upload_image', 'usp_upload_image' ); // Ajax Save Repeater
add_action( 'wp_ajax_nopriv_usp_upload_image', 'usp_upload_image' ); // Ajax Save Repeater




/*
*  usp_admin_vars
*  Create admin variables and ajax nonce
*
*  @since 1.0
*/

function usp_admin_vars() { ?>
    <script type='text/javascript'>
	 /* <![CDATA[ */
    var usp_admin_localize = <?php echo json_encode( array( 
        'ajax_admin_url' => admin_url( 'admin-ajax.php' ),
        'usp_admin_nonce' => wp_create_nonce( 'usp_nonce' )
    )); ?>
    /* ]]> */
    </script>
<?php }




/**
* usp_admin_menu
* Create Admin Menu
*
* @since 1.0
*/

add_action( 'admin_menu', 'usp_admin_menu' );
function usp_admin_menu() {  
   $usp_settings_page = add_submenu_page( 'options-general.php', 'Unsplash WP', 'Unsplash WP', 'edit_theme_options', 'unsplash', 'usp_settings_page'); 	
   
   //Add our admin scripts
   add_action( 'load-' . $usp_settings_page, 'usp_load_admin_scripts' );
   
   
}



/**
* usp_load_admin_scripts
* Load Admin CSS and JS
*
* @since 1.0
*/

function usp_load_admin_scripts(){
	add_action( 'admin_enqueue_scripts', 'usp_enqueue_admin_scripts' );
}



/**
* usp_enqueue_admin_scripts
* Admin Enqueue Scripts
*
* @since 1.0
*/

function usp_enqueue_admin_scripts(){
   wp_enqueue_style( 'admin-css', USP_ADMIN_URL. 'css/admin.css');
   wp_enqueue_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');
   wp_enqueue_script('jquery');
   wp_enqueue_script( 'jquery-form' );
}




/**
* usp_media_popup
* Add pop up button to post/page editor
*
* @since 1.0
*/

add_action( 'media_buttons_context',  'usp_media_popup' );
function usp_media_popup($context) {

  //our popup's title
  $title = 'Unsplash WP';

  //append the icon
  $context .= "<a href='#TB_inline?width=1200&height=800%&inlineId=popup_container'
    class='button thickbox unsplash' title='Unsplash WP - Click photos to upload directly to your media library'>
    <span class='dashicons dashicons-format-gallery'></span> Unsplash Uploader</a>";

  return $context;
}



/**
* usp_media_popup_content
* Add pop up content to edit, new and post pages
*
* @since 1.0
*/

add_action( 'admin_head-post.php',  'usp_media_popup_content' );
add_action( 'admin_head-post-new.php',  'usp_media_popup_content' );
add_action( 'admin_head-edit.php',  'usp_media_popup_content' );

function usp_media_popup_content() {
   wp_enqueue_style( 'admin-css', USP_ADMIN_URL. 'css/admin.css');
   wp_enqueue_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');
   ?>

   <div id="popup_container" style="display:none;">
     <?php include( USP_PATH . 'admin/includes/unsplash-photos.php');	?> 
   </div>
<?php
}



/*
*  usp_settings_page
*  Settings page
*
*  @since 1.0
*/

function usp_settings_page(){ ?>
	<div class="admin cnkt-container settings" id="usp-settings">
		<div class="wrap">
		   <div class="header-wrap">
            <h2><?php echo USP_TITLE; ?> <span><?php echo USP_VERSION; ?></span></h2>
            <p><?php _e('One click uploads of <a href="https://unsplash.com/" target="_blank">unsplash.com</a> stock photos directly to your media library', USP_NAME); ?></p>            
         </div>
		   <div class="cnkt-main">
		   	<div class="group">   		   	   
	   			<?php include( USP_PATH . 'admin/includes/unsplash-photos.php');	?>    
	   			<p class="back2top"><a href="#wpcontent"><i class="fa fa-chevron-up"></i> <?php _e('Back to Top', USP_NAME); ?></a></p>  	   			
		   	</div>
		   </div>		   
		   <div class="cnkt-sidebar">
		      <div class="cta">
		      
		      <form action="options.php" method="post" id="usp_OptionsForm">   		         
   				<?php 
   					settings_fields( 'usp-setting-group' );
   					do_settings_sections( 'unsplash' );	
   					//get the older values, wont work the first time
   					$options = get_option( '_usp_settings' ); ?>	
   					<div class="submit-usp_OptionsForm">	       
   		            <?php submit_button('Save Settings'); ?>
   		            <div class="loading"></div>	   		            
   					</div>	 
   					<div id="saveResult"></div>
                  <script type="text/javascript">
                  jQuery(document).ready(function() {
                     jQuery('#usp_OptionsForm input[type=submit]').removeClass('button-primary');
                     jQuery('#usp_OptionsForm').submit(function() { 
                        jQuery('.submit-usp_OptionsForm .loading').fadeIn();
                        jQuery(this).ajaxSubmit({
                           success: function(){
                              jQuery('.submit-usp_OptionsForm .loading').fadeOut(250, function(){
                                 window.location.reload();
                              });
                           },
                           error: function(){
                              alert("<?php _e('Sorry, settings could not be saved.', USP_NAME); ?>");
                           }
                        }); 
                        return false; 
                     });
                  });
                  </script>       
      			</form>	
		      </div>
				<?php include( plugin_dir_path( __FILE__ ) . 'includes/cta/resources.php');	?>
				<?php include( plugin_dir_path( __FILE__ ) . 'includes/cta/about.php');	?>
		   </div>		   	
		</div>
	</div>
<?php
}





/*
*  usp_upload_image
*  Upload Image Ajax Function
*
*  @since 1.0
*/


function usp_upload_image(){

   error_reporting(E_ALL|E_STRICT);
   
	$nonce = $_POST["nonce"];
	// Check our nonce, if they don't match then bounce!
	if (! wp_verify_nonce( $nonce, 'usp_nonce' ))
		die('Get Bounced!');
	
	
   // Make tmp directory to temporarily store images
   $dir = USP_PATH.'admin/tmp';
   if(!is_dir($dir)){
     mkdir($dir);
   }
   
   
   // Is directory writeable
   if (!is_writable(USP_PATH.'admin/tmp/')) {
       echo __('Unable to save image, check your server permissions.', USP_NAME);
   }
   
	
	// Get image variables
	$img = Trim(stripslashes($_POST["image"])); // Image url
	$desc = Trim(stripslashes($_POST["description"])); // image description
	$tmp_path = USP_PATH.'admin/tmp/';	// Temp image path
	$upload_path = USP_ADMIN_URL.'tmp/'; // Full url path for image upload
	
	
	// Create temp. image variable
   $tmp = 'image-'. rand() .'.jpg';
   $tmp_img = $tmp_path .''.$tmp;   
   
   
   // Generate temp. image 
   
   //$content = file_get_contents($img);
   // Lets use cURL
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $img);
   curl_setopt($ch, CURLOPT_HEADER, 0);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
   $picture = curl_exec($ch);
   curl_close($ch);
   
   $saved_file = file_put_contents($tmp_img, $picture);   
   
   // Set default return value
   $json = json_encode( 
   	array(
   		'error' => true,
   		'msg' => __('Unable to save image, check your server permissions.', USP_NAME)
		)
   );
   
    // Was the temporary image able to be saved?
   if ($saved_file) {   
      
      // Upload generated file to media library using media_sideload_image()
      $file = media_sideload_image($upload_path.''.$tmp, 0, $desc);
     
      // Success JSON      
      //echo __('File successfully uploaded to media library.', USP_NAME); 
      $json = json_encode( 
      	array(
      		'error' => false,
      		'msg' => __('File successfully uploaded to media library.', USP_NAME)
   		)
      );
            
      // Delete the file we just uplaoded from the tmp dir.
      if(file_exists($tmp_path.''.$tmp)){
          unlink($tmp_path.''.$tmp);
      }else{
         echo __('Nothing to delete, file does not exist', USP_NAME);
      }           
   }
	
	echo $json;
	die();
}








/*
*  usp_admin_init()
*  Initiate the plugin, create our setting variables.
*
*  @since 1.0
*/

add_action( 'admin_init', 'usp_admin_init');
function usp_admin_init(){
	register_setting( 
		'usp-setting-group', 
		'usp_settings', 
		'usp_sanitize_settings' 
	);
	
	add_settings_section( 
		'usp_general_settings',  
		'Plugin Settings', 
		'usp_general_settings_callback', 
		'unsplash' 
	);	
	
	// Download Width
	add_settings_field( 
		'_usp_dw', 
		__('Set Upload Image Width', USP_NAME ), 
		'usp_dw_callback', 
		'unsplash', 
		'usp_general_settings' 
	);	
	
	// Download Height
	add_settings_field( 
		'_usp_dh', 
		__('Set Upload Image Height', USP_NAME ), 
		'usp_dh_callback', 
		'unsplash', 
		'usp_general_settings' 
	);	
	
	// Images per page
	add_settings_field( 
		'_usp_pp', 
		__('Images Per Page', USP_NAME ), 
		'usp_pp_callback', 
		'unsplash', 
		'usp_general_settings' 
	);	
}



/*
*  usp_general_settings_callback
*  Some general settings text
*
*  @since 1.0
*/

function usp_general_settings_callback() {
    //echo '<p>' . __('Customize your file download', USP_NAME) . '</p>';
}


/*
*  usp_sanitize_settings
*  Sanitize our form fields
*
*  @since 1.0
*/

function usp_sanitize_settings( $input ) {
    return $input;
}


/*
*  _usp_dw_callback
*  File download width
*
*  @since 1.0
*/

function usp_dw_callback(){
	$options = get_option( 'usp_settings' );
	
	if(!isset($options['_usp_dw'])) 
	   $options['_usp_dw'] = '1600';
		
	echo '<label for="usp_settings[_usp_dw]">'.__('Width:', USP_NAME).'</label><input type="number" id="usp_settings[_usp_dw]" name="usp_settings[_usp_dw]" value="'.$options['_usp_dw'].'" class="sm" step="20" max="3200" /> ';	
}



/*
*  _usp_dh_callback
*  File download height
*
*  @since 1.0
*/

function usp_dh_callback(){
	$options = get_option( 'usp_settings' );
	
	if(!isset($options['_usp_dh'])) 
	   $options['_usp_dh'] = '900';
		
	echo '<label for="usp_settings[_usp_dh]">'.__('Height:', USP_NAME).'</label><input type="number" id="usp_settings[_usp_dh]" name="usp_settings[_usp_dh]" value="'.$options['_usp_dh'].'" class="sm" step="20" max="3200" /> ';	
}



/*
*  usp_pp_callback
*  # of images / page
*
*  @since 1.0
*/

function usp_pp_callback(){
	$options = get_option( 'usp_settings' );
	
	if(!isset($options['_usp_pp'])) 
	   $options['_usp_pp'] = '20';
		
	echo '<label for="usp_settings[_usp_pp]">'.__('# Per Page:', USP_NAME).'</label><input type="number" id="usp_settings[_usp_pp]" name="usp_settings[_usp_pp]" value="'.$options['_usp_pp'].'" class="sm" step="5" max="60" /> ';	
}


