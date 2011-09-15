<?php

class TK_WP_Jquery_Fileuploader extends TK_WP_Form_Textfield{
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of colorfield
	 * @param array $args Array of [ $id , $extra Extra colorfield code, option_groupOption group to save data, $before_textfield Code before colorfield, $after_textfield Code after colorfield   ]
	 */
	function tk_jquery_fileuploader( $name, $args = array() ){
		$this->__construct( $name, $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of colorfield
	 * @param array $args Array of [ $id , $extra Extra colorfield code, option_groupOption group to save data, $before_textfield Code before colorfield, $after_textfield Code after colorfield   ]
	 */
	function __construct( $name, $args = array() ){
		$defaults = array(
			'id' => substr( md5 ( time() * rand() ), 0, 10 ),
			'extra' => '',
			'before_textfield' => '',
			'after_textfield' => ''
		);
		
		$args = wp_parse_args( $args, $defaults );
		extract( $args , EXTR_SKIP );
		
		$before_textfield.= '<div class="option-inputs"><label for="image1">';
		
		$after_textfield.= '
						<input class="tk_fileuploader" type="button" value="' . __( 'Browse ...' ) . '" /><br></br>
						<img class="cc_image_preview" id="image_' . $id . '" style="max-width: 100px"/>
						</label></div>
						';	
		 
		$args['before_textfield'] = $before_textfield;
		$args['after_textfield'] = $after_textfield;
		
		parent::__construct( $name, $args );
	}
}
function tk_form_fileuploader( $name, $args = array(), $return_object = FALSE ){
	$fileuploader = new TK_WP_Jquery_Fileuploader( $name, $args );
	
	if( TRUE == $return_object ){
		return $fileuploader;
	}else{
		return $fileuploader->get_html();
	}
}

?>