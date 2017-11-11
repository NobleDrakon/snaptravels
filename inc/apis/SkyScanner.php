<?php

///////////////////////
// SNAPTRAVELS
///////////////////////

/* 
SkyScanner.php
API Class to connect and interact to Places and Flights SkyScanner API
*/

// Require RestApi Class
require_once('RestApi.php');

// Require config
require_once(__DIR__ . '/../config.php'); 

class SkyScannerApi extends RestApi
{
	private $apiKey = '';
	private $endpointURL = 'http://partners.api.skyscanner.net/apiservices/';
	private $country = '';
	private $currency = '';
	private $locale = '';
	private $guzzleClient;

	public function __construct($apiKey, $country, $currency, $locale) {
		$this->apiKey = $apiKey;
		$this->country = $country;
		$this->currency = $currency;
		$this->locale = $locale;

		$this->guzzleClient = new GuzzleHttp\Client(['base_uri' => $this->endpointURL]);
	}

	public function getPlaceByQuery($query) {
		
		// Create url to send request to
		$url = $this->endpointURL . 'autosuggest/v1.0/' . $this->country . '/' . $this->currency . '/' . $this->locale . '/';

		// Run Query and return results
		return $this->get($url, [
			'query' => $query,
			'apiKey' => $this->apiKey
		]);
	}

	public function getFlights($origin, $destination, $outboundDate) {
		
		// GET SESSION TOKEN
		// Create post fields
		$fields = array(
			'adults' => 1,
			'apiKey' => $this->apiKey,
			'country' => $this->country,
			'currency' => $this->currency,
			'destinationPlace' => $destination,
			'locale' => $this->locale,
			'locationSchema' => 'sky',
			'originPlace' => $origin,
			'outboundDate' => $outboundDate
		);

		try {
			// Send request
			$res = $this->guzzleClient->request('POST', 'pricing/v1.0/', [
				'form_params' => $fields
			]);
			// Run Query and return results
			return $res->getHeader('location');
			
		} catch (RequestException $e) {
			echo Psr7\str($e->getRequest());
			if ($e->hasResponse()) {
				echo Psr7\str($e->getResponse());
			}
		}
	
	}
	
}
