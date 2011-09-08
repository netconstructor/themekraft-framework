<?php 

class TK_WP_Form_Select extends TK_Form_Select{
	
	var $option_group;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of select field
	 * @param string $option_group Name of optiongroup where select field have to be saved
	 * @param array $args Array of [ $id , $extra Extra select field code   ]
	 */
	function tk_wp_form_select( $name, $option_group, $args = array() ){
		$this->__construct( $name, $option_group, $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of select field
	 * @param string $option_group Name of optiongroup where select field have to be saved
	 * @param array $args Array of [ $id , $extra Extra select field code   ]
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

			$option_group_value = get_post_meta( $post->ID , $option_group , TRUE );
			
			$field_name = $option_group . '[' . $name . ']';
			$value = $option_group_value[ $name ];

		}else{
			$value = get_option( $option_group  . '_values' );
						
			$this->option_group = $option_group;
			$field_name = $option_group . '_values[' . $name . ']';	
			
			$value = $value[ $name ];
		} 
		
		$args['name'] = $name;
		parent::__construct( $field_name, $value, $id, $extra );

	}			
}

?>