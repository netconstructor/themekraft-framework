<?php

class TK_Export_Button extends TK_WP_Form_Button{
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $id Id, $name Name, $value Value, $submit use submit, $extra Extra checkbox code   ]
	 */
	function tk_export_button( $value, $args = array() ){
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
		global $tk_form_instance_option_group;
		
		$defaults = array(
			'id' => '',
			'name' => $value,
			'forms' => array(),
			'file_name' => 'export_' . date( 'Ymdhis', time() ) . '.txt',
			'extra' => '',
			'before_element' => '',
			'after_element' => ''
		);
		
		// echo '<br /><br />Value: ' . $value;
		
		add_filter( 'sanitize_option_' . $tk_form_instance_option_group . '_values', array( $this , 'validate_actions' ) );
		
		$args = wp_parse_args($args, $defaults);
		extract( $args , EXTR_SKIP );
		
		parent::__construct( $value, $args );
		
		$this->lookup_name = $name;
		
		$this->submit = TRUE;
		$this->forms = $forms;
		$this->file_name = $file_name;
		$this->extra = $extra;
	}
	
	function validate_actions( $input ){
		global $tk_form_instance_option_group;
		
		if( $input[ $this->lookup_name ] != '' ){
			tk_download_export_values( $this->forms, $this->file_name );
			$input = get_option( $tk_form_instance_option_group . '_values' );
		}
		return $input;
	}
	
}
function tk_export_button( $value, $args, $return_object = FALSE  ){
	$export_button = new TK_Export_Button( $value, $args );
	
	if( TRUE == $return_object ){
		return $export_button;
	}else{
		return $export_button->get_html();
	}
}
