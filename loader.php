<?php
/*
 * Loader script for the themekraft framework
 * Just include this script to load the framework
 */

global $tkf_version;

$this_tkf_version = '0.1.0';

// Initialize function of this version which have to be have hooked
function tkf_init_010(){
	require_once( 'core.php' );
}

function tk_framework( $args = array()  ){
	$defaults = array(
		'jqueryui_components' => '',
		'option_groups' => ''
	);
	
	$args = wp_parse_args($args, $defaults);
	extract( $args , EXTR_SKIP );
	
	
	if( count( $option_groups ) > 0  ){
		global $tk_option_groups;
		$tk_option_groups = $option_groups;
	}
	
	if( count( $jqueryui_components ) > 0  ){
		global $tk_jqueryui_components;
		$tk_jqueryui_components = $jqueryui_components;
	}
	
	add_action( 'admin_init', 'tk_register_option_groups' );
	
	add_action( 'wp_loaded', 'tk_load_framework' );
	add_action( 'wp_loaded', 'tk_load_jqueryui' );
}

function tk_register_option_groups(){
	global $tk_option_groups;
	
	foreach( $tk_option_groups AS $option_group ){
		tk_register_wp_option_group( $option_group );
	}
}

// If there is already a framework started
if( $tkf_version != '' ){
	
	// If started framework version is older than this version, remove action from init actionhook
	if( version_compare( $tkf_version, $this_tkf_version, '<' ) ){
		$function_name = 'tkf_init_' . str_replace( '.', '', $tkf_version );
		
		// Removing functions from init actionhook 
		if( has_action( 'wp_loaded', $function_name ) ){
			remove_action( $tag, $function_name );
		}
		
		// Add own action to actionhook
		$tkf_version = $this_tkf_version;
		add_action( 'wp_loaded', 'tkf_init_' . str_replace( '.', '', $this_tkf_version ) );
	}
}else{
	// Add own action to actionhook
	$tkf_version = $this_tkf_version;
	add_action( 'wp_loaded', 'tkf_init_' . str_replace( '.', '', $this_tkf_version ) );
}
?>