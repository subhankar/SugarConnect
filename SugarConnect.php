<?php
/*
Plugin Name: SugarConnect
Plugin URI: http://yourdomain.com/
Description: SugarCRM Plugin for Wordpress. This plugin displays sugarcrm extra contact information in User profile page
Version: 1.0
Author: subhankar
Author URI: http://yourdomain.com
License: GPL
*/

//add_action('init','SugarConnect');
require_once('sugarConnectUtils.php');
require_once('init.php');

register_activation_hook(__FILE__,'install_table');
register_activation_hook(__FILE__,'insertData');
register_deactivation_hook( __FILE__,'uninstall_table');

add_action('admin_menu', 'wp_sugar_plugin_menu');

function wp_sugar_plugin_menu() {
	$capability = 'level_0';
	$icon_url = '/wp-content/plugins/SugarConnect/images/sugar_icon.png';
    add_menu_page('SugarCRM plugin for Wordpress', 'SugarConnect', $capability, 'SugarConnect', 'sugar_config');
}

function sugar_config() {
	include('sugarSetting.php');
}
?>