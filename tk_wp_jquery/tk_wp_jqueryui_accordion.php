<?php

class TK_WP_JQUERYUI_ACCORDION extends TK_HTML{
	
	public function __construct(){
		parent::__construct();
		
		$jqueryui = new TK_WP_JQUERYUI();
		$jqueryui->load_jqueryui( array( 'jquery-ui-accordion' ) );
	}
	
	public function add_section( $id, $title, $content, $extra_title = '', $extra_content = '' ){
		$element = array( 'id'=> $id, 'title' => $title, 'extra_title' => $extra_title,  'content' => $content, 'extra_content' => $extra_content );
		$this->add_element( $element );
	}

	public function get_html(){
		$id = substr( md5( time() * rand() ), 0, 8 );
		
		$html = '<script type="text/javascript">
		jQuery(document).ready(function($){
			$( ".tk-' . $id . '" ).accordion({ header: "h3", active: false, autoHeight: false, collapsible:true });
		});
   		</script>';
		
		
		$html.= '<div class="tk-' . $id . '">';
		
		foreach( $this->elements AS $element ){
			
			$html.= '<h3' . $element['extra_title']  . '><a href="#">' . $element['title'] . '</a></h3>';
			$html.= '<div id="' . $element['id'] . '"' . $element['extra_content']  . '>' . $element['content'] . '</div>';
		}
		
		$html.= '</div>';
		
		return $html;
	}	
	
}
function tk_wp_jquery_accordion( $elements ){
	global $tk_jqueryui_accordion;
	$tk_jqueryui_accordion = new	TK_WP_JQUERYUI_ACCORDION();	
	
	foreach ( $elements AS $element ){
		$tk_jqueryui_accordion->add_section( $element['id'], $element['title'], $element['content'], $element['extra_title'], $element['extra_content'] );
	}
	return $tk_jqueryui_accordion->get_html();
}

?>
