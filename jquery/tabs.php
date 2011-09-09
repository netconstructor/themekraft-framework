<?php

class TK_Jqueryui_Tabs extends TK_HTML{
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 */
	function tk_jqueryui_tabs( $id ){
		$this->__construct( $id );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 */
	function __construct( $id ){
		parent::__construct();
		
		$this->id = $id;
	}
	
	/**
	 * Adding tab
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param string $id Id of the tab
	 * @param string $title Title of the tab
	 * @param string $content Content which appears in the tab
	 * 
	 */
	public function add_tab( $id, $title, $content ){
		$element = array( 'id'=> $id, 'title' => $title, 'content' => $content );
		$this->add_element( $element );
	}
	
	/**
	 * Getting the tabs html
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @return string $html The tabs as html
	 * 
	 */
	public function get_html(){
		
		$html = '<script type="text/javascript">
		jQuery(document).ready(function($){
			$( ".' . $this->id . '" ).tabs();
		});
   		</script>';
		
		
		$html.= '<div class="' . $this->id . '">';
		
		$html.= '<ul>';
		
		$html = apply_filters( 'tk_jqueryui_tabs_tabs_before', $html );
		$html = apply_filters( 'tk_wp_jqueryui_tabs_tabs_before_' . $element['id'], $html );
		
		foreach( $this->elements AS $element ){
			$html.= '<li><a href="#' . $element['id'] . '" >';
			
			$html = apply_filters( 'tk_jqueryui_tabs_tabs_title_before', $html );
			$html = apply_filters( 'tk_wp_jqueryui_tabs_tabs_title_before_' . $element['id'], $html );
		
			$html.=$element['title'];
			
			$html = apply_filters( 'tk_jqueryui_tabs_tabs_title_after', $html );
			$html = apply_filters( 'tk_wp_jqueryui_tabs_tabs_title_after_' . $element['id'], $html );
			
			$html.= '</a></li>';
		}
		
		$html = apply_filters( 'tk_wp_jqueryui_tabs_tabs_after', $html );
		$html = apply_filters( 'tk_wp_jqueryui_tabs_tabs_after_' . $element['id'], $html );
		
		$html.= '</ul>';
		
		foreach( $this->elements AS $element ){
			$html.= '<div id="' . $element['id'] . '" >';
			$html = apply_filters( 'tk_wp_jqueryui_tabs_before_content', $html );
			$html = apply_filters( 'tk_wp_jqueryui_tabs_before_content_' . $element['id'], $html );
			$html.= $element['content'];
			$html = apply_filters( 'tk_wp_jqueryui_tabs_after_content', $html );
			$html = apply_filters( 'tk_wp_jqueryui_tabs_after_content_' . $element['id'], $html );
			$html.= '</div>';
		}
		
		$html.= '</div>';
		
		return $html;
	}
}

function tk_jqueryui_tabs( $id, $elements ){	
	$tabs = new	TK_Jqueryui_Tabs( $id );	
	foreach ( $elements AS $element ){
		$tabs->add_tab( $element['id'], $element['title'], $element['content'] );
	}
	return $tabs->get_html();
}

?>
