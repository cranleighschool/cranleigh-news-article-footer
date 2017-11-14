<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 14/11/2017
 * Time: 09:10
 */

namespace FredBradley\NewsArticleFooter;

use WeDevs_Settings_API;

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */
class Settings {

	private $settings_api;

	function __construct() {

		$this->settings_api = new WeDevs_Settings_API;

		add_action( 'admin_init', [ $this, 'admin_init' ] );
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
	}

	function admin_init() {

		//set the settings
		$this->settings_api->set_sections( $this->get_settings_sections() );
		$this->settings_api->set_fields( $this->get_settings_fields() );

		//initialize settings
		$this->settings_api->admin_init();
	}

	function get_settings_sections() {

		$sections = [
			[
				'id'    => 'news_article_settings',
				'title' => __( 'News Article Footer', 'cranleigh-2016' )
			],
		];

		return $sections;
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	function get_settings_fields() {

		$settings_fields = [
			'news_article_settings' => [
				[
					'name'    => 'footer_text',
					'label'   => __( 'News Article Text', 'wedevs' ),
					'desc'    => __( "Don't bother putting HTML Tags in here", 'wedevs' ),
					'type'    => 'textarea',
					'default' => "Life at Cranleigh is always busy! For regular updates on everything that happens at school please follow us on Facebook or Twitter."
				],
				$this->socialURIField( 'twitter' ),
				$this->socialURIField( 'facebook' )
			],
		];

		return $settings_fields;
	}

	public function socialURIField( string $network ) {

		return [
			"name"  => $network . "URI",
			"label" => __( ucwords( $network ) . " URI", 'cranleigh-2016' ),
			"text"  => "text"
		];
	}

	function admin_menu() {

		add_options_page( 'News Post Footer', 'News Post Footer', 'edit_posts', 'NewsArticleFooterSettings',
			[ $this, 'plugin_page' ] );
	}

	function plugin_page() {

		echo '<div class="wrap">';

		$this->settings_api->show_navigation();
		$this->settings_api->show_forms();

		echo '</div>';
	}

	/**
	 * Get all the pages
	 *
	 * @return array page names with key value pairs
	 */
	function get_pages() {

		$pages         = get_pages();
		$pages_options = [];
		if ( $pages ) {
			foreach ( $pages as $page ) {
				$pages_options[ $page->ID ] = $page->post_title;
			}
		}

		return $pages_options;
	}

}
