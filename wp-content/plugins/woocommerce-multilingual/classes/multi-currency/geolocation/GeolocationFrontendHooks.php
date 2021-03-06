<?php

namespace WCML\MultiCurrency;

class GeolocationFrontendHooks implements \IWPML_Frontend_Action {

	const KEY_CLIENT_COUNTRY = 'wcml_client_country';

	public function add_hooks() {
		if ( Geolocation::isUsed() ) {
			add_action( 'init', [ self::class, 'storeUserCountry' ] );
		}
	}

	public static function storeUserCountry() {
		wcml_user_store_set( self::KEY_CLIENT_COUNTRY, Geolocation::getUserCountry() );
	}
}
