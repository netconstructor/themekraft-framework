<?php 
/*
Plugin Name: Themekraft framework
Plugin URI: http://themekraft.com/plugin/tk-framework
Description: Speed up your wordpress developement with our framework
Author: Sven Wagener, Sven Lehnert
Author URI: http://themekraft.com/
License: GNU GENERAL PUBLIC LICENSE 3.0 http://www.gnu.org/licenses/gpl.txt
Version: 0.1.0
Text Domain: tkframework
Site Wide Only: false
*/

function framework_init(){
 // Registering the form where the data have to be saved
 $args['forms'] = array( 'myform' );
 
 require_once( 'loader.php' );
 tk_framework( $args );
}
add_action( 'init', 'framework_init' );
 
function init_backend(){
 /*
  * WML
  */
 $wml = '<?xml version="1.0" ?>
    <wml>
     <menu title="Addresses">
      <page title="Address">
       <form name="myform">
        <textfield name="firstname" label="First name:" />
        <textfield name="lastname" label="Last name:" />
        <textfield name="street" label="Street:" />
        <textfield name="postal code" label="Postal Code:" />
        <textfield name="City" label="City:" />
        <button name="Save" />
       </form>
      </page>
     </menu>
    </wml>';
 
 tk_wml_parse( $wml );
 $values = tk_get_values( 'myform' );
}
add_action( 'admin_menu', 'init_backend' );