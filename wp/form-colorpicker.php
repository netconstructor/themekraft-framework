<?php

class TK_WP_Jquery_Colorpicker extends TK_WP_Form_Textfield{
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of colorfield
	 * @param array $args Array of [ $id , $extra Extra colorfield code, option_groupOption group to save data, $before_textfield Code before colorfield, $after_textfield Code after colorfield   ]
	 */
	function tk_jquery_colorpicker( $name, $args = array() ){
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
		
		$after_textfield.= '<script type="text/javascript">
		jQuery(document).ready(function($){
			$(\'#' . $id . '\').ColorPicker({
				onSubmit: function(hsb, hex, rgb, el) {
					$(el).val(hex);
					$(el).ColorPickerHide();
				},
				onBeforeShow: function () {
					$(this).ColorPickerSetColor(this.value);
				}
			})
			.bind(\'keyup\', function(){
				$(this).ColorPickerSetColor(this.value);
			});
		});
   		</script>';
		 
		$args['before_textfield'] = $before_textfield;
		$args['after_textfield'] = $after_textfield;
		
		parent::__construct( $name, $args );
	}
}
function tk_form_colorpicker( $name, $args = array() ){
	$colorpicker = new TK_WP_Jquery_Colorpicker( $name, $args );
	return $colorpicker->get_html();
}

?>