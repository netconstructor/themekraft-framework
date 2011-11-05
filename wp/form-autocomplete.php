<?php

class TK_Jqueryui_Autocomplete extends TK_WP_Form_Textfield{
	
	var $autocomplete_source;
	var $id;
	
	function tk_jqueryui_autocomplete( $name, $option_group,  $id, $autocomplete_source, $extra = '' ){
		$this->__construct( $name, $option_group,  $id, $autocomplete_source, $extra );
	}
	
	function __construct( $name, $option_group, $id, $autocomplete_source, $extra = '' ){
		
		$textfield = array(
			'id' => $id,
			'option_group' => $option_group,
			'extra' => $extra
		);
		parent::__construct( $name, $textfield );
		
		$this->id = $id;
		$this->autocomplete_source = $autocomplete_source;
	}
	
	function get_html(){
		$html = parent::get_html();
		
		$html .= '
			<script type="text/javascript">
			  	jQuery(document).ready(function($){
				  	function split( val ) {
						return val.split( / \s*/ );
					}
					function extractLast( term ) {
						return split( term ).pop();
					}
					
					var cache = {},
					lastXhr;
					
					$(\'#' . $this->id . '\')						
						.autocomplete({
							source: function( request, response ) {
								$.getJSON( "' . $this->autocomplete_source . '", {
									term: extractLast( request.term )
								}, response );
							},
							search: function( event, ui ) {
								// custom minLength
								var term = extractLast( this.value );
								var terms = split( this.value );
								
								var found = false;
								for (var i = 0; i < terms.length; ++i){
									var myRegExp = term;
									if( terms[i].search(myRegExp) != -1 ){
										found = true;
									}
								}
								
								if( found == false ){
									return false;
								}
								
								if ( term.length < 2 ) {
									return false;
								}
							},
							focus: function() {
								// prevent value inserted on focus
								return false;
							},
							select: function( event, ui ) {
								var terms = split( this.value );
								// remove the current input
								terms.pop();
								// add the selected item
								terms.push( ui.item.value );
								// add placeholder to get the comma-and-space at the end
								terms.push( "" );
								this.value = terms.join( " " );
								return false;
							},
							delay: 1000
						})
						.data( "autocomplete" )._renderItem = function( ul, item ) {
							return $( "<li></li>" )
								.data( "item.autocomplete", item )
								.append( "<a><strong>" + item.value + "</strong><br>" + item.desc + "</a>" )
								.appendTo( ul );
						};
			  	});
	  		</script>
	  	';	
		
	  	return $html;
	  
	}
}
function tk_jqueryui_autocomplete( $name, $option_group, $id, $autocomplete_source, $extra = '' ){
	$autocomplete = new TK_Jqueryui_Autocomplete( $name, $option_group, $id, $autocomplete_source, $extra );
	return $autocomplete->get_html();
}