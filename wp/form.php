<?php

class TK_WP_Form extends TK_FORM{
	
	var $option_group;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $option_group The name of the option group
	 * @param string $id The id of the form
	 */
	function tk_wp_form( $option_group, $id ){
		$this->__construct( $option_group, $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $option_group The name of the option group
	 * @param string $id The id of the form
	 */
	function __construct( $option_group, $id ){
		$args['method'] = 'POST';
		$args['action'] = 'options.php';
		
		parent::__construct( $id, $args );
		
		$this->option_group = $option_group;
	}
	
	/**
	 * Getting the form html
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @return string $html The form content
	 * 
	 */
	function get_html(){
		$html = '<input type="hidden" name="option_page" value="' . esc_attr( $this->option_group ) . '" />';
		$html.= '<input type="hidden" name="action" value="update" />';
		$html.= wp_nonce_field( $this->option_group . '-options', "_wpnonce", true , false ) ;
		
		$this->add_element( $html );

		$html = parent::get_html();
		
		return $html;
	}
}

?>