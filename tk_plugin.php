<?php 
/*
Plugin Name: Themekraft framework
Plugin URI: http://themekraft.com/plugin/tk-framework
Description: Speed up your wordpress developement with our framework
Author: Sven Wagener, Sven Lehnert
Author URI: http://themekraft.com/
License: GNU GENERAL PUBLIC LICENSE 3.0 http://www.gnu.org/licenses/gpl.txt
Version: 0.1.0
Text Domain: tkframework
Site Wide Only: false
*/

function tk_init(){
	define( 'TK_FRAMEWORK_URL', plugin_dir_url( __FILE__ ) );
	
	require_once( 'tk.php' );
	
	
	// Initializing framework data
	tk_framework();

	// Adding all needed jquery scripts you need in your scripts 
	tk_jqueryui( array( 'jquery-ui-tabs', 'jquery-ui-accordion', 'jquery-ui-autocomplete' ) );
}
add_action( 'init', 'tk_init' );

function tk_framework_test(){
	
	echo "<h2>Framework test page</h2>";

	$content_array = array(
		array(
			'id' => 1,
			'title' => 'Tab 1',
			'content' => 'Content in tab 1'
		),
		array(
			'id' => 2,
			'title' => 'Tab 2',
			'content' => 'Content in tab 2'
		)
	);

	/*
	* Creating tabs
	*/
	echo tk_jqueryui_tabs( $content_array );
	
	
	/*
	* Creating accordion
	*/
	echo tk_wp_jquery_accordion( $content_array );		
}

// Just for showing menue for test site
function tkf_menue(){
	add_menu_page( 'TK Framework' , 'TK Framework' , 'manage_options', 'tk_framework','tk_framework' );
	add_submenu_page( 'tk_framework', __( 'Framework test', 'tk_framework'),__( 'Test functions', 'tk_framework' ), 'manage_options', 'tk_framework_test', 'tk_framework_test' );
}
add_action( 'admin_menu', 'tkf_menue');

?>