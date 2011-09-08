<?php
/*
 * Loader script for the themekraft framework
 * Just include this script to load the framework
 */

global $tkf_version;

$this_tkf_version = '0.1.0';

// Initialize function of this version which have to be have hooked
function tkf_init_010(){
	require_once( 'tk_core.php' );
}

// If there is already a framework started
if( $tkf_version != '' ){
	
	// If started framework version is older than this version, remove action from init actionhook
	if( version_compare( $tkf_version, $this_tkf_version, '<' ) ){
		$function_name = 'tkf_init_' . str_replace( '.', '', $tkf_version );
		
		// Removing functions from init actionhook 
		if( has_action( 'init', $function_name ) ){
			remove_action( $tag, $function_name );
		}
		
		// Add own action to actionhook
		$tkf_version = $this_tkf_version;
		add_action( 'init', 'tkf_init_' . str_replace( '.', '', $this_tkf_version ) );
	}
}else{
	// Add own action to actionhook
	$tkf_version = $this_tkf_version;
	add_action( 'init', 'tkf_init_' . str_replace( '.', '', $this_tkf_version ) );
}

?>