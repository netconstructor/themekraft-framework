<?php

class TK_WP_ADMIN_FORM_TEXTFIELD extends TK_FORM_TEXTFIELD{
	
	var $option_group;
	
	public function __construct( $id, $name, $value, $extra = '', $option_group = '' ){
		parent::__construct( $id, $name, $value, $extra );
		$this->option_group = $option_group;
		
		if( $this->option_group != '' )
			register_setting( $this->option_group, $this->name );
	}
		
}

function tk_wp_admin_form_textfield( $id, $name, $value, $extra = '', $option_group = '' ){
	$textfield = new TK_WP_ADMIN_FORM_TEXTFIELD( $id, $name, $value, $extra, $option_group );
	return $textfield->get_html();
}

?>