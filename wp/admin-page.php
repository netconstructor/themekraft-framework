<?php

class TK_Admin_Pages extends TK_HTML{
	
	var $menu_title;
	var $page_title;
	var $capability;
	var $menu_slug;
	var $icon_url;
	var $position;
	var $object_menu;
	
	var $count_autoslug;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $headline , $icon Path to icon on Page, $parent_slug Parent slug where menue appears, $page_title, $menue_title, $capability, $menue_slug ]
	 */
	function tk_wp_admin_pages( $args = array()  ){
		$this->__construct( $args );
	}
	
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $headline , $icon Path to icon on Page, $parent_slug Parent slug where menue appears, $page_title, $menue_title, $capability, $menue_slug ]
	 */
	function __construct( $args = array() ){
		$defaults = array(
			'menu_title' => '',
			'page_title' => '',
			'capability' => 'edit_posts',
			'menu_slug' => '',			
			'icon_url' => '',
			'position' => '',
			'object_menu' => TRUE 	
		);
		
		$args = wp_parse_args($args, $defaults);
		extract( $args , EXTR_SKIP );
		
		parent::__construct();
		
		$this->menu_title = $menu_title;
		$this->page_title = $page_title;
		$this->capability = $capability;
		$this->menu_slug = $menu_slug;
		$this->icon_url = $icon_url;
		$this->position = $position;
		$this->object_menu = $object_menu;
		
		$count_autoslug = 0;
	}
	
	function add_page( $menu_title, $page_title, $content, $args = array() ){

		$defaults = array(
			'parent_slug' => $this->menu_slug,
			'headline' => '',
			'icon_url' => '',			
			'capability' => 'edit_posts',
			'menu_slug' => 'autoslug_' . $this->count_autoslug++
		);
		
		$args = wp_parse_args($args, $defaults);
		extract( $args , EXTR_SKIP );
		
		$element = array( 
			'parent_slug'=> $parent_slug,
			'menu_title'=> $menu_title,
			'page_title' => $page_title, 
			'headline' => $headline, 
			'content' => $content, 
			'icon_url' => $icon_url,
			'capability' => $capability, 
			'menu_slug' => $menu_slug
		);
		
		$this->add_element( $element );
	}
	
	/**
	 * Getting HTML of admin page
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @return string $html The HTML of the admin page
	 */
	function get_html(){
		
		// If menu slug is empty sanitize title name and use it as slug
		if( $this->menu_slug == '' && $this->menu_title != '' ){
			$this->menu_slug =  sanitize_title( $this->menu_title  );
		}
		// If Page title is empty use menu title as page title
		if( $this->page_title == '' && $this->menu_title != '' ){
			$this->page_title = $this->menu_title;
		}	
		
		$i = 0; 		
		foreach( $this->elements AS $element ){
			$page_object[ $element['menu_slug'] ] = new TK_Admin_Page_Creator( $element['menu_slug'], $element['content'] , $element['headline'] , $element['icon_url'] );
			
			// Setting up main menu elements if title and capability is given 
			if( ( $this->menu_title != '' && $this->capability != '' ) && $i == 0 ){
				if( TRUE == $this->object_menu ){
					add_object_page( $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, array( $page_object[ $element['menu_slug'] ] , 'create_page' ), $this->icon_url, $this->position );	
				}else{
					add_menu_page( $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, array( $page_object[ $element['menu_slug'] ] , 'create_page' ), $this->icon_url, $this->position );
				}
			}
			
			// If slug of submenu is empty, sanitize title ans use it as slug
			if( $element['menu_slug'] == '' ){
				$element['menu_slug'] = sanitize_title( $element['page_title'] );
			}
			
			// Recovering double entry in menu by setting menu_slug of first element
			if( $i == 0 && substr( $element['menu_slug'], 0, 8 ) == 'autoslug' ){
				$menu_slug = $this->menu_slug;
			}else{
				$menu_slug = $element['menu_slug'];
			}
			
			// If no parent slug of element is given by param, use menu slug of main menu
			if( $element['parent_slug'] == '' ){
				$element['parent_slug'] = $this->menu_slug;
			} 
			
			add_submenu_page( $element['parent_slug'], $element['page_title'], $element['menu_title'], $element['capability'], $menu_slug, array( $page_object[ $element['menu_slug'] ] , 'create_page' ) );
			
			$i++;
		}		
	}	
}
class TK_Admin_Page_Creator{
	var $content;
	var $menu_slug;
	var $headline;
	var $icon_url;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $headline ... ]
	 */
	function tk_page_creator( $menu_slug, $content, $headline = '', $icon_url = '' ){
		$this->__construct( $menu_slug, $content, $headline, $icon_url );
	}
	/**
	 * PHP 5 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $headline , $icon Path to icon on Page, $parent_slug Parent slug where menue appears, $page_title, $menue_title, $capability, $menue_slug ]
	 */
	function __construct(  $menu_slug, $content, $headline = '', $icon_url = '' ){
		$this->content = $content;
		$this->menu_slug = $menu_slug;
		$this->headline = $headline;
		$this->icon_url = $icon_url;
	}
	
	function create_page(){
		$html = '<div class="wrap">';
		if( $this->icon_url != '' )	$html.= '<div class="icon32" style="background-image: url(' . $this->icon_url . ');"></div>';
		
		$html = apply_filters( 'tk_admin_page_before_title', $html );
		
		if( $this->menue_slug != '' ) $html = apply_filters( 'tk_admin_page_before_title_' . $this->menue_slug , $html );
		
		$html.= '<h2>' . $this->headline . '</h2>';
		$html = apply_filters( 'tk_admin_page_before_content', $html );
		
		if( $this->menue_slug != '' ) $html = apply_filters( 'tk_admin_page_before_content_' . $this->menue_slug , $html );
		
		$tkdb = new TK_Display();
		$html.= $tkdb->get_html( $this->content );
		unset( $tkdb );
		
		$html = apply_filters( 'tk_admin_page_after_content', $html );
		
		if( $this->menue_slug != '' ) $html = apply_filters( 'tk_admin_page_after_content_' . $this->menue_slug , $html );
		
		$html.= '</div>';
		
		echo $html;
	}	
}
function tk_admin_pages( $elements = array(), $args = array(), $return_object = FALSE ){
	$tabs = new	TK_Admin_Pages( $args );
	
	foreach ( $elements AS $element ){
		$element['args'] = array(
			'headline' => $element['headline'],
			'icon_url' => $element['icon_url'] 
		);		
		$tabs->add_page( $element['menu_title'], $element['page_title'], $element['content'], $element['args'] );
	}

	if( TRUE == $return_object ){
		return $tabs;
	}else{
		return $tabs->get_html();
	}
}