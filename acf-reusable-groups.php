<?php

/*
Plugin Name: Advanced Custom Fields: Reusable Group Field
Plugin URI: https://github.com/elliotcondon/acf-location-field
Description: Adds a Location field to Advanced Custom Fields. This field allows you to find addresses and coordinates of a desired location.
Version: 1.0.0
Author: Elliot Condon
Author URI: http://advancedcustomfields.com/
License: GPL
*/


class acf_field_reusable_group_plugin
{
	/*
	*  Construct
	*
	*  @description: 
	*  @since: 3.6
	*  @created: 1/04/13
	*/
	
	function __construct()
	{
		// set text domain
		$domain = 'acf-reusable-group-field';
		$mofile = trailingslashit(dirname(__File__)) . 'lang/' . $domain . '-' . get_locale() . '.mo';
		load_textdomain( $domain, $mofile );
		
		
		// version 4+
		add_action('acf/register_fields', array($this, 'register_fields'));	

		
		// version 3-
		add_action( 'init', array( $this, 'init' ));
	}
	
	
	/*
	*  Init
	*
	*  @description: 
	*  @since: 3.6
	*  @created: 1/04/13
	*/
	
	function init()
	{
	}
	
	/*
	*  register_fields
	*
	*  @description: 
	*  @since: 3.6
	*  @created: 1/04/13
	*/
	
	function register_fields()
	{
		include_once('reusable-groups-v4.php');
	}
	
}

new acf_field_reusable_group_plugin();