<?php

class TK_WP_FORM_TEXTFIELD extends TK_FORM_TEXTFIELD{
	
	var $option_group;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of textfield
	 * @param string $option_group Name of optiongroup where textfield have to be saved
	 * @param array $args Array of [ $id , $value,  $extra Extra textfield code   ]
	 */
	function tk_wp_form_textfield( $name, $option_group, $args = array() ){
		$this->__construct( $name, $option_group, $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of textfield
	 * @param string $option_group Name of optiongroup where textfield have to be saved
	 * @param array $args Array of [ $id,  $extra Extra textfield code   ]
	 */
	function __construct( $name, $option_group, $args = array() ){
		global $post;
		
		$defaults = array(
			'id' => '',
			'extra' => ''
		);
		
		$args = wp_parse_args($args, $defaults);
		extract( $args , EXTR_SKIP );
		
		if( $post != '' ){

			$option_group_value = get_post_meta( $post->ID , $option_group , true );
			
			$field_name = $option_group . '[' . $name . ']';
			$value = $option_group_value[ $name ];

		}else{
			$value = get_option( $option_group  . '_values' );
			
			$this->option_group = $option_group;
			$field_name = $option_group . '_values[' . $name . ']';	
			
			$value = $value[ $name ];
		} 
		
		$args['name'] = $name;
		parent::__construct( $args );

	}
		
}

function tk_wp_form_textfield( $name, $option_group, $args = array() ){
	$textfield = new TK_WP_FORM_TEXTFIELD( $name, $option_group, $args );
	return $textfield->get_html();
}

?>