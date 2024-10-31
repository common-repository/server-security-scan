<?php
/*
Plugin Name: Server Security Scan
Plugin URI: 
Description: Server Security Scan identifies possible vulnerabilities and loopholes in your sever by inspecting various PHP configurations and settings, checking write permissions of directories, checking for presence of security modules and by detecting the presence of any unsafe PHP functions. Thus it helps to protect your server from various possible web site hacks such as variable injection, code injection and SQL injection etc.
Version: 1.0.1
Author: wordpressutils
Author URI: 
License: GPLv2 or later
*/

if ( !function_exists( 'add_action' ) )
{
	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
	exit;
}

ob_start();
// error_reporting(E_ALL);

ini_set('max_execution_time',0);
set_time_limit(0);

define('WPU_SSC_PLUGIN_FILE_PATH',__FILE__);
define('WPU_SSC_PLUGIN_FILE_NAME',basename(__FILE__));
define('WPU_SSC_PLUGIN_FOLDER_PATH',dirname(__FILE__));
define('WPU_SSC_PLUGIN_FOLDER_NAME',basename(dirname(__FILE__)));

if ( is_admin() ){

	add_action('admin_menu', 'wpu_ssc_menu');
	wp_enqueue_script('jquery');

	wp_register_style( 'wpu_ssc_style', plugins_url(WPU_SSC_PLUGIN_FOLDER_NAME.'/style.css') );
	wp_enqueue_style( 'wpu_ssc_style' );
}
	
function wpu_ssc_menu(){
	// Add a menu to the Dashboard:
	add_menu_page('Security Check - Analysis', 'Security Check', 'manage_options', 'wpu-ssc-check', 'wpu_ssc_check');//,plugins_url(WPU_SSC_PLUGIN_FOLDER_NAME.'/images/plugin.png'));
	add_submenu_page('wpu-ssc-check', 'Security Check - Analysis', 'Run Checks', 'manage_options', 'wpu-ssc-check' ,'wpu_ssc_check');
	add_submenu_page('wpu-ssc-check', 'Security Check - PHPInfo', 'PHPInfo', 'manage_options', 'wpu-ssc-phpinfo' ,'wpu_ssc_phpinfo');

}

function wpu_ssc_check(){
	require( dirname( __FILE__ ) . '/check.php' );
}

function wpu_ssc_phpinfo()
{
	if(function_exists('phpinfo')) { phpinfo();} else {echo 'phpinfo() disabled'; };
}

?>