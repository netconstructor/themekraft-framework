<?php

class TK_WP_Jquery_Colorpicker extends TK_WP_Form_Textfield{
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $name Name of colorfield
	 * @param array $args Array of [ $id , $value, $extra Extra colorfield code   ]
	 */
	function tk_jquery_colorpicker( $name, $args = array() ){
		$this->__construct( $name, $args );
	}
	
	function __construct( $name, $args = array() ){
		$defaults = array(
			'id' => substr( md5 ( time() * rand() ), 0, 10 ),
			'extra' => '',
			'option_group' => $tk_form_instance_option_group,
			'before_textfield' => '',
			'after_textfield' => ''
		);
		
		$args = wp_parse_args( $args, $defaults );
		extract( $args , EXTR_SKIP );
		
		/*
		$after_textfield = '<script type="text/javascript">
				jQuery(\'#' . $id . '\').ColorPicker({
					onSubmit: function(hsb, hex, rgb, el) {
					jQuery(el).val(hex);
						jQuery(el).ColorPickerHide();
					},
					onBeforeShow: function () {
						jQuery(this).ColorPickerSetColor(this.value);
					}
				})
				.bind(\'keyup\', function(){
					jQuery(this).ColorPickerSetColor(this.value);
				});
		
		</script>';
		 */
		
		
		$after_textfield = '<script type="text/javascript">
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
		 
		$args['after_textfield'] = $after_textfield;
		
		parent::__construct( $name, $args );
	}
}
function tk_form_colorpicker( $name, $args = array() ){
	$colorpicker = new TK_WP_Jquery_Colorpicker( $name, $args );
	return $colorpicker->get_html();
}

?>