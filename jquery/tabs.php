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
		
		$html = apply_filters( 'tk_wp_jqueryui_tabs_tabs_before_' . $element['id'], $html );
		
		foreach( $this->elements AS $element ){
			
			$html = apply_filters( 'tk_wp_jqueryui_tabs_tabs_before_li_' . $element['id'], $html );
			
			$html.= '<li><a href="#' . $element['id'] . '" >';
			
			$html = apply_filters( 'tk_wp_jqueryui_tabs_tabs_title_before_' . $element['id'], $html );
		
			if( is_object( $element['title'] ) ){
				 $html.= $element['title']->get_html();
			}else{
				 $html.= $element['title'];
			}
			
			$html = apply_filters( 'tk_wp_jqueryui_tabs_tabs_title_after_' . $element['id'], $html );
			
			$html.= '</a></li>';
			
			$html = apply_filters( 'tk_wp_jqueryui_tabs_tabs_after_li_' . $element['id'], $html );
		}
		
		$html = apply_filters( 'tk_wp_jqueryui_tabs_tabs_after_' . $element['id'], $html );
		
		$html.= '</ul>';
		
		foreach( $this->elements AS $element ){
			$html.= '<div id="' . $element['id'] . '" >';
			$html = apply_filters( 'tk_wp_jqueryui_tabs_before_content_' . $element['id'], $html );
			
			$tkdb = new TK_Display_Builder();
			$html.= $tkdb->get_html( $element['content'] );
			unset( $tkdb );
			
			$html = apply_filters( 'tk_wp_jqueryui_tabs_after_content_' . $element['id'], $html );
			$html.= '</div>';
		}
		
		$html.= '</div>';
		
		return $html;
	}
}
class TK_Jqueryui_Tabs_Tab extends TK_HTML{
	function tk_jqueryui_tabs_tab( $id, $title, $content ){
		$this->__construct($id, $title, $content);
	}
	
	function __construct( $id, $title, $content ){
		$this->id = $id;
		$this->title = $title;
		$this->content = $content;
	}
}

function tk_tabs( $id, $elements, $return_object = FALSE ){	
	$tabs = new	TK_Jqueryui_Tabs( $id );	
	
	foreach ( $elements AS $element ){
		$tabs->add_tab( $element['id'], $element['title'], $element['content'] );
	}

	if( TRUE == $return_object ){
		return $tabs;
	}else{
		return $tabs->get_html();
	}
}

?>
