<?php

/**
 * Class Click2Call
 */
class Click2Call{
	private $_caller;
	private $_callee;

	public function __construct($caller, $callee){
		$this->_caller = $caller;
		$this->_callee = $callee;
	}

	/**
	 * Perform the call
	 */
	public function call(){
		$c = new restClient(Config::API_KEY);
		$c->POST('core/click_to_call', [
			'caller' => $this->_caller,
			'callee' => $this->_callee
		]);
	}
}