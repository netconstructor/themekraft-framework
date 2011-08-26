<?php

function tk_framework(){
	require_once( 'tk_html/tk_html.php' );
	require_once( 'tk_html/tk_html_form.php' );
	require_once( 'tk_html/tk_form_element.php' );
	require_once( 'tk_html/tk_form_button.php' );
	require_once( 'tk_html/tk_form_textfield.php' );
	require_once( 'tk_html/tk_form_checkbox.php' );
	require_once( 'tk_html/tk_form_select.php' );
	
	require_once( 'tk_wp_gui/tk_wp_admin_display.php' );
	require_once( 'tk_wp_gui/tk_wp_form.php' );
	require_once( 'tk_wp_gui/tk_wp_form_textfield.php' );
	require_once( 'tk_wp_gui/tk_wp_form_checkbox.php' );
	require_once( 'tk_wp_gui/tk_wp_metabox.php' );
	require_once( 'tk_wp_gui/tk_wp_option_group.php' );
	require_once( 'tk_wp_gui/tk_wp_form_select.php' );
	
	require_once( 'tk_wp_jquery/tk_wp_jqueryui.php' );
	require_once( 'tk_wp_jquery/tk_wp_jqueryui_tabs.php' );
	require_once( 'tk_wp_jquery/tk_wp_jqueryui_accordion.php' );
	require_once( 'tk_wp_jquery/tk_wp_jqueryui_autocomplete.php' );	
}

?>