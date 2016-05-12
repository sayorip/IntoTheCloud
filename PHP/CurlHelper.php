<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
class CurlHelper {
	public $curl; // curl instance
	public $baseUrl;
	public $url;
	public $options; //curl options
	public $headers;
	public $response;
	public function __construct($base_url = null) {
		$this->curl = curl_init();
		$this->setOpt(CURLOPT_RETURNTRANSFER, true);
		$this->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$this->setURL($base_url);
	}
	public function setOpt($option, $value) {
		$required_options = array(
			CURLOPT_RETURNTRANSFER => 'CURLOPT_RETURNTRANSFER',
		);
		if (in_array($option, array_keys($required_options), true) && !($value === true)) {
			trigger_error($required_options[$option] . ' is a required option', E_USER_WARNING);
		}
		$this->options[$option] = $value;
		return curl_setopt($this->curl, $option, $value);
	}
	public function setURL($url, $data = array()) {
		$this->baseUrl = $url;
		$this->url = $this->buildURL($url, $data);
		$this->setOpt(CURLOPT_URL, $this->url);
	}
	public function setHeader($key, $value) {
		$this->headers[$key] = $value;
		$headers = array();
		foreach ($this->headers as $key => $value) {
			$headers[] = $key . ': ' . $value;
		}
		$this->setOpt(CURLOPT_HTTPHEADER, $headers);
	}
	public function setHeaders($headers) {
		foreach ($headers as $key => $value) {
			$this->setHeader($key, $value);
		}
	}
	private function buildURL($url, $data = array()) {
		return $url . (empty($data) ? '' : '?' . http_build_query($data));
	}
	private function buildRequstBody($data = array()) {
		return json_encode($data);
	}
	public function get($url, $data = array()) {
		if (is_array($url)) {
			$data = $url;
			$url = $this->baseUrl;
		}
		$this->setURL($url, $data);
		$this->setOpt(CURLOPT_CUSTOMREQUEST, 'GET');
		$this->setOpt(CURLOPT_HTTPGET, true);
		return $this->exec();
	}
	public function patch($url, $data = array()) {
		if (is_array($url)) {
			$data = $url;
			$url = $this->baseUrl;
		}
		if (is_array($data) && empty($data)) {
			$this->unsetHeader('Content-Length');
		}
		if (isset($this->headers['Content-Type']) && $this->headers['Content-Type'] == "application/json") {
			$data = $this->buildRequstBody($data);
		}
		$this->setURL($url);
		$this->setOpt(CURLOPT_CUSTOMREQUEST, 'PATCH');
		$this->setOpt(CURLOPT_POSTFIELDS, $data);
		return $this->exec();
	}
	public function post($url, $data = array()) {
		if (is_array($url)) {
			$data = $url;
			$url = $this->baseUrl;
		}
		if (isset($this->headers['Content-Type']) && $this->headers['Content-Type'] == "application/json") {
			$data = $this->buildRequstBody($data);
		}
		$this->setURL($url);
		$this->setOpt(CURLOPT_CUSTOMREQUEST, 'POST');
		$this->setOpt(CURLOPT_POST, true);
		$this->setOpt(CURLOPT_POSTFIELDS, $data);
		return $this->exec();
	}
	public function delete($url, $query_parameters = array()) {
		if (is_array($url)) {
			$data = $query_parameters;
			$query_parameters = $url;
			$url = $this->baseUrl;
		}
		$this->setURL($url, $query_parameters);
		$this->setOpt(CURLOPT_CUSTOMREQUEST, 'DELETE');
		return $this->exec();
	}
	public function exec() {
		$this->response = curl_exec($this->curl);
		curl_close($this->curl);
		return $this->response;
	}
}