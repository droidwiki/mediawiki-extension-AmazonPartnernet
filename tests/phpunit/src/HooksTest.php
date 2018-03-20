<?php

namespace MediaWiki\Extension\AmazonPartnernet;

class HooksTest extends \MediaWikiTestCase {
	private $someText = '';
	private $someLink = '';

	public function setUp() {
		parent::setUp();
		$this->setMwGlobals( [
			'wgAmazonPartnernetPartnerID' => '123'
		] );
	}

	public function testReplacesAmazonHttpLink() {
		$actualUrl = 'http://www.amazon.de/B0000/link';

		Hooks::onLinkerMakeExternalLink( $actualUrl, $someText, $someLink );

		$this->assertEquals( 'http://www.amazon.de/B0000/link?tag=123', $actualUrl );
	}

	public function testReplacesAmazonHttpsLink() {
		$actualUrl = 'https://www.amazon.de/B0000/link';

		Hooks::onLinkerMakeExternalLink( $actualUrl, $someText, $someLink );

		$this->assertEquals( 'https://www.amazon.de/B0000/link?tag=123', $actualUrl );
	}

	public function testReplacesAmazonLinkWithoutWww() {
		$actualUrl = 'https://amazon.de/B0000/link';

		Hooks::onLinkerMakeExternalLink( $actualUrl, $someText, $someLink );

		$this->assertEquals( 'https://amazon.de/B0000/link?tag=123', $actualUrl );
	}

	public function testDoesNotReplaceNonAmazonLink() {
		$actualUrl = 'https://google.de/link';

		Hooks::onLinkerMakeExternalLink( $actualUrl, $someText, $someLink );

		$this->assertEquals( 'https://google.de/link', $actualUrl );
	}

	public function testReplacesAmazonLinkWithParameter() {
		$actualUrl = 'https://www.amazon.de/B0000/link?action=test';

		Hooks::onLinkerMakeExternalLink( $actualUrl, $someText, $someLink );

		$this->assertEquals( 'https://www.amazon.de/B0000/link?action=test&tag=123', $actualUrl );
	}
}
