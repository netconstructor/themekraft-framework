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
	$args['option_groups'] = array( 'form1' );
	 	
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
					<menu title="Framework">
						<page title="Tabs" headline="Tab test">
							You can also put in Text here like in HTML
							<tabs>
								<tab title="Tab 1">
									Content in Tab 1
								</tab>
								<tab title="Tab 2">
									Content in Tab 2
								</tab>
								<tab title="Tab 3">
									Content in Tab 3
								</tab>
							</tabs>					
						</page>
						<page title="Accordions" headline="Accordion test">
							You can also put in Text here like in HTML
							<accordion>
								<section title="Section 1">
									Content in Section 1
								</section>
								<section title="Section 2">
									Content in Section 3
								</section>
								<section title="Section 3">
									Content in Section 3
								</section>
							</accordion>
						</page>
						<page title="Forms" headline="Form test">
							You can also put in Text here like in HTML
							<form name="form1">
								
								<textfield name="name" label="Name:" />
								<textarea name="name" label="Long text:" />
								<checkbox name="mycheckbox" label="Check this:" />
								
								<radio name="radiotest" label="Radio test" value="1" description="Button 1" />								
								<radio name="radiotest" value="2" description="Button 2" />								
								<radio name="radiotest" value="3" description="Button 3" />
								
								<select name="myselect" label="Select box" tooltip="Some entries in a dropdown">									
									<option name="First entry" value="first" />									
									<option name="Second entry" value="second" />									
									<option name="Third entry" value="third" />									
									<option name="Fourth entry" value="fourth" />								
								</select>
								
								<colorpicker name="colorforme" label="Color" tooltip="Select a colour" />
								<file name="ourfile" label="File" tooltip="Upload your file!" />
								
								<button name="Save" />				
							
							</form>
						</page>
					</menu>
				</wml>';
	
	tk_wml_parse( $xml );
	
					
}
add_action( 'admin_menu', 'init_backend' );











// $args['option_groups'] = array( 'form1' );

// print_r( tk_get_values( 'form1' ) );