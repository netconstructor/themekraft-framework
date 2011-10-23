<?php
/**
 * WordPress Markup Language parser (WPL Parser)
 * 
 * @author Sven Wagener <svenw_at_themekraft_dot_com>
 * @copyright themekraft.com
 * 
 */
class TK_WML_Parser{

	var $display;
	var $functions;
	var $bound_content;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 */
	function tk_wpml_parser( $return_object = TRUE ){
		$this->__construct( $return_object );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 */
	function __construct( $return_object = TRUE ){
		$this->display= array();
		
		// Tabs
		$functions['tabs'] = array( 'id' =>'', 'tab' => array(), 'return_object' => $return_object );
		$functions['tab'] = array( 'id' => '', 'title' => '', 'content' => '' );
		$bound_content['tabs'] = 'tab';
		
		// Accordion
		$functions['accordion'] = array( 'id' => '', 'section' => array(), 'return_object' => $return_object );
		$functions['section'] = array( 'id' => '', 'title' => '', 'content' => '' );
		$bound_content['accordion'] = 'section';
		
		// Form
		$functions['form'] = array( 'id' => '', 'name' => '', 'content' => '', 'return_object' => $return_object );
		
		// Form elements
		$functions['textfield'] = array( 'name' => '', 'label' => '', 'tooltip' => '' , 'return_object' => $return_object );
		$functions['textarea'] = array( 'name' => '', 'label' => '', 'tooltip' => '', 'return_object' => $return_object );
		$functions['colorpicker'] = array( 'name' => '', 'label' => '', 'tooltip' => '', 'return_object' => $return_object );
		$functions['file'] = array( 'name' => '', 'label' => '', 'tooltip' => '', 'return_object' => $return_object );
				
		$functions['checkbox'] = array( 'name' => '', 'label' => '', 'tooltip' => '', 'return_object' => $return_object );
		$functions['radio'] = array( 'name' => '', 'value' => '', 'description' => '', 'label' => '', 'tooltip' => '', 'return_object' => $return_object );
		
		$functions['select'] = array( 'name' => '', 'option' => array(), 'label' => '', 'tooltip' => '',  'return_object' => $return_object );
		$functions['option'] = array( 'name' => '', 'value' => '' );
		$bound_content['select'] = 'option';		
		
		$functions['button'] = array( 'name' => '', 'return_object' => $return_object );
		
		$this->bound_content = $bound_content;
		
		// Putting all functions in an array
		$this->function_names = array_keys( $functions );
		$this->functions = $functions;
	}
	
	function load_xml( $xml_string, $return_object = FALSE ){
		
		// Checking if DOMDocument is installed
		if ( ! class_exists('DOMDocument') )
			return FALSE;
		
		// Loading XML		
		$doc = new DOMDocument();
		if ( !$doc->loadXML( $xml_string ) )
			return FALSE;
				
		// Getting main node
		$node = $doc->getElementsByTagName( 'wml' );
		$mainnode = $node->item(0);
		
		// Getting object
		$this->display= $this->tk_obj_from_node( $mainnode );
				
		return TRUE;
	}

	function tk_obj_from_node( $node, $function_name = FALSE ){
		
		// Getting node values
		$node_name = $node->nodeName;
   		$node_value = $node->nodeValue;
		$node_attr = $node->attributes;
		$node_list = $node->childNodes;
		
		/*
		 * Running node attributes 
		 */
		foreach( $node_attr as $attribute ){
			$params[$attribute->nodeName] = $attribute->nodeValue;
		}
		
		// Functions have to be executed before executing inner functions			
		if( FALSE != $function_name ){
			// Setting global form instance name
			if( $function_name == 'form' ){
				global $tk_form_instance_option_group;					
				$tk_form_instance_option_group = $params['name'];									
			}
		}		
		
		/*
		 * Running sub nodes 
		 */
		for( $i=0;  $i < $node_list->length; $i++ ){
			$subnode = $node_list->item( $i );
			$subnode_name = $subnode->nodeName;
			$subnode_value = $subnode->nodeValue;
			
			if( in_array( $subnode_name, $this->function_names ) ){												
				$params['content'][$i] = $this->tk_obj_from_node( $subnode, $subnode_name );
			}else{
				if( $subnode->nodeType == XML_TEXT_NODE && trim( $subnode_value ) != '' ){
					$params['content'][$i] = '<p>' . trim( $subnode_value ) . '</p>';
				}
			}
		}
		
		/*
		 * Calling function / Returning value
		 */
		if( FALSE != $function_name ){
			$params = $this->cleanup_function_params( $function_name, $params );
			$function_result = call_user_func_array( 'tk_db_' . $function_name , $params );
			return $function_result;
		}else{
			return $params;
		}
	}

	function cleanup_function_params( $function_name, $params ){
		
		// Checking each param for function
		foreach( $this->functions[ $function_name ] AS $key => $function_params ){
			
			// If function was bound to content or has no content
			if( $params[ $key ] == '' ){
				// If function was bound to content
				if( $this->bound_content[ $function_name ] != '' && $key == $this->bound_content[ $function_name ] ){
					$params_new[ $this->bound_content[ $function_name ] ] = $params[ 'content' ];
				}else{
					// Rewrite key to function name
					$params_new[ $key ] = $this->functions[ $function_name ][ $key ];
				}

			// Getting content from set param
			}else{
				$params_new[ $key ] = $params[ $key ];
			}
		}
		return $params_new;
	}
	
	function get_html(){		
		$db = new TK_Display();
		return $db->get_html( $this->display );
	}
}
/*
 * Tab functions
 */
function tk_db_tabs( $id = '', $elements = array(), $return_object = TRUE ){
	return tk_tabs( $id, $elements, $return_object );
}
function tk_db_tab( $id, $title, $content = '' ){
	return array( 'id' => $id, 'title' => $title, 'content' => $content );
}

/*
 * Accordion functions
 */
function tk_db_accordion( $id, $elements = array(), $return_object = TRUE ){
	return tk_accordion( $id, $elements, $return_object );
}
function tk_db_section( $id, $title, $content = '' ){
	return array( 'id' => $id, 'title' => $title, 'content' => $content );
}

/*
 * Form function
 */
function tk_db_form( $id, $name, $content = '', $return_object = TRUE ){
	$form = tk_form( $id, $name, $content, $return_object );
	/* echo '<pre>';
	print_r( $form );
	echo '</pre>'; */
	return $form;
}

/*
 * Form element functions
 */
function tk_db_textfield( $name, $label, $tooltip, $return_object = TRUE ){
	$args = array(
		'id' => $name,
		'before_element' => '<div class="tk_field_row"><div class="tk_field_label"><label for="' . $name . '" title="' . $tooltip . '">' . $label . '</label></div><div class="tk_field">',
		'after_element' => '</div></div>'
	);
	return tk_form_textfield( $name, $args, $return_object );
}

function tk_db_textarea( $name, $label, $tooltip, $return_object = TRUE ){
	$args = array(
		'id' => $name,
		'before_element' => '<div class="tk_field_row"><div class="tk_field_label"><label for="' . $name . '" title="' . $tooltip . '">' . $label . '</label></div><div class="tk_field">',
		'after_element' => '</div></div>'
	);
	return tk_form_textarea( $name, $args, $return_object );
}

function tk_db_colorpicker( $name, $label, $tooltip, $return_object = TRUE ){
	$args = array(
		'id' => $name,
		'before_element' => '<div class="tk_field_row"><div class="tk_field_label"><label for="' . $name . '" title="' . $tooltip . '">' . $label . '</label></div><div class="tk_field">',
		'after_element' => '</div></div>'
	);
	return tk_form_colorpicker( $name, $args, $return_object );
}

function tk_db_file( $name, $label, $tooltip, $return_object = TRUE ){
	$args = array(
		'id' => $name,
		'before_element' => '<div class="tk_field_row"><div class="tk_field_label"><label for="' . $name . '" title="' . $tooltip . '">' . $label . '</label></div><div class="tk_field">',
		'after_element' => '</div></div>'
	);
	return tk_form_fileuploader( $name, $args, $return_object );
}

function tk_db_checkbox( $name, $label, $tooltip, $return_object = TRUE ){
	$args = array(
		'id' => $name,
		'before_element' => '<div class="tk_field_row"><div class="tk_field_label"><label for="' . $name . '" title="' . $tooltip . '">' . $label . '</label></div><div class="tk_field">',
		'after_element' => '</div></div>'
	);
	return tk_form_checkbox( $name, $args, $return_object );
}
function tk_db_radio( $name, $value, $description, $label, $tooltip, $return_object = TRUE ){
	$args = array(
		'id' => $name,
		'before_element' => '<div class="tk_field_row"><div class="tk_field_label"><label for="' . $name . '" title="' . $tooltip . '">' . $label . '</label></div><div class="tk_field">',
		'after_element' => ' ' . $description . '</div></div>'
	);
	return tk_form_radiobutton( $name, $value, $args, $return_object );
}

function tk_db_select( $name, $options, $label, $tooltip, $return_object = TRUE ){
	$args = array(
		'id' => $name,
		'before_element' => '<div class="tk_field_row"><div class="tk_field_label"><label for="' . $name . '" title="' . $tooltip . '">' . $label . '</label></div><div class="tk_field">',
		'after_element' => '</div></div>'
	);
	return tk_form_select( $name, $options, $args , $return_object );
}
function tk_db_option( $name, $value ){
	return array( 'name' => $name, 'value' => $value );
}

function tk_db_button( $name, $return_object = TRUE ){
	$args = array(
		'id' => $name,
		'before_element' => '<div class="tk_field_row"><div class="tk_field">',
		'after_element' => '</div></div>'
	);
	return tk_form_button( $name, $args, $return_object );
}