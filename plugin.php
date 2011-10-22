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

function tk_framework_test_display_builder(){
	echo "<h2>Framework test functions</h2>";
	
	$tkdb = new TK_Display_builder();	
	
	/*
	 * XML
	 */
	$string = '<?xml version="1.0" ?>
				<tkfxml>
					<form id="my_test_form" name="test_form">
						<tabs>
							<tab title="One">
								<textfield name="name" label="Vorname" tooltip="Ihr Vorname" />
								<textfield name="surname" label="Nachname" tooltip="Ihr Nachname" />
								<colorpicker name="colorforme" label="Farbe" tooltip="Wählen Sie eine Farbe mit dem Farbwähler" />
								<textarea name="longtext" label="Textarea" tooltip="Hier können Sie viel Text eingeben" />
								<file name="ourfile" label="File" tooltip="Hier können Sie eine Datei hochladen" />
								<checkbox name="mycheckbox" label="Check this" tooltip="Check das einfach mal!" />
								<select name="myselect" label="Select this" tooltip="Mehrere Einträge untereinander">
									<option name="First entry" value="first" />
									<option name="Second entry" value="second" />
									<option name="Third entry" value="third" />
									<option name="Fourth entry" value="fourth" />
								</select>
							</tab>
							<tab title="Two">
								<accordion id="theaccordion">
									<section id="firstsection" title="First Section">
										This is the first section with content.
									</section>
									<section id="secondsection" title="Second Section">
										As you can see, two sections are ready as well.
									</section>
									<section title="Third Section" id="thirdsection">									
									</section>				
								</accordion>
							</tab>
							<tab title="three">
								Here have been a form.
							</tab>
						</tabs>
						<button name="Save" />
					</form>
				</tkfxml>';								
	
	$tkdb->load_xml( $string );
	echo $tkdb->get_html();
}

// Just for showing menue for test site
function tkf_menue(){
	add_menu_page( 'TK Framework' , 'TK Framework' , 'manage_options', 'tk_framework','tk_framework' );
	add_submenu_page( 'tk_framework', __( 'Framework test', 'tk_framework'),__( 'Functions', 'tk_framework' ), 'manage_options', 'tk_framework_test', 'tk_framework_test_functions' );
	add_submenu_page( 'tk_framework', __( 'Framework test', 'tk_framework'),__( 'Display Builder', 'tk_framework' ), 'manage_options', 'tk_framework_test_display_builder', 'tk_framework_test_display_builder' );
}
add_action( 'admin_menu', 'tkf_menue');

?>