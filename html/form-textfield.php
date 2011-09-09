<?php

class TK_Form_Textfield extends TK_Form_Element{
	var $extra;
	var $before_textfield;
	var $after_textfield;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $extra Extra textfield code ]
	 */
	function tk_form_textfield( $args ){
		$this->__construct( $args );		
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $extra Extra textfield code ]
	 */
	function __construct( $args ){
		$defaults = array(
			'id' => '',
			'name' => '',
			'value' => '',
			'extra' => '',
			'before_textfield' => '',
			'after_textfield' => ''
		);
		
		$args = wp_parse_args($args, $defaults);
		extract( $args , EXTR_SKIP );
		
		parent::__construct( $args );
		
		$this->extra = $extra;
		
		$this->before_textfield = $before_textfield;
		$this->after_textfield = $after_textfield;		
	}
	
	/**
	 * Getting HTML of textfield
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @return string $html The html of the textfield
	 */
	function get_html(){
		if( $this->id != '' ) $id = ' id="' . $this->id . '"';
		if( $this->name != '' ) $name = ' name="' . $this->name . '"';
		if( $this->value != '' ) $value = ' value="' . $this->value . '"';
		if( $this->extra != '' ) $extra = $this->extra;
		
		$html = $this->before_textfield;
		$html.= '<input' . $id . $name . $value . $extra . ' />';
		$html.= $this->after_textfield;
		
		return $html;
	}
}

function tk_textfield( $args ){
	$textfield = new TK_Form_Textfield( $args );
	return $textfield->get_html();
}

?>