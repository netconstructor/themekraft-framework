<?php

class TK_Display_Builder{

	var $tkdb;
	var $functions;
	var $bound_content;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 */
	function tk_display_builder( $return_object = TRUE ){
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
		$this->tkdb = array();
		
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
		$functions['textfield'] = array( 'name' => '', 'return_object' => $return_object );
		$functions['textarea'] = array( 'name' => '', 'return_object' => $return_object );
		$functions['colorpicker'] = array( 'name' => '', 'return_object' => $return_object );
		$functions['file'] = array( 'name' => '', 'return_object' => $return_object );
		$functions['button'] = array( 'name' => '', 'return_object' => $return_object );
		$functions['checkbox'] = array( 'name' => '', 'return_object' => $return_object );
		
		$functions['select'] = array( 'name' => '', 'options' => array(), 'return_object' => $return_object );
		
		$this->bound_content = $bound_content;
		
		// Putting all functions in an array
		$this->function_names = array_keys( $functions );
		$this->functions = $functions;
	}
	
	function get_html( $elements = array(), $deep = 0 ) {
		$html = '';
		
		if( count( $elements ) == 0 && $deep == 0 ){
			$elements = $this->tkdb;
		}
		
		if( is_array( $elements ) ){
			foreach ( $elements AS $element ){
				
				if( is_array( $element ) ){
					 $html.= $this->get_html( $element, $deep++ );
					
					// echo $element;
				}elseif( is_object( $element ) ){
					 $html.= $element->get_html();
				}else{
					 $html.= $element;
				}
			}
		}else{
			return $elements;
		}
		return $html;
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
		$node = $doc->getElementsByTagName( 'tkfxml' );
		$mainnode = $node->item(0);
		
		// Getting object
		$this->tkdb = $this->tk_obj_from_node( $mainnode );
		
		echo "<pre>";
		// print_r( $this->tkdb );
		echo "</pre>";
		
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
					$params['content'][$i] = trim( $subnode_value );
				}
			}
		}
		
		/*
		 * Calling function / Returning value
		 */
		if( FALSE != $function_name ){
			// Sorting out all waste
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
				print_r( $params[ $this->bound_content[ $key ] ] );
				
				// If function was bound to content
				if( $this->bound_content[ $function_name ] != '' ){
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
}
/*
 * Tab functions
 */
function tk_db_tabs( $id, $elements = '', $return_object = TRUE ){
	return tk_tabs( $id, $elements, $return_object );
}
function tk_db_tab( $id, $title, $content = '' ){
	return array( 'id' => $id, 'title' => $title, 'content' => $content );
}

/*
 * Accordion functions
 */
function tk_db_accordion( $id, $elements = '', $return_object = TRUE ){
	return tk_accordion( $id, $elements, $return_object );
}
function tk_db_section( $id, $title, $content = '' ){
	return array( 'id' => $id, 'title' => $title, 'content' => $content );
}

/*
 * Form function
 */
function tk_db_form( $id, $name, $content = '', $return_object = TRUE ){
	return tk_form( $id, $name, $content, $return_object );
}

/*
 * Form element functions
 */
function tk_db_textfield( $name, $return_object = TRUE ){
	$args = array();
	return tk_form_textfield( $name, $args, $return_object );
}
function tk_db_textarea( $name, $return_object = TRUE ){
	$args = array();
	return tk_form_textarea( $name, $args, $return_object );
}
function tk_db_colorpicker( $name, $return_object = TRUE ){
	$args = array();
	return tk_form_colorpicker( $name, $args, $return_object );
}
function tk_db_file( $name, $return_object = TRUE ){
	$args = array();
	return tk_form_fileuploader( $name, $args, $return_object );
}
function tk_db_button( $name, $return_object = TRUE ){
	$args = array();
	return tk_form_button( $name, $args, $return_object );
}
function tk_db_checkbox( $name, $return_object = TRUE ){
	$args = array();
	return tk_form_checkbox( $name, $args, $return_object );
}
function tk_db_select( $name, $options, $return_object = TRUE ){
	$args = array();
	return tk_form_select( $name, $options, $args , $return_object );
}

?>