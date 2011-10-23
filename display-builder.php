<?php

class TK_Display_Builder{
	
	var $display;

	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 */
	function tk_display_builder( $display = '' ){
		$this->__construct( $display );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 */
	function __construct( $display = '' ){
		$this->display = $display;
	}
	
	/**
	 * Diplay builder for HTML
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param mixed $elements Array / Object of elements which have to be shown
	 * @return string $html The HTML of the display object
	 */	
	function get_html( $elements = '' ) {
		$html = '';
		
		// echo '==========================================================<br>';
		echo '<pre>';
		// print_r( $elements );
		echo '</pre>';
		
		// If element is no array and no object
		if( !is_array( $elements ) && !is_object( $elements ) ){
			// If internal display var is there, use it
			if( is_object( $this->display ) || is_array( $this->display ) ){
				$elements = $this->display;		
			}
		}
		
		// If it's array, run all elements 
		if( is_array( $elements ) ){
			foreach ( $elements AS $element ){
				
				// If subelement is an array
				if( is_array( $element ) ){
					 $html.= $this->get_html( $element );
					
				// If it's an object
				}elseif( is_object( $element ) ){
					 $html.= $element->get_html();
					 
				// It's anything else
				}else{
					 $html.= $element;
				}
			}
			return $html;
		
		// Objects have to give back their html
		
		// Return the waste! ;)
		}else{
			return $elements;
		}
	}
}