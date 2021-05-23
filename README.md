# VitalPBX Click2Call
This is a simple example to demonstrate how to implement click2call feature using VitalPBX API.

- **[How to install it](#how-to-install-it)**
- **[How to configure it](#how-to-configure-it)**
- **[Notes](#notes)**

## How to install it

This section contains the required steps to install this app on your VitalPBX.

- Download git package
```
yum install git -y
```

- Clone the project
```
cd /usr/share
git clone https://github.com/VitalPBX/click2call.git click2call
```

- Build the project
```
cd /usr/share/click2call
make install
```

## How to configure it

This section contains the required steps for configuring the application.

- Go to the project
```
cd /usr/share/click2call/www
```
- Edit the configuration file
```
nano includes/Config.php
```

Here, you must define your API Key (Generated on VitalPBX), the extension number from where the calls will be performed, 
and the list of numbers to be called.

```php
<?php
class Config{
	const API_KEY = 'YOUR_API_KEY';
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
```

- Go to the project
```
cd /usr/share/click2call/www
```
- Edit the configuration file
```
nano includes/resClient.php
```

```php
public $baseURL = 'https://localhost/api/v2';
```

## Notes
For further information about VitalPBX's API, visit the following link: [API Documentation](https://rebrand.ly/qnwtalw)

[VitalPBX WebSite](https://vitalpbx.org) | [Professional Support](https://vitalpbx.org/product/professional-support-packages/) | [VitalPBX Community](https://community.vitalpbx.org/)
