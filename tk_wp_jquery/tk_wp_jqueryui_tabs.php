<?php

class TK_WP_JQUERYUI_TABS extends TK_HTML{
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 */
	function tk_wp_jqueryui_tabs(){
		$this->__construct();
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 */
	function __construct(){
		parent::__construct();
		
		$jqueryui = new TK_WP_JQUERYUI();
		$jqueryui->load_jqueryui( array( 'jquery-ui-tabs' ) );
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
		
		$id = substr( md5( time() * rand() ), 0, 8 );
		
		$html = '<script type="text/javascript">
		jQuery(document).ready(function($){
			$( ".tk-' . $id . '" ).tabs();
		});
   		</script>';
		
		
		$html.= '<div class="tk-' . $id . '">';
		
		$html.= '<ul>';
		
		$html = apply_filters( 'tk_wp_jqueryui_tabs_before_tabs', $html );
		$html = apply_filters( 'tk_wp_jqueryui_tabs_before_tabs_' . $element['id'], $html );
		
		foreach( $this->elements AS $element ){
			$html.= '<li><a href="#' . $element['id'] . '" >' . $element['title'] . '</a></li>';
		}
		
		$html = apply_filters( 'tk_wp_jqueryui_tabs_after_tabs', $html );
		$html = apply_filters( 'tk_wp_jqueryui_tabs_after_tabs_' . $element['id'], $html );
		
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

function tk_jqueryui_tabs( $elements ){
	$tk_jqueryui_tabs = new	TK_WP_JQUERYUI_TABS();	
	foreach ( $elements AS $element ){
		$tk_jqueryui_tabs->add_tab( $element['id'], $element['title'], $element['content'] );
	}
	return $tk_jqueryui_tabs->get_html();
}

?>
