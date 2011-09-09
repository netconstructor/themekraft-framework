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
	
	// Include the loader script
	require_once( 'loader.php' );
	
	// Adding all needed jquery scripts
	tk_framework( array( 'jquery-ui-tabs', 'jquery-ui-accordion' ) );
	
	/*
	* Adding test option group for form fields
	*/
	
}
add_action( 'init', 'tk_init' );

function tk_test_option_group(){
	tk_register_wp_option_group( 'test_options' );
}
add_action( 'admin_init', 'tk_test_option_group' );

function tk_framework_test(){
	
	echo "<h2>Framework test page</h2>";

	// Content array which fillls elements
	$content[] = array(
		'id' => 1,
		'title' => 'Title 1',
		'content' => 'Content in area 1'
	);
	$content[] = array(
		'id' => 2,
		'title' => 'Title 2',
		'content' => 'Content in area 2'
	);

	echo "<h3>Tabs</h3>";
	/*
	* Creating tabs
	*/
	echo tk_jqueryui_tabs( 'mytabs', $content );
	
	echo "<h3>Accordion</h3>";
	/*
	* Creating accordion
	*/
	echo tk_jquery_accordion( 'myaccordion', $content );
	
		
	echo "<h3>Forms & Fields</h3>";
	/*
	* Creating a form
	*/
	$form = new TK_WP_Form( 'test_options', 'myform' );
	$form->add_element( tk_wp_form_textfield( 'test_textfeld', 'test_options' ) . tk_form_button( array( 'value' => 'Send') ) );
	$form->write_html();
}

// Just for showing menue for test site
function tkf_menue(){
	add_menu_page( 'TK Framework' , 'TK Framework' , 'manage_options', 'tk_framework','tk_framework' );
	add_submenu_page( 'tk_framework', __( 'Framework test', 'tk_framework'),__( 'Test functions', 'tk_framework' ), 'manage_options', 'tk_framework_test', 'tk_framework_test' );
}
add_action( 'admin_menu', 'tkf_menue');

?>