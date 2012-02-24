<?php

class TK_Values{
	var $option_group;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 */
	function tk_values( $option_group ){
		$this->__construct( $option_group );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 */
	function __construct( $option_group ){
		$this->option_group = $option_group;
	}
	
	function get_values(){
		$values = get_option( $this->option_group  . '_values' );
		
		if( $values != '' )
			return (object) $values;
			 
		return FALSE;
	}
	
	function set_values( $values ){
		return update_option( $this->option_group . '_values', $values );
	}
	
	function get_post_values( $postID = FALSE ){
		global $post;
		
		if( $postID != FALSE ){
			return get_post_meta( $postID , $option_group , true );
		}else if( isset( $post ) ){
			return get_post_meta( $post->ID , $option_group , true );
		}else{
			return FALSE;
		}
	}
}

function tk_encrypt_string( $string ){
	for( $i = 0; $i < strlen( $string ) ; $i++ ){
		$string_encrypted.= chr( $string[$i] );
	}
	return $string_encrypted;
}
function tk_decrypt_string( $string ){
	for( $i=0 ; $i < strlen( $string ); $i++ ){
		$string_decrypted.= ord( $string[$i] );
	}
	return $string_decrypted;
}

function tk_get_values( $option_group ){
	$val = new TK_Values( $option_group );
	return $val->get_values();
}

function tk_set_values( $option_group, $values ){
	$val = new TK_Values( $option_group );
	return $val->set_values( $values );
}