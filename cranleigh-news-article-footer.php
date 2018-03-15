<?php
/*
Plugin Name: Cranleigh News Article Footer
Description: Adds a footer to each news item that promotes something you want (set in settings)
Author: Fred Bradley (frb@cranleigh.org)
Version: 1.2
Author URI: http://www.cranleigh.org
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';


new \FredBradley\NewsArticleFooter\Plugin();
