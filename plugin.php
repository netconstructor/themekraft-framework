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
	
	/**
	 * Starting the framework
	 */
	require_once( 'loader.php' ); // Get the loader script 
	tk_framework( $args );	// Initializing framework
}
add_action( 'init', 'tk_init' );

function init_backend(){		
	/*
	 * XML
	 */
	$xml = '<?xml version="1.0" ?>
				<wml>
					<menu title="Svens Plugin">
						<page title="Eintrag 1">
							<form name="form1">
								<textfield name="firstname" />
								<button name="Save" />
							</form>
						</page>
						<page title="Eintrag 2">
							Der Inhalt von Eintrag 2.
						</page>
					</menu>
				</wml>';
	
	tk_wml_parse( $xml );
	
					
}
add_action( 'admin_menu', 'init_backend' );











// $args['option_groups'] = array( 'form1' );

// print_r( tk_get_values( 'form1' ) );