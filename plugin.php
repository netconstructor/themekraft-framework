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
	$args['jqueryui_components'] = array( 'jquery-fileuploader', 'jquery-ui-tabs', 'jquery-ui-accordion', 'jquery-colorpicker' );
	$args['option_groups'] = array( 'test_options', 'test_form' );	// Adding option groups for forms
	tk_framework( $args );	// Initializing framework
}
add_action( 'init', 'tk_init' );

function tk_framework_test_functions(){
	
	echo "<h2>Framework test functions</h2>";

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
	echo tk_tabs( 'mytabs', $content );
	
	echo "<h3>Accordion</h3>";
	/*
	* Creating accordion
	*/
	echo tk_accordion( 'myaccordion', $content );
	
		
	echo "<h3>Forms & Fields</h3>";
	
	/*
	* Creating a form
	*/
	
	tk_form_start( 'test_options' ); // Starting form
	
	// Textfield
	echo tk_form_textfield( 'test_textfeld' ) . '<br />'; 
	
	// Textarea
	echo tk_form_textarea( 'test_textarea' ) . '<br />'; 
	
	// Checkbox
	echo tk_form_checkbox( 'test_checkbox' ) . '<br />';
	
	// Colorpicker
	echo tk_form_colorpicker( 'test_colorpicker' ) . '<br />'; 
	
	// Fileuploader
	echo tk_form_fileuploader( 'test_fileuploader' ) . '<br />'; 
	
	// Select box
	$options = array( 'Eins', 'Zwei', 'Drei' );
	echo tk_form_select( 'test_select', $options ) . '<br />';
	
	// Radiobuttons
	echo tk_form_radiobutton( 'test_radiobutton', '1' );
	
	echo tk_form_radiobutton( 'test_radiobutton', '2' );
	
	/*
	 * If you want to add values to your selectbox try this
	 * 
	 $options = array( array( 'name' => 'Eins', 'value' => '1') , array( 'name' => 'Zwei', 'value' => '2'), array( 'name' => 'Drei', 'value' => '3') );
	 echo tk_form_select( 'test_select', $options );
	 */
	
	// Button
	echo tk_form_button( 'Send' ); // Adding button
	
	tk_form_end(); // End form
	
	/*

	 * 
	tk_form_start( 'test_options' );
	
	$html = tk_form_textfield( 'test_textfeld' );
	$html.= tk_form_button( 'Send' );
	tk_form_content($html); // Putting your content
	 
	tk_form_end();
	 
	 */
}

function init_framework(){
	/*
	$args = array(
			'menu_title' => 'Test TKF',
			'page_title' => 'Titel der Seite',
			'menu_slug' => 'testtkf',
			'object_menu' => TRUE
		);
	$tka = new TK_Admin_Pages( $args );
	
	$tka->add_page( 'Menu 1', 'Page title of Menu 1', 'Content in menu 1' );
	$tka->add_page( 'Menu 2', 'Page title of Menu 2', 'Content in menu 2' );
	$tka->add_page( 'Menu 3', 'Page title of Menu 3', 'Content in menu 3' );
	
	$tka->get_html();
	 */
	
	$wml = new TK_WML_Parser();	
	/*
	 * XML
	 */
	$xml = '<?xml version="1.0" ?>
				<wml>
					<menu title="Menueintrag" icon="http://seopress.themekraft.com/wp-content/plugins/seopress/includes/images/icon-seopress-16x16.png">
						<page title="Icon und Überschrift" icon="http://www.veryicon.com/icon/preview/Phone/iPhone%20icon/iPhone%2032x32%20Icon.jpg" headline="Mit Icon und Überschrift">
							Ein Test, wo ich nicht weis was passiert.
						</page>
						<page title="Tabs drin!">
							<tabs>
								<tab title="Eins">Der erste Tab</tab>
								<tab title="Zwei">Und schon wieder einer</tab>
								<tab title="Drei">Alle guten Dinge sind ...</tab>
							</tabs>
						</page>
						<page title="Third entry">
							Here you can find the content of menu entry three.
						</page>
						<page title="Fourth entry">
							Place any content.
						</page>
					</menu>
				</wml>';								
	
	$wml->load_xml( $xml );
	echo $wml->get_html();
}
add_action( 'admin_menu', 'init_framework' );

function tk_framework_test_wpml_parser(){
	echo "<h2>Framework test functions</h2>";
	
	$wml = new TK_WML_Parser();	
	
	/*
	 * XML
	 */
	$xml = '<?xml version="1.0" ?>
				<wml>
					<form name="test_form">
						<tabs>
							<tab title="One">
								
								Showing all fields:
								
								<textfield name="name" label="First name" tooltip="Your first name" />
								<textfield name="surname" label="Last name" tooltip="Your last name" />
								<colorpicker name="colorforme" label="Color" tooltip="Select a colour" />
								<textarea name="longtext" label="Textarea" tooltip="Here you can put in a much of text" />
								<file name="ourfile" label="File" tooltip="Upload your file!" />
								<checkbox name="mycheckbox" label="Check this" tooltip="Check the checkbox!" />
								
								<select name="myselect" label="Select box" tooltip="Some entries in a dropdown">
									<option name="First entry" value="first" />
									<option name="Second entry" value="second" />
									<option name="Third entry" value="third" />
									<option name="Fourth entry" value="fourth" />
								</select>
								
								<radio name="radiotest" label="Radio test" value="1" description="Button 1" />
								<radio name="radiotest" value="2" description="Button 2" />
								<radio name="radiotest" value="3" description="Button 3" />
								
								<button name="Save" />
								
							</tab>
							<tab title="Two">
								<accordion id="theaccordion">
									<section id="firstsection" title="First Section">
										This is the first section with content.
									</section>
									<section id="secondsection" title="Second Section">
										<textarea name="styles" label="Stylesheets" tooltip="Put in your stylesheets!" />
										<button name="Save" />									
									</section>
								</accordion>
								
							</tab>
							<tab title="three">
								An accordion without id´s
								<accordion>
									<section title="See">As you can see it works</section>
								</accordion>								
							</tab>
						</tabs>
						
					</form>
				</wml>';											
	
	$wml->load_xml( $xml );
	echo $wml->get_html();
	
	echo '<pre>';
	print_r( tk_get_values( 'test_form' ) );
	echo '</pre>';
}

// Just for showing menue for test site
function tkf_menue(){
	add_menu_page( 'TK Framework' , 'TK Framework' , 'manage_options', 'tk_framework','tk_framework' );
	add_submenu_page( 'tk_framework', __( 'Framework test', 'tk_framework'),__( 'Functions', 'tk_framework' ), 'manage_options', 'tk_framework_test', 'tk_framework_test_functions' );
	add_submenu_page( 'tk_framework', __( 'Framework test', 'tk_framework'),__( 'Display Builder', 'tk_framework' ), 'manage_options', 'tk_framework_test_display_builder', 'tk_framework_test_wpml_parser' );
}
add_action( 'admin_menu', 'tkf_menue');