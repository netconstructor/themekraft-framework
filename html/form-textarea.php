<?php

class TK_Form_Textarea extends TK_Form_Element{
	
	var $extra;
	var $before_textarea;
	var $after_textarea;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $extra Extra textarea code, $rows Number of rows in textarea, $cols Number of columns in textarea, $before_textarea Code before textarea, $after_textarea Code after textarea ]
	 */
	function tk_form_textarea( $args ){
		$this->__construct( $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $extra Extra textarea code, $rows Number of rows in textarea, $cols Number of columns in textarea, $before_textarea Code before textarea, $after_textarea Code after textarea ]
	 */
	function __construct( $args ){
		$defaults = array(
			'id' => '',
			'name' => '',
			'value' => '',
			'extra' => '',
			'rows' => '',
			'cols' => '',
			'before_textarea' => '',
			'after_textarea' => ''
		);
		
		$args = wp_parse_args($args, $defaults);
		extract( $args , EXTR_SKIP );
		
		parent::__construct( $args );
		
		$this->extra = $extra;
		
		$this->rows = $rows;
		$this->cols = $cols;
		$this->before_textarea = $before_textarea;
		$this->after_textarea = $after_textarea;		
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
		if( $this->rows != '' ) $rows = ' rows="' . $this->rows . '"';
		if( $this->cols != '' ) $cols = ' cols="' . $this->cols . '"';		
		if( $this->extra != '' ) $extra = $this->extra;
		
		$html = $this->before_textarea;
		$html.= '<textarea' . $id . $name . $rows . $cols . $extra . ' />' . $this->value  . '</textarea>';
		$html.= $this->after_textarea;
		
		return $html;
	}
}

function tk_textarea( $args ){
	$textarea = new TK_Form_Textarea( $args );
	return $textarea->get_html();
}

?>