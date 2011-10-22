<?php

class TK_Form_Button extends TK_Form_Element{
	var $extra;
	var $submit;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $submit use submit, $extra Extra checkbox code   ]
	 */
	function tk_form_button( $value, $args = array() ){
		$this->__construct( $value, $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $submit use submit, $extra Extra checkbox code   ]
	 */
	function __construct( $value, $args = array() ){
		$defaults = array(
			'id' => '',
			'name' => '',
			'submit' => true,
			'extra' => ''
		);
		
		$args = wp_parse_args($args, $defaults);
		extract( $args , EXTR_SKIP );
		
		$args['value'] = $value;	
		parent::__construct( $args );
		
		$this->submit = $submit;
		$this->extra = $extra;
	}
	
	/**
	 * Getting HTML of button
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @return string $html The HTML of button
	 */
	function get_html(){
		if( $this->id != '' ) $id = ' id="' . $this->id . '"';
		if( $this->name != '' ) $name = ' name="' . $this->name . '"';
		if( $this->value != '' ) $value = ' value="' . $this->value . '"';
		if( $this->extra != '' ) $extra = $this->extra;
		
		if( $this->submit ){
			$html = '<input type="submit"' . $id . $name . $value . $extra . ' />';
		}else{
			$html = '<input type="button"' . $id . $name . $value . $extra . ' />';
		}
		return $html;
	}
}

function tk_button( $value, $args = array(), $return_object = FALSE ){
	$button = new TK_Form_Button( $value, $args );
	
	if( TRUE == $return_object ){
		return $button;
	}else{
		return $button->get_html();
	}
}