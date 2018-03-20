<?php

namespace MediaWiki\Extension\AmazonPartnernet;

use MediaWiki\MediaWikiServices;

class Hooks {
	const CONFIG_INSTANCE_NAME = 'amazonpartnernet';
	const CONFIG_PARTNERNET_ID = 'AmazonPartnernetPartnerID';
	const AMAZON_URL_REGEX = '!^http[s]?://(www\.)?amazon\.de/?!';
	const URL_TAG_NAME = 'tag';

	public static function onLinkerMakeExternalLink( &$url, &$text, &$link ) {
		if ( self::isAmazonUrl( $url ) ) {
			$url = wfAppendQuery( $url, [
				self::URL_TAG_NAME => self::getPartnerId()
			] );
		}
	}

	private static function getPartnerId() {
		return MediaWikiServices::getInstance()
			->getConfigFactory()
			->makeConfig( self::CONFIG_INSTANCE_NAME )
			->get( self::CONFIG_PARTNERNET_ID );
	}

	private static function isAmazonUrl( &$url ) {
		return preg_match( self::AMAZON_URL_REGEX, $url );
	}
}
