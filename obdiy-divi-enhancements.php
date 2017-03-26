<?php

/*
Plugin Name: OBDIY Divi Enhancements
Plugin URI: https://github.com/JasonDodd511/obdiy-divi-enhancements
Description: Plugin to house Divi snippets.
Version: 1.1
Author: Jason Dodd
Author URI: https://cambent.com
License: GPL2
GitHub Plugin URI: https://github.com/JasonDodd511/obdiy-divi-enhancements
GitHub Branch:     master
GitHub Languages:
*/

/**
 * Enable Divi Builder on all post types with an editor box
 **/

function fmpm_add_post_types($post_types) {
	foreach(get_post_types() as $pt) {
		if (!in_array($pt, $post_types) and post_type_supports($pt, 'editor')) {
			$post_types[] = $pt;
		}
	}
	return $post_types;
}
add_filter('et_builder_post_types', 'fmpm_add_post_types');

/* Add Divi Custom Post Settings box */
function fmpm_add_meta_boxes() {
	foreach(get_post_types() as $pt) {
		if (post_type_supports($pt, 'editor') and function_exists('et_single_settings_meta_box')) {
			add_meta_box('et_settings_meta_box', __('Divi Custom Post Settings', 'Divi'), 'et_single_settings_meta_box', $pt, 'side', 'high');
		}
	}
}
add_action('add_meta_boxes', 'fmpm_add_meta_boxes');

/* Ensure Divi Builder appears in correct location */
function fmpm_admin_js() {
	$s = get_current_screen();
	if(!empty($s->post_type) and $s->post_type!='page' and $s->post_type!='post') {
		?>
		<script>
            jQuery(function($){
                $('#et_pb_layout').insertAfter($('#et_pb_main_editor_wrap'));
            });
		</script>
		<style>
			#et_pb_layout { margin-top:20px; margin-bottom:0px }
		</style>
		<?php
	}
}
add_action('admin_head', 'fmpm_admin_js');

/**
 * Make footer sticky
 *
 */

function obdiy_sticky_footer(){

	?>

    <script>// <![CDATA[
        var th = jQuery('#top-header').height(); var hh = jQuery('#main-header').height(); var fh = jQuery('#main-footer').height(); var wh = jQuery(window).height(); var ch = wh - (th + hh + fh); jQuery('#main-content').css('min-height', ch);
        // ]]></script>

<?php }

add_action('wp_footer', 'obdiy_sticky_footer');