<?php

class TK_Display_Builder{
	var $tkdb;
	var $functions;
	var $debug;
	
	function tk_display_builder( $return_object = TRUE ){
		$this->__construct( $return_object );
	}
	
	function __construct( $return_object = TRUE ){
		$this->tkdb = array();
		
		$functions['tabs'] = array( 'id' =>'', 'tab' => array(), 'return_object' => $return_object );
		// $functions['tab'] = array( 'id' =>'', 'title' => '', 'content' => '' );
		$functions['accordion'] = array( 'id' => '', 'elements' => array(), 'return_object' => $return_object );
		$functions['form_textfield'] = array( 'name' => 'name', 'args' => array(), 'return_object' => $return_object );
		// $functions['content'] = array( 'content' =>'' );
		
		$this->function_names = array_keys( $functions );
		$this->functions = $functions;
		
		// $this->debug = TRUE;
	}
	
	function add_accordion( $id, $elements, $return = FALSE  ){
		$accordion = new TK_Jqueryui_Accordion( $id );	
		
		foreach ( $elements AS $element ){
			$args = array(
				'extra_title' => $element['extra_title'],
				'extra_content' => $element['extra_content']
			);
			$accordion->add_section( $element['id'], $element['title'], $element['content'], $args );
		}
		
		if( FALSE == $return ){
			$this->tkdb[] = $accordion;
		}else{
			return $accordion;
		}
		
	}
	
	function add_tabs( $id, $elements, $return = FALSE ){
		$tabs = new	TK_Jqueryui_Tabs( $id );
		foreach ( $elements AS $element ){
			$tabs->add_tab( $element['id'], $element['title'], $element['content'] );
		}
		
		if( FALSE == $return ){
			$this->tkdb[] = $tabs;
		}else{
			return $tabs;
		}
	}

	function add_form_textfield( $name, $args = array(), $return_object = FALSE ){	
		$textfield = new TK_WP_Form_Textfield( $name, $args );
		
		if( TRUE == $return_object ){
			return $textfield;
		}else{
			return $textfield->get_html();
		}
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
		
		$xml_obj = simplexml_load_string( $xml_string );
		$obj = $this->tk_obj_from_xml_obj( $xml_obj );
		$this->tkdb = $obj;
		
	}

	function tk_obj_from_xml_obj( $xml_obj , $function_name = false ){
		$xml_arr = get_object_vars( $xml_obj );
		
		$parameters = array();
		
		// Running all elements
		if( is_array( $xml_arr ) ){
			
			foreach( $xml_arr AS $key => $xml_element ){
				
				// If is object
				if( is_object( $xml_element ) ){
					
					// If is function, get object
					if( in_array( $key, $this->function_names ) ){
						
						$parameters[$key] = $this->tk_obj_from_xml_obj( $xml_element, $key );
						
					// If is no function, get array with content
					}else{
						$parameters[$key] =  $this->tk_obj_from_xml_obj( $xml_element );
					}
				
				// If is array
				}elseif( is_array( $xml_element ) ){
						
					$param_arr = array();
					
					foreach( $xml_element AS $xml_sub_element_key => $xml_sub_element ){
						
						if( is_object( $xml_sub_element )){
							
							// If is function, get object
							if( in_array( $key, $this->function_names, TRUE ) ){
								
								$rrr = $this->tk_obj_from_xml_obj( $xml_sub_element, $key );
					
							// If is no function, get array with content
							}else{
								$rrr = $this->tk_obj_from_xml_obj( $xml_sub_element ) ;
							}
							$param_arr[]  = $rrr;
							
						}elseif( is_array( $xml_sub_element ) ){
							$subelement_arr = array();
							
							foreach( $xml_sub_element AS $value_key => $value ){
								$subelement_arr[$xml_sub_element_key] = $value;
							}
							$param_arr[] = $subelement_arr;
							
						}else{
							$param_arr[] = $xml_sub_element;
						}
					}
					
					$parameters[$key] = $param_arr;
				// If is string
				}else{
					$parameters[$key] = $xml_element;
				}
			}
	
			if( FALSE != $function_name ){
				$parameters = $this->clean_function_parameters( $function_name, $parameters );
				
				$result = call_user_func_array( 'tk_' . $function_name , $parameters );
				
				if( is_object( $result ) ){
					$element_obj = $result;
				}else{
					$element_obj = array( $result );
				}
				
				return $element_obj;
			}else{
				
				return $parameters;
			}
		}
		
	}
	
	function clean_function_parameters( $function_name, $parameters ){
		$return_object = TRUE;
		$functions = $this->functions;
		
		$parameters_new = array();
		
		// Running all parameters of function
		foreach( $functions[$function_name] AS $function_parameter_key => $function_parameter_array ) {
					
			if( $parameters[$function_parameter_key] != '' ){
				
				// If parameter is object
				if ( is_object( $parameters[ $function_parameter_key ] ) ){
					$object = $this->tk_obj_from_xml_obj( $parameters[ $function_parameter_key ] );
					$parameters_new[] = $object;				
					
				// If parameter is string
				}else{
					$parameters_new[] = $parameters[ $function_parameter_key ];
				}
				
			// If no parameter is set, use standard value
			}else{
				$parameters_new[] = $functions[$function_name][$function_parameter_key];
			}
		}
		return $parameters_new;
	}
	
	function get_xml(){
		$class_name = get_class( $this );
		
		$xml = '<object name="' . $class_name . '">';
		
		$class_vars = get_object_vars( $this );
		foreach ( $class_vars as $var_name => $value ) {
			$xml.='\t<value name="' . $var_name . '">' . $value . '</value>';
		}
		$xml.='</object>';
		
		
	}
}

function tk_tab( $id, $title, $content ){
	return array( 'id' => $id, 'title' => $title, 'content' => $content );
}

function tk_content( $content ){
	return $content; 
}

?>