<?php

class TK_Jqueryui_Accordion extends TK_HTML{
	
	var $id;
	var $title_tag;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 */
	function tk_jqueryui_accordion( $id, $args = array() ){
		$this->__construct( $id, $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 */
	function __construct( $id, $args = array() ){
		$defaults = array(
			'title_tag' => 'h3'
		);
		
		$args = wp_parse_args($args, $defaults);
		extract( $args , EXTR_SKIP );
		
		parent::__construct();
		
		$this->id = $id;
		$this->title_tag = $title_tag;
	}
	
	/**
	 * Adding section to accordion
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $id Id of the section
	 * @param string $title Title of the section
	 * @param array $args Array of [ $extra_title Extra title code, $extra_content Extra content code ]
	 */
	function add_section( $id, $title, $content, $args = array() ){
		$defaults = array(
			'extra_title' => '',
			'extra_content' => ''
		);
		
		$args = wp_parse_args($args, $defaults);
		extract( $args , EXTR_SKIP );
		
		$element = array( 'id'=> $id, 'title' => $title, 'extra_title' => $extra_title,  'content' => $content, 'extra_content' => $extra_content );
		$this->add_element( $element );
	}

	/**
	 * Getting the accordion html
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @return string $html The accordion as html
	 * 
	 */
	function get_html(){
		
		$html = '<script type="text/javascript">
		jQuery(document).ready(function($){
			$( ".' . $this->id . '" ).accordion({ header: "' . $this->title_tag . '", active: false, autoHeight: false, collapsible:true });
		});
   		</script>';
		
		$html = apply_filters( 'tk_jqueryui_accordion_before' , $html );
		$html = apply_filters( 'tk_jqueryui_accordion_before_' . $this->id , $html );
		
		$html.= '<div class="' . $this->id . '">';
		
		foreach( $this->elements AS $element ){
			
			$html.= '<' . $this->title_tag . ' ' . $element['extra_title']  . '><a href="#">' . $element['title'] . '</a></' . $this->title_tag . '>';
			$html.= '<div id="' . $element['id'] . '"' . $element['extra_content']  . '>';
			
			$html = apply_filters( 'tk_jqueryui_accordion_content_section_before' , $html );
			$html = apply_filters( 'tk_jqueryui_accordion_content_section_before_' . $this->id , $html );
			$html = apply_filters( 'tk_jqueryui_accordion_content_section_before_' . $element['id'], $html );
		
			$html.= $element['content'];
			
			$html = apply_filters( 'tk_jqueryui_accordion_content_section_after' , $html );
			$html = apply_filters( 'tk_jqueryui_accordion_content_section_after_' . $this->id , $html );
			$html = apply_filters( 'tk_jqueryui_accordion_content_section_after_' . $element['id'], $html );

			$html.= '</div>';
		}
		
		$html.= '</div>';
		
		$html = apply_filters( 'tk_jqueryui_accordion_after' , $html );
		$html = apply_filters( 'tk_jqueryui_accordion_after_' . $this->id , $html );
		
		return $html;
	}	
	
}
function tk_jquery_accordion( $id, $elements ){
	$accordion = new TK_Jqueryui_Accordion( $id );	
	
	foreach ( $elements AS $element ){
		$args = array(
			'extra_title' => $element['extra_title'],
			'extra_content' => $element['extra_content']
		);
		$accordion->add_section( $element['id'], $element['title'], $element['content'], $args );
	}
	return $accordion->get_html();
}

?>
