<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
require_once 'CurlHelper.php';
require_once 'Settings.php';
class Operations {
	public static function connect() {
		$auth_url = "https://login.microsoftonline.com/" . Settings::$appTenantID . "/oauth2/token";
		$query_params = array(
			"grant_type" => "client_credentials",
			"client_id" => Settings::$appClientId,
			"client_secret" => Settings::$appSecret,
			"resource" => Settings::$resourceEndpoint,
		);
		$curl = new CurlHelper($auth_url);
		$response = $curl->post($query_params);
		$response = json_decode($response);
		if (isset($response->{'error'})) {
			echo "<h4>" . json_encode((array) $response) . "</h4>";
		} else {
			$_SESSION['access_token'] = $response->{'access_token'};
		}
	}
	public static function disconnect() {
		unset($_SESSION['access_token']);
	}
	public static function getUser($id = null) {
		$base_endpoint = "https://graph.microsoft.com/" . Settings::$apiVersion . "/users";
		$base_endpoint = $id ? $base_endpoint . "/{$id}" : $base_endpoint;
		$headers = array(
			"Authorization" => "Bearer" . " " . $_SESSION['access_token'],
			"Content-Type" => "application/json",
		);
		$url_params = array('$select' => 'accountEnabled,id,displayName,userPrincipalName');
		$curl = new CurlHelper($base_endpoint);
		$curl->setHeaders($headers);
		$response = $curl->get($url_params);
		$response = json_decode($response);
		if ($id) {
			return $response;
		} else {
			return $response->{'value'};
		}
	}
	public static function addUser($data) {
		$base_endpoint = "https://graph.microsoft.com/" . Settings::$apiVersion . "/users";
		$headers = array(
			"Authorization" => "Bearer" . " " . $_SESSION['access_token'],
			"Content-Type" => "application/json",
		);
		$data['accountenabled'] = (bool) $data['accountenabled'];
		$data['forceChangePasswordNextSignIn'] = (bool) $data['forceChangePasswordNextSignIn'];
		$data['passwordProfile'] = array(
			"password" => $data['password'],
			"forceChangePasswordNextSignIn" => $data['forceChangePasswordNextSignIn'],
		);
		unset($data['password']);
		unset($data['forceChangePasswordNextSignIn']);
		$curl = new CurlHelper($base_endpoint);
		$curl->setHeaders($headers);
		$response = $curl->post($data);
		return $response;
	}
	public static function editUser($id, $data) {
		$base_endpoint = "https://graph.microsoft.com/" . Settings::$apiVersion . "/users/" . $id;
		$headers = array(
			"Authorization" => "Bearer" . " " . $_SESSION['access_token'],
			"Content-Type" => "application/json",
		);
		$curl = new CurlHelper($base_endpoint);
		$curl->setHeaders($headers);
		$response = $curl->patch($data);
		return $response;
	}
	public static function delUser($id) {
		$base_endpoint = "https://graph.microsoft.com/" . Settings::$apiVersion . "/users/" . $id;
		$headers = array(
			"Authorization" => "Bearer" . " " . $_SESSION['access_token'],
		);
		$curl = new CurlHelper($base_endpoint);
		$curl->setHeaders($headers);
		$response = $curl->delete($base_endpoint);
		return $response;
	}
}
