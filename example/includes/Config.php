<?php

namespace Click2Call\Example;

class Config{
	const USERNAME = 'John Doe';
	const EXTENSION = 'YOUR_EXTENSION_NUMBER';
	const CUSTOMERS = [
		[
			'name' => 'John Smith',
			'company' => 'Luigi\'s Auto Inc.',
			'email' => 'jsmith@luigiautoinc.net',
			'phone' => '*72',
			'image' => 'john.jpg'
		],
		[
			'name' => 'Samantha Carson',
			'company' => 'Golden Nugget Ltd.',
			'email' => 'samcarson@goldennuggetltd.com',
			'phone' => '*71',
			'image' => 'samantha.jpg'
		],
		[
			'name' => 'Max Anderson',
			'company' => 'Ripple Telecom USA',
			'email' => 'max.anderson@rippletelecomusa.com',
			'phone' => '13055605776',
			'image' => 'max.jpg'
		]
	];
}