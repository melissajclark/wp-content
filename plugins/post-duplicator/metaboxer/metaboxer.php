<?php
/**
 * Put all the Metaboxer admin function here fields here
 *
 * @package  Post Duplicator
 * @author   Metaphor Creations
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 */



/**
 * Create a field container and switch.
 *
 * @since 1.0.0
 */
function mtphr_post_duplicator_metaboxer_container( $field, $context ) {

	global $post;

	$default = isset( $field['default'] ) ? $field['default'] : '';
	$value = ( get_post_meta( $post->ID, $field['id'], true ) != '' ) ? get_post_meta( $post->ID, $field['id'], true ) : $default;
	$display = isset( $field['display'] ) ? $field['display'] : '';
	?>
	<tr class="mtphr-post-duplicator-metaboxer-field mtphr-post-duplicator-metaboxer-field-<?php echo $field['type']; ?> mtphr-post-duplicator-metaboxer<?php echo $field['id']; ?><?php if( isset($field['class']) ) { echo ' '.$field['class']; } ?> clearfix">	
		
		<?php
		$content_class = 'mtphr-post-duplicator-metaboxer-field-content mtphr-post-duplicator-metaboxer-field-content-full mtphr-post-duplicator-metaboxer-'.$field['type'].' clearfix';
		$content_span = ' colspan="2"';
		$label = false;
		
		if ( isset($field['name']) || isset($field['description']) ) {
		
			$content_class = 'mtphr-post-duplicator-metaboxer-field-content mtphr-post-duplicator-metaboxer-'.$field['type'].' clearfix';
			$content_span = '';
			$label = true;
			?>

			<?php if( $context == 'side' || $display == 'vertical' ) { ?><td><table><tr><?php } ?>
			
			<td class="mtphr-post-duplicator-metaboxer-label">
				<?php if( isset($field['name']) ) { ?><label for="<?php echo $field['id']; ?>"><?php echo $field['name']; ?></label><?php } ?>
				<?php if( isset($field['description']) ) { ?><small><?php echo $field['description']; ?></small><?php } ?>
			</td>
			
			<?php if( $context == 'side' || $display == 'vertical' ) { echo '</tr>'; } ?>

			<?php
		}
		?>
		
		<?php if( $label ) { if( $context == 'side' || $display == 'vertical' ) { echo '<tr>'; } } ?>
		
		<td<?php echo $content_span; ?> class="<?php echo $content_class; ?>" id="<?php echo $post->ID; ?>">
			<?php
			// Call the function to display the field
			if ( function_exists('mtphr_post_duplicator_metaboxer_'.$field['type']) ) {
				call_user_func( 'mtphr_post_duplicator_metaboxer_'.$field['type'], $field, $value );
			}
			?>
		</td>
		
		<?php if( $label ) { if( $context == 'side' || $display == 'vertical' ) { echo '</tr></table></td>'; } } ?>
		
	</tr>
	<?php
}




/**
 * Append fields
 *
 * @since 1.0.0
 */
function mtphr_post_duplicator_metaboxer_append_field( $field ) {

	// Add appended fields
	if( isset($field['append']) ) {
		
		$fields = $field['append'];
		$settings = ( isset($field['option'] ) ) ? $field['option'] : false;

		if( is_array($fields) ) {
		
			foreach( $fields as $id => $field ) {
				
				// Get the value
				if( $settings) {
					$options = get_option( $settings );
					$value = isset( $options[$id] ) ? $options[$id] : get_option( $id );	
				} else {
					global $post;
					$value = get_post_meta( $post->ID, $id, true );
				}
				
				// Set the default if no value
				if( $value == '' && isset($field['default']) ) {
					$value = $field['default'];
				}
	
				if( isset($field['type']) ) {
		
					if( $settings ) {
						$field['id'] = $settings.'['.$id.']';
						$field['option'] = $settings;
					} else {
						$field['id'] = $id;
					}
	
					// Call the function to display the field
					if ( function_exists('mtphr_post_duplicator_metaboxer_'.$field['type']) ) {
						echo '<div class="mtphr-post-duplicator-metaboxer-appended mtphr-post-duplicator-metaboxer'.$field['id'].'">';
						call_user_func( 'mtphr_post_duplicator_metaboxer_'.$field['type'], $field, $value );
						echo '</div>';
					}
				}
			}
		}
	}
}



/**
 * Renders a select field.
 *
 * @since 1.0.0
 */
function mtphr_post_duplicator_metaboxer_select( $field, $value='' ) {

	$before = ( isset($field['before']) ) ? '<span>'.$field['before'].' </span>' : '';
	$after = ( isset($field['after']) ) ? '<span> '.$field['after'].'</span>' : '';
	
	$output = $before.'<select name="'.$field['id'].'" id="'.$field['id'].'">';
	
  if( $field['options'] ) {
  
  	$key_val = isset( $field['key_val'] ) ? true : false;
  	
	  foreach ( $field['options'] as $key => $option ) {
	  	if( is_numeric($key) && !$key_val ) {
				$name = ( is_array( $option ) ) ? $option['name'] : $option;
				$val = ( is_array( $option ) ) ? $option['value'] : $option;
			} else {
				$name = $option;
				$val = $key;
			}
			$selected = ( $val == $value ) ? 'selected="selected"' : '';
			$output .= '<option value="'.$val.'" '.$selected.'>'.stripslashes( $name ).'</option>';
		}
	}
  $output .= '</select>'.$after;

	echo $output;
	
	// Add appended fields
	mtphr_post_duplicator_metaboxer_append_field($field);
}



/**
 * Renders a radio custom field.
 *
 * @since 1.0.0
 */
function mtphr_post_duplicator_metaboxer_radio( $field, $value='' ) {
	
	if( isset($field['options']) ) {

		$output = '';
		$break = '<br/>';
		if ( isset($field['display']) ) {
			if( $field['display'] == 'inline' ) {
				$break = '&nbsp;&nbsp;&nbsp;&nbsp;';
			}
		}
		foreach( $field['options'] as $i => $option ) {
			$checked = ( $value == $i ) ? 'checked="checked"' : '';
			$output .= '<label><input name="'.$field['id'].'" id="'.$field['id'].'" type="radio" value="'.$i.'" '.$checked.' /> '.$option.'</label>'.$break;
		}	
	}
	
	echo $output;
	
	// Add appended fields
	mtphr_post_duplicator_metaboxer_append_field($field);
}



/**
 * Renders a checkbox.
 *
 * @since 1.0.0
 */
function mtphr_post_duplicator_metaboxer_checkbox( $field, $value='' ) {

	$output = '';
	$before = ( isset($field['before']) ) ? '<span>'.$field['before'].' </span>' : '';
	$after = ( isset($field['after']) ) ? '<span> '.$field['after'].'</span>' : '';

	if( isset($field['options']) ) {
	
		$break = '<br/>';
		if ( isset($field['display']) ) {
			if( $field['display'] == 'inline' ) {
				$break = '&nbsp;&nbsp;&nbsp;&nbsp;';
			}
		}
		foreach( $field['options'] as $i => $option ) {
			$checked = ( isset($value[$i]) ) ? 'checked="checked"' : '';
			$output .= '<label><input name="'.$field['id'].'['.$i.']" id="'.$field['id'].'['.$i.']" type="checkbox" value="1" '.$checked.' /> '.$option.'</label>'.$break;
		}
		
	} else {
		
		$checked = ( $value == 1 ) ? 'checked="checked"' : '';
		$output .= '<label><input name="'.$field['id'].'" id="'.$field['id'].'" type="checkbox" value="1" '.$checked.' />';
		if( isset($field['label']) ) {
			$output .= ' '.$field['label'];
		}	
		$output .= '</label>';
	}
	
	echo $before.$output.$after;
	
	// Add appended fields
	mtphr_post_duplicator_metaboxer_append_field($field);
}



/**
 * Renders an text field.
 *
 * @since 1.0.1
 */
function mtphr_post_duplicator_metaboxer_text( $field, $value='' ) {
	$size = ( isset($field['size']) ) ? $field['size'] : 40;
	$before = ( isset($field['before']) ) ? '<span>'.$field['before'].' </span>' : '';
	$after = ( isset($field['after']) ) ? '<span> '.$field['after'].'</span>' : '';
	$text_align = ( isset($field['text_align']) ) ? ' style="text-align:'.$field['text_align'].'"' : '' ;
	$output = $before.'<input name="'.$field['id'].'" id="'.$field['id'].'" type="text" value="'.$value.'" size="'.$size.'"'.$text_align.'>'.$after;
	echo $output;
	
	// Add appended fields
	mtphr_post_duplicator_metaboxer_append_field($field);
}



/**
 * Renders a textarea.
 *
 * @since 1.0.0
 */
function mtphr_post_duplicator_metaboxer_textarea( $field, $value='' ) {
	$rows = ( isset($field['rows']) ) ? $field['rows'] : 5;
	$cols = ( isset($field['cols']) ) ? $field['cols'] : 40;
	$output = '<textarea name="'.$field['id'].'" id="'.$field['id'].'" rows="'.$rows.'" cols="'.$cols.'">'.$value.'</textarea>';
	echo $output;
	
	// Add appended fields
	mtphr_post_duplicator_metaboxer_append_field($field);
}



/**
 * Renders an number field.
 *
 * @since 1.0.0
 */
function mtphr_post_duplicator_metaboxer_number( $field, $value='' ) {
	$style = ( isset($field['style']) ) ? ' style="'.$field['style'].'"' : '';
	$before = ( isset($field['before']) ) ? '<span>'.$field['before'].' </span>' : '';
	$after = ( isset($field['after']) ) ? '<span> '.$field['after'].'</span>' : '';
	$output = $before.'<input name="'.$field['id'].'" id="'.$field['id'].'" type="number" value="'.$value.'" class="small-text"'.$style.'>'.$after;
	echo $output;
	
	// Add appended fields
	mtphr_post_duplicator_metaboxer_append_field($field);
}



