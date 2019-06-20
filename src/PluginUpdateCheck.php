<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 24/07/2017
 * Time: 13:43
 */

namespace FredBradley\NewsArticleFooter;

use Puc_v4_Factory;

class PluginUpdateCheck {

	public function __construct( string $plugin_name, string $user = 'cranleighschool' ) {

		$this->update_check( $plugin_name, $user );
	}

	/**
	 * @param string $plugin_name
	 */
	private function update_check( string $plugin_name, string $user ) {

		$updateChecker = Puc_v4_Factory::buildUpdateChecker(
			'https://github.com/' . $user . '/' . $plugin_name . '/',
			dirname( dirname( __FILE__ ) ) . '/' . $plugin_name . '.php',
			$plugin_name
		);

		/* Add in option form for setting auth token*/
		$updateChecker->setAuthentication( '71eba4bd625dcb30ca80e291426daa2201ec3270' );

		$updateChecker->setBranch( 'master' );
	}
}
