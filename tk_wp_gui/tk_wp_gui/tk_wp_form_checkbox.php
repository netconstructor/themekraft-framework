<?php

class TK_WP_FORM_CHECKBOX extends TK_FORM_CHECKBOX{
	
	var $option_group;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of checkbox
	 * @param string $option_group Name of optiongroup where checkbox have to be saved
	 * @param array $args Array of [ $id Id, $extra Extra checkbox code   ]
	 */
	function tk_wp_form_checkbox( $name, $option_group, $args = array()){
		$this->__construct( $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of checkbox
	 * @param string $option_group Name of optiongroup where checkbox have to be saved
	 * @param array $args Array of [ $id Id, $extra Extra checkbox code   ]
	 */
	function __construct( $name, $option_group, $args = array() ){
		global $post;
		
		$defaults = array(
			'id' => '',
			'value' => '',
			'checked' => false,
			'extra' => ''
		);
		
		$args = wp_parse_args($args, $defaults);
		extract( $args , EXTR_SKIP );
		
		if( $post != '' ){

			$option_group_value = get_post_meta( $post->ID , $option_group , TRUE );
			
			$field_name = $option_group . '[' . $name . ']';
			$value = $option_group_value[ $name ];

		}else{
			$value = get_option( $option_group  . '_values' );
						
			$this->option_group = $option_group;
			$field_name = $option_group . '_values[' . $name . ']';	
			
			$value = $value[ $name ];
		} 
		
		$checked = FALSE;
		
		if( $value != '' ){
			$checked = TRUE;
		}
		
		$args['name'] = $name;
		parent::__construct( $args );

	}		
}
function tk_wp_form_checkbox( $name, $option_group, $args = array() ){
	$checkbox = new TK_WP_FORM_CHECKBOX( $name, $option_group, $args  );
	return $checkbox->get_html();
}

?>