<?php
class restClient{
	public $baseURL = 'http://localhost/api/v2';
	public $APIKey;
	public $tenant;

	/**
	 * restClient constructor.
	 * @param string $APIKey Application key generated on VitalPBX GUI
	 */
	public function __construct($APIKey){
		$this->APIKey = $APIKey;
	}

	/**
	 * Set tenant ID or path to retrieve information of an specific tenant.
	 * If the APIKey is associated to an specific tenant, this parameter is ignored
	 * @param string $tenant
	 */
	public function setTenant($tenant){
		$this->tenant = $tenant;
	}

	/**
	 * Execute get request with given parameters.
	 * @param $action
	 * @param array $parameters
	 * @return mixed
	 */
	public function GET($action, array $parameters = []){
		if(count($parameters))
			$action .= '?'.urldecode(http_build_query($parameters));

		$url = $this->getURL($action);
		return $this->returnData($this->_sendRequest($url,'get'));
	}

	/**
	 * Execute post method with given form data
	 * @param $action
	 * @param array $data
	 * @return mixed
	 */
	public function POST($action, array $data = []){
		$url = $this->getURL($action);
		return $this->returnData( $this->_sendRequest($url,'post', $data));
	}

	/**
	 * Execute API requests
	 * @param $url
	 * @param $method
	 * @param array $data
	 * @return mixed
	 */
	private function _sendRequest($url, $method, array $data = []){
		try{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FAILONERROR, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_AUTOREFERER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Click2Call');
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				"app-key: {$this->APIKey}",
				"tenant: {$this->tenant}",
				"Content-Type: application/json"
			]);

			if($method !== "get")
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));

			if ($method === 'post') {
				curl_setopt($ch, CURLOPT_POST, count($data));
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			}

			$result = curl_exec($ch);
			$httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);

			if($httpCode !== 200 && $httpCode !== 201){
				$error = json_decode($result);
				throw new \RuntimeException($error->message);
			}

			curl_close($ch);
		}catch (Exception $e){
			throw new \RuntimeException($e->getMessage());
		}

		return json_decode($result);
	}

	/**
	 * Return API response if everything is ok, or thrown an exception if an error happens
	 * @param $apiResponse
	 * @return mixed
	 */
	protected function returnData($apiResponse){
		if($apiResponse){
			if(isset($apiResponse->status) && $apiResponse->status === 'success'){
				return $apiResponse->data;
			}else{
				throw new \RuntimeException($apiResponse->message);
			}
		}

		return null;
	}

	private function getURL($action){
		$action = trim($action);
		return $this->baseURL . '/' . $action;
	}
}