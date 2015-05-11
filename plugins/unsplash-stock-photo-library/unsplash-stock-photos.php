<?php
/*
Plugin Name: Unsplash WP
Plugin URI: http://connekthq.com/unsplashwp
Description: One click uploads of unsplash.com stock photos directly to your media library
Author: Darren Cooney
Twitter: @KaptonKaos
Author URI: http://connekthq.com
Version: 1.1
License: GPL
Copyright: Darren Cooney & Connekt Media
*/



define('USP_VERSION', '1.1');
define('USP_TITLE', 'Unsplash WP');

class UnsplashStockPhotos {	
   
   function __construct() {	     
      define('USP_PATH', plugin_dir_path(__FILE__));
		define('USP_ADMIN_URL', plugins_url('admin/', __FILE__));  
		define('USP_NAME', 'unsplash_plugin');
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'add_action_links') );
		
		// load text domain
		load_plugin_textdomain( 'unsplash-stock-photos', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
		
      $this->usp_before_theme();	
	}
	
	/*
	*  usp_before_theme
	*  Load admin files before the theme loads
	*
	*  @since 1.0
	*/
	
	function usp_before_theme(){
		if( is_admin()){
			include_once('admin/admin.php');
		}		
   }   
   
   
   
   /*
	*  add_action_links
	*  Add custom links to plugins.php
	*
	*  @since 1.0
	*/
   function add_action_links ( $links ) {
      $mylinks = array(
         '<a href="' . admin_url( 'options-general.php?page=unsplash' ) . '">Upload Photos</a>',
      );
      return array_merge( $links, $mylinks );
   }
   
}



/*
*  UnsplashStockPhotos
*  The main function responsible for returning the one true AjaxLoadMore Instance to functions everywhere.
*
*  @since 1.0
*/

function UnsplashStockPhotos(){
	global $unsplash_stock_photos;   
	if( !isset($unsplash_stock_photos)){
		$unsplash_stock_photos = new UnsplashStockPhotos();
	}   
	return $unsplash_stock_photos;
}   

// initialize
UnsplashStockPhotos();

