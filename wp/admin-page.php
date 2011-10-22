<?php

class TK_Admin_Page extends TK_HTML{
	
	var $headline;
	var $icon;
	var $menu_slug;
	
	/**
	 * PHP 4 constructor
	 *
	 * @package Themekraft Framework
	 * @since 0.1.0
	 * 
	 * @param array $args Array of [ $headline , $icon Path to icon on Page, $parent_slug Parent slug where menue appears, $page_title, $menue_title, $capability, $menue_slug ]
	 */
	function tk_wp_admin_page( $args ){
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
	function __construct( $args ){
		$defaults = array(
			'headline' => '',
			'icon' => '',
			'parent_slug' => '',
			'page_title' => '',
			'menue_title' => '',
			'capability' => '',
			'menue_slug' => ''		
		);
		
		$args = wp_parse_args($args, $defaults);
		extract( $args , EXTR_SKIP );
		
		parent::__construct();
		$this->headline = $headline;
		$this->icon = $icon;
		$this->menu_slug = $menu_slug;
		
		if( $parent_slug != '' && $page_title != '' && $menu_title != '' && $capability != '' && $menu_slug != '' ){
			add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, array( $this, 'write_html' ) );
		}
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
		
		$html = '<div class="wrap">';
		if( $this->icon != '' )	$html.= '<div id="icon-' . $this->icon . '" class="icon32"></div>';
		
		$html = apply_filters( 'tk_wp_admin_page_before_title', $html );
		if( $this->menu_slug != '' ) $html = apply_filters( 'tk_wp_admin_page_before_title_' . $this->menu_slug , $html );
		$html.= '<h2>' . $this->headline . '</h2>';
		$html = apply_filters( 'tk_wp_admin_page_before_content', $html );
		if( $this->menu_slug != '' ) $html = apply_filters( 'tk_wp_admin_page_before_content_' . $this->menu_slug , $html );
		$html.= parent::get_html();
		$html = apply_filters( 'tk_wp_admin_page_after_content', $html );
		if( $this->menu_slug != '' ) $html = apply_filters( 'tk_wp_admin_page_after_content_' . $this->menu_slug , $html );
		$html.= '</div>';
		
		return $html;
	}
}