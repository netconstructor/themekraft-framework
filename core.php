<?php
	
class TK_Framework{
	
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
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 */
	function __construct(){
		$this->includes();
	}
	
	/**
	 * Includes files for framework
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 */	
	function includes(){
		
		require_once( 'html/html.php' );
		require_once( 'html/form.php' );
		require_once( 'html/form-element.php' );
		require_once( 'html/form-button.php' );
		require_once( 'html/form-textfield.php' );
		require_once( 'html/form-checkbox.php' );
		require_once( 'html/form-select.php' );
		
		require_once( 'wp/admin-page.php' );
		require_once( 'wp/form.php' );
		require_once( 'wp/form-textfield.php' );
		require_once( 'wp/form-checkbox.php' );
		require_once( 'wp/metabox.php' );
		require_once( 'wp/option-group.php' );
		require_once( 'wp/form-select.php' );
		
		require_once( 'jquery/jqueryui.php' );
		require_once( 'jquery/tabs.php' );
		require_once( 'jquery/accordion.php' );
		require_once( 'jquery/autocomplete.php' );		
	}
}

function tk_load_framework(){
	$tkf = new TK_Framework();
}

?>