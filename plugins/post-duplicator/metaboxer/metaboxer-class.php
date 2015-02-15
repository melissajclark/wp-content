<?php
/**
 * This is where the metabox magic happens.
 *
 * @package Ditty News Ticker
 * @author   Metaphor Creations
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.metaphorcreations.com/plugins/metatools
 **/
 
/* Version 1.1 - 10/18/2012 */
 
 
 
 
/**
 * Create the metabox class
 *
 * @since 1.0.0
 */
if( !class_exists('MTPHR_POST_DUPLICATOR_MetaBoxer') ) {

	class MTPHR_POST_DUPLICATOR_MetaBoxer {
	
	  public function __construct( $meta_box ) {
	
	  	if ( !is_admin() ) return;
	  	
	  	// Save the meta box data
	  	$this->mb = $meta_box;
	  	$this->mb_fields = &$this->mb['fields'];
		
	    add_action( 'add_meta_boxes', array(&$this, 'mtphr_post_duplicator_metaboxer_add') );
	    add_action( 'save_post', array(&$this, 'mtphr_post_duplicator_metaboxer_save') );
	  }
	
	
	
	
		/**
		 * Create the metaboxes
		 *
		 * @since 1.0.0
		 */
		public function mtphr_post_duplicator_metaboxer_add() {
		
			foreach ( $this->mb['page'] as $page ) {
		    add_meta_box( $this->mb['id'], $this->mb['title'], array(&$this, 'mtphr_post_duplicator_metaboxer_render_content'), $page, $this->mb['context'], $this->mb['priority'] );
	  	}
		}
	
	
	
	
		/**
		 * Render the metabox content
		 *
		 * @since 1.0.0
		 */
	  public function mtphr_post_duplicator_metaboxer_render_content() {
	  	?>
	  	<table style="width:100%;" class="mtphr-post-duplicator-metaboxer-admin-fields wrap">
	      <?php 
	      foreach( $this->mb_fields as $field ) {
	
					if ( isset( $field['id'] ) ) {
						// Create a nonce field
						echo'<input type="hidden" name="'.$field['id'].'_noncename"  id="'.$field['id'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
					}
					
					// Output the field
					mtphr_post_duplicator_metaboxer_container( $field, $this->mb['context'] );
				}
				?>
			</table>
			<?php
	  }
	
	
	
	
		/**
		 * Save the field values
		 *
		 * @since 1.0.0
		 */
	  public function mtphr_post_duplicator_metaboxer_save( $post_id ) {
			
			global $post;
			
			foreach( $this->mb_fields as $field ) {
	
				if ( isset($field['id']) ) {
		        	
		    	if ( isset($_POST[$field['id'].'_noncename']) ) {
						
						// Verify the nonce and return if false
						if ( !wp_verify_nonce($_POST[$field['id'].'_noncename'], plugin_basename(__FILE__)) ) {
							return  $post_id;
						}
						
						// Make sure the user can edit pages & posts
						if ( 'page' == $_POST['post_type'] ) {
							if ( !current_user_can('edit_page', $post_id) ) {
								return $post_id;
							}
						} else {
							if ( !current_user_can('edit_post', $post_id) ) {
								return $post_id;
							}
						}
						
						// Store the user data or set as empty string
						$data = ( isset($_POST[$field['id']]) ) ? $_POST[$field['id']] : '';
						
						// Update the meta
						mtphr_post_duplicator_metaboxer_update_meta( $post_id, $field['id'], $field['type'], $data );
						
						// Save appended fields
						mtphr_post_duplicator_metaboxer_save_appended( $post_id, $field );
						
						// Save row fields
						mtphr_post_duplicator_metaboxer_save_rows( $post_id, $field );
					}
				}
			}
		}
	}
	
	/**
	 * Save the row field values
	 *
	 * @since 1.0.0
	 */
  function mtphr_post_duplicator_metaboxer_save_rows( $post_id, $field ) {
  
  	if( isset($field['rows']) ) {
  	
			foreach( $field['rows'] as $id => $row ) {
				
				$row_id = $row['id'];
				
				// Store the user data or set as empty string
				$data = ( isset($_POST[$row_id]) ) ? $_POST[$row_id] : '';
				
				// Update the meta
				mtphr_post_duplicator_metaboxer_update_meta( $post_id, $row_id, $row['type'], $data );
				
				// Save appended fields
				mtphr_post_duplicator_metaboxer_save_appended( $post_id, $row );
			}
		}
  }
		
	/**
	 * Save the appended field values
	 *
	 * @since 1.0.0
	 */
  function mtphr_post_duplicator_metaboxer_save_appended( $post_id, $field ) {

		if( isset($field['append']) ) {
		
			foreach( $field['append'] as $id => $append ) {
				
				// Store the user data or set as empty string
				$data = ( isset($_POST[$id]) ) ? $_POST[$id] : '';
				
				// Update the meta
				mtphr_post_duplicator_metaboxer_update_meta( $post_id, $id, $append['type'], $data );
			}
		}
	}
	
	/**
	 * Update the meta
	 *
	 * @since 1.0.0
	 */
  function mtphr_post_duplicator_metaboxer_update_meta( $post_id, $id, $type, $data ) {
  	
  	// Update the post meta
  	update_post_meta( $post_id, $id, $data );
  }
	
}