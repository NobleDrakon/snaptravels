<?php

///////////////////////
// SNAPTRAVELS
///////////////////////

/* 
RestApi.php
Simple Class to sent HTTP requests and recieve responses for REST API
*/

class RestApi
{

	protected function get($endpoint, $params) {

		// Set url from supplied endpoint
		$url = $endpoint;

		// If url parameters supplied, append to url
		if ($params) {
			$url .= '?' . http_build_query($params);
		}

		// Initialise cURL
		$ch = curl_init();
		
		// Set cURL options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
		// Assign response to variable
		$response = curl_exec ($ch);

		// Close cURL session
		curl_close ($ch);
	
		// Return respones
		return $response;

	}

	protected function post($endpoint, $fields, $params = false, $headers = false) {
		
		// Set url from supplied endpoint
		$url = $endpoint;

		// If url parameters supplied, append to url
		if ($params) {
			$url .= '?' . http_build_query($params);
		}

		// Initialise cURL
		$ch = curl_init();
		
		// Set cURL options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// If headers requested, return associative array of header and body
		if ($headers) {
			curl_setopt($ch, CURLOPT_HEADER, true);
		}
	
		// Assign response to variable
		$response = curl_exec ($ch);

		// Close cURL session
		curl_close ($ch);
	
		// Return respones
		return $response;

	}
	
}
