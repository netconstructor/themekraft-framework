<?php
	
class tk_framework{
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 */
	function __construct(){
		$this->includes();
	}
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 */
	function tk_framework() {
		$this->__construct();
	}
	
	/**
	 * Includes files for framework
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 */	
	function includes(){
		require_once( 'tk_html/tk_html.php' );
		require_once( 'tk_html/tk_html_form.php' );
		require_once( 'tk_html/tk_form_element.php' );
		require_once( 'tk_html/tk_form_button.php' );
		require_once( 'tk_html/tk_form_textfield.php' );
		require_once( 'tk_html/tk_form_checkbox.php' );
		require_once( 'tk_html/tk_form_select.php' );
		
		require_once( 'tk_wp_gui/tk_wp_admin_page.php' );
		require_once( 'tk_wp_gui/tk_wp_form.php' );
		require_once( 'tk_wp_gui/tk_wp_form_textfield.php' );
		require_once( 'tk_wp_gui/tk_wp_form_checkbox.php' );
		require_once( 'tk_wp_gui/tk_wp_metabox.php' );
		require_once( 'tk_wp_gui/tk_wp_option_group.php' );
		require_once( 'tk_wp_gui/tk_wp_form_select.php' );
		
		require_once( 'tk_wp_jquery/tk_wp_jqueryui.php' );
		require_once( 'tk_wp_jquery/tk_wp_jqueryui_tabs.php' );
		require_once( 'tk_wp_jquery/tk_wp_jqueryui_accordion.php' );
		require_once( 'tk_wp_jquery/tk_wp_jqueryui_autocomplete.php' );		
	}
}
function tk_framework(){
	global $tkf;
	$tkf = new tk_framework();
}
?>