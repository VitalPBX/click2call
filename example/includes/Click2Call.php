<?php

namespace Click2Call\Example;

use Click2Call\restClient;

require_once( __DIR__ . '/../../vendor/autoload.php' );

/**
 * Class Click2Call
 */
class Click2Call{
	private $_caller;
	private $_callee;
	private $_cos_id;

	public function __construct($caller, $callee, $cos_id = 1){
		$this->_caller = $caller;
		$this->_callee = $callee;
		$this->_cos_id = $cos_id;
	}

	/**
	 * Perform the call
	 */
	public function call(){
		$c = new restClient();

		$c->setTenant('VitalPBX');

		$c->POST('core/click_to_call', [
			'caller' => $this->_caller,
			'callee' => $this->_callee,
            'cos_id' => $this->_cos_id
		]);
	}
}