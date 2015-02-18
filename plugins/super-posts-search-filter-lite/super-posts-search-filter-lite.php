<?php

/*
Plugin Name: Super Posts Search Filter Lite
Plugin URI: http://jultranet.com/wp/
Description: Filter posts based on categories
Author: Vojislav Kovacevic
Version: 1.7.0
Author URI: http://jultranet.com/wp/
*/

$search_text = '';
$default_cat = 'all'; 
$excluded_cats = array(); 
$clean_excluded_cats = array();
$cat_text = '';

add_option('vkssfl_search_text', $search_text);
add_option('vkssfl_default_cat', $default_cat);
add_option('vkssfl_excluded_cats', $excluded_cats);
add_option('vkssfl_clean_excluded_cats', $clean_excluded_cats);
add_option('vkssfl_cat_text', $cat_text);
add_option('vkssfl_cat_style', $cat_style);

function vkssfl_add_config_page() {
	add_options_page( 
		'Super Search Filter Lite Options', 
		'Super Search Filter Lite', 
		'manage_options',
		basename(__FILE__), 
		'vkssfl_config_page'
	);
}
add_action('admin_menu', 'vkssfl_add_config_page');

function vkssfl_config_page() {

	if (isset($_POST['submit'])) {

		$nonce = $_REQUEST['_wpnonce'];
		if (! wp_verify_nonce($nonce, 'vkssflfp-updatesettings' ) ) {
			die('security error');
		}
		if (! current_user_can('manage_options') ) {
				die('you can\'t manage options');
		}
		check_admin_referer('vkssflfp-updatesettings');

		$search_text = $_POST['search-text'];
		$meta_search_key = $_POST['meta_search_key'];
		$default_cat = $_POST['default-cat'];
		$excluded_cats = $_POST['post_category'];
		$fix = (array)$_POST['post_category'];
		array_unshift($fix, '1');
		$clean_excluded_cats = implode(',' , $fix);


		$cat_text = $_POST['cat-text'];


		if ($_POST['cat_style'] == 'checkbox') {
			$cat_style = 'checkbox';
		} elseif ($_POST['cat_style'] == 'dropdown') {
			$cat_style = 'dropdown';
		} else if ($_POST['cat_style'] == 'none') {
			$cat_style = 'none';
		} else {
			$cat_style = 'none';
		}

		update_option('vkssfl_search_text', $search_text);
		update_option('vkssfl_default_cat', $default_cat);
		update_option('vkssfl_excluded_cats', $excluded_cats);
		update_option('vkssfl_clean_excluded_cats', $clean_excluded_cats);
		update_option('vkssfl_cat_text', $cat_text);
		update_option('vkssfl_cat_style', $cat_style);	

	} 

	$search_text = get_option('vkssfl_search_text');
	$default_cat = get_option('vkssfl_default_cat');
	$excluded_cats = get_option('vkssfl_excluded_cats');
	$clean_excluded_cats = get_option('vkssfl_clean_excluded_cats');
	$cat_text = get_option('vkssfl_cat_text');
	$cat_style = get_option('vkssfl_cat_style');
	
	?>

	<style>
	div.pro {
	  background: none repeat scroll 0 0 white;
	  padding: 10px;
	  position: absolute;
	  right: 0;
	  top: 0;
	  width: 470px;
	}

	</style>

	<div class="wrap">
		<h2>Super Search Filter LITE options</h2>

		<form action="" method="post" id="sbc-config">

			<table class="form-table">
			<?php wp_nonce_field('vkssflfp-updatesettings'); ?>

			<tr>
				<td>
					<div class="pro">
						<p>For more filtering options (custom taxonomies, meta boxes and many more options) check out <br><b>Super Search Search Filter PRO<br></b> - the complete wordpress posts and custom posts filter -><br>
						 <a href="http://jultranet.com/wp/" target="_blank">MORE INFO</a> | <a href="http://jultranet.com/wp/ssf-pro/" target="_blank">DEMO</a> | <a href="https://www.youtube.com/watch?v=vzelJTcx1rk" target="_blank">VIDEO PRESENTATION</a></p>
					</div>
				</td>
			</tr>

			<tr>
				<th scope="row" valign="top">
				<label for="search-text">
					Display text inside the search box:
				</label>
				</th>
				<td>
					<input type="text" name="search-text" id="search-text" class="regular-text" value="<?php echo $search_text; ?>">
				</td>
			</tr>

			<tr>
				<th scope="row" valign="top">
				<label for="search-text">
					Display categories as:
				</label>
				</th>
				<td>
					<?php $gcs = get_option('vkssfl_cat_style'); ?>
					<input type="radio" name="cat_style" id="cb" value="checkbox" <?php if ($gcs == 'checkbox') echo 'checked="checked"'; ?>>
					<label for="cb">Checkbox</label> 
					<input type="radio" name="cat_style" id="dd" value="dropdown" <?php if ($gcs == 'dropdown') echo 'checked="checked"'; ?>>
					<label for="dd">Dropdown</label> 
					<input type="radio" name="cat_style" id="none" value="none" <?php if ($gcs != 'dropdown' && $gcs != 'checkbox') echo 'checked="checked"'; ?>>
					<label for="none">None</label> 
				</td>
			</tr>

			<tr>
				<th scope="row" valign="top">
				<label for="search-text">
					Search categories text:
				</label>
				</th>
				<td>
					<input type="text" name="cat-text" id="search-text" class="regular-text" value="<?php echo $cat_text; ?>">
				</td>
			</tr>

			

			<tr>
				<th scope="row" valign="top">
				<label for="default-cat">
					Display text to choose all categories:
				</label>
				</th>
				<td>
					<input type="text" name="default-cat" id="default-cat" class="regular-text" value="<?php echo $default_cat; ?>">
				</td>
			</tr>

			<tr>
				<th>
				<label for="focus">Categories to exclude:</label>
				</th>
				<td><ul><?php wp_category_checklist(0,0,$excluded_cats); ?></ul></td>
			</tr>

			</table>

			<p class="submit"><input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit"></p>

			</form>
		</div>
	<?php
} 

function vkssfl_form() {

	$search_text = get_option('vkssfl_search_text');
	$default_cat = get_option('vkssfl_default_cat');
	$excluded_cats = get_option('vkssfl_excluded_cats');
	$clean_excluded_cats = get_option('vkssfl_clean_excluded_cats');

	$settings = array(
	'show_option_all'    => $default_cat,
	'show_option_none'   => '',
	'orderby'            => 'id', 
	'order'              => 'ASC',
	'show_count'         => 0,
	'hide_empty'         => 0, 
	'child_of'           => 0,
	'exclude'            => "'".$clean_excluded_cats."'",
	'echo'               => 0,
	'selected'           => 0,
	'hierarchical'       => 0, 
	'name'               => 'cat',
	'id'                 => '',
	'class'              => 'postform',
	'depth'              => 0,
	'tab_index'          => 0,
	'taxonomy'           => 'category',
	'hide_if_empty'      => false,
    'walker'             => ''
	); 

	$list = wp_dropdown_categories($settings);

	$blog_url = get_bloginfo('url');

	ob_start();
	?>
	<div id="vkssfl">
	<form method="get" action="<?php echo $blog_url; ?>" id="vkssfl-search" name="vkssflfp-config">
		<input type="text" value="<?php echo $search_text; ?>" name="s" id="s" />
		<?php $cat_title = get_option('vkssfl_cat_text'); ?>
		<?php echo '<div>'; ?>
		<?php if (!empty($cat_title)) echo "<h4>$cat_title</h4>"; ?>
		<?php

		$args = array(
				'exclude' => $excluded_cats,
				'orderby' => 'id',
				'order' => 'ASC'
			); 
		$t = get_categories($args);

		$cat_style = get_option('vkssfl_cat_style');;
		if ($cat_style == 'checkbox') {
			foreach ($t as $v) {
			echo "<p><input type=\"checkbox\" name=\"get_cb[]\" value=\"$v->cat_ID\" id=\"$v->name\" /><label for=\"$v->name\"> $v->name</label></p>";
			}
		} elseif ($cat_style == 'dropdown') {
		echo $list;
		}
		echo '</div>';
		?>
		<p class="ssbtn"><button>Submit</button></p>
	</form>
	</div>
	<?php
	return ob_get_clean();

} 

function vkssfl_super_search($query) {
	
	if (isset($_GET['s'])) {

		$excluded_cats = get_option('vkssfl_excluded_cats');

	    $s = filter_input(INPUT_GET, 's', FILTER_SANITIZE_STRING);

	    $query->is_search = true;
	    $query->set( 's', $s );
	    $query->set( 'category__not_in', $excluded_cats );
	    
		if (isset($_GET['get_cb'])) {
			$get_cb = $_GET['get_cb'];
			foreach ($get_cb as $value) {
				$cbid .= ','.$value;
			}
			$cbid = ltrim($cbid, ',');
			$new_cbid = explode(',', $cbid);
		}
	    if (isset($_GET['get_cb'])) {
	    	$query->set( 'category__in', $new_cbid );
		}


	}

} 
add_action('pre_get_posts', 'vkssfl_super_search');

add_shortcode('vkssfl', 'vkssfl_form');
add_filter('widget_text', 'do_shortcode');

?>