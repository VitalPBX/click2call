<?php

namespace Click2Call;

use Dotenv\Dotenv;

require_once( __DIR__ . '/../vendor/autoload.php' );

class restClient{
	protected $baseURL;
	protected $APIKey;
	protected $tenant;

	/**
	 * restClient constructor.
	 */
	public function __construct(){

        // load environment variables...
        if( file_exists(__DIR__ . '/../.env') ) {
            $env_file = '.env';
        } else {
            echo 'No environment file is configured for the current application environment (.env)';
            exit;
        }

        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

		$this->APIKey = $_SERVER['API_KEY'];
		$this->baseURL = $_SERVER['API_URL'];
	}

	/**
	 * Set tenant ID or path to retrieve information of a specific tenant.
	 * If the APIKey is associated to a specific tenant, this parameter is ignored
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
		}catch (\Exception $e){
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