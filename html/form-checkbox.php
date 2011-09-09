<?php

class TK_Form_Checkbox extends TK_Form_Element{
	var $extra;
	var $checked;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $checked Checked value, $extra Extra checkbox code   ]
	 */
	function tk_form_checkbox( $args ){
		$this->__construct( $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $checked Checked value, $extra Extra checkbox code   ]
	 */
	function __construct( $args ){
		$defaults = array(
			'id' => '',
			'name' => '',
			'value' => '',
			'checked' => false,
			'extra' => ''
		);
		
		$args = wp_parse_args($args, $defaults);
		extract( $args , EXTR_SKIP );
		
		parent::__construct( $args );
		
		$this->extra = $extra;
		$this->checked = $checked;
	}
	
	/**
	 * Getting HTML of checkbox
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @return string $html The HTML of checkbox
	 */
	function get_html(){
		if( $this->id != '' ) $id = ' id="' . $this->id . '"';
		if( $this->name != '' ) $name = ' name="' . $this->name . '"';
		if( $this->value != '' ) $value = ' value="' . $this->value . '"';
		if( $this->extra != '' ) $extra = $this->extra;
		if( $this->checked == true ) $checked = ' checked';
				
		$html = '<input type="checkbox" ' . $id . $name . $value . $extra . $checked . ' />';
		
		return $html;
	}
}
function tk_checkbox( $args ){
	$checkbox = new TK_Form_Checkbox( $args );
	return $checkbox->get_html();
}

?>