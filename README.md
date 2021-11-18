# VitalPBX Click2Call
This is a simple example to demonstrate how to implement click2call feature using VitalPBX API.

- **[How to install it](#how-to-install-it)**
- **[How to configure it](#how-to-configure-it)**
- **[How to use as a package](#how-to-use-as-a-package)**
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

- Install Composer (PHP Package Manager)
```
# install dependencies
yum install php-cli php-zip wget unzip;

# download installer script
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

# install composer
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
```

## How to configure it

This section contains the required steps for configuring the application.

- Go to the project root
```
cd /usr/share/click2call/
```
- Run composer to install PHP dependencies
```
composer install
```
- Copy the environment file
```
cp .env.example .env
```
- Edit the environment file
```
nano .env
```
Here, you must define your API Key (Generated on VitalPBX), and the base URL for your VitalPBX host
```bash
# Application key generated on VitalPBX GUI
API_KEY="YOUR_API_KEY"

# Base URL for VitalPBX host
API_URL="http://localhost/api/v2"
```
note: If you are using a site with https certificate, it is necessary to update the http:// to https:// in the API_URL.
```bash
# Base URL for VitalPBX host
API_URL="https://localhost/api/v2";
```

- Edit the configuration file
```
nano example/includes/Config.php
```

Here, you must define your username, the extension number from where the calls will be performed, 
and the list of numbers to be called.

```php
<?php
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
```

## How to use as a package
```php
<?php
    # note: This example borrows heavily from the Click2Call example class. ( example/includes/Click2Call.php )
    #   See the example class setup for further package interactions of the client side with the Click2Call class.

    use Click2Call\restClient;

    # require the (composer) vendor autoload file
    require_once( __DIR__ . '/../../vendor/autoload.php' );

    /**
     * Class ClickAndDial
     */
    class ClickAndDial {
        private $_caller;
        private $_callee;
        private $_cos_id;
        private $_cid_name;
        private $_cid_number;
    
        public function __construct( $caller, $callee, $cos_id = 1, $cid_name = null, $cid_number = null ){
            $this->_caller = $caller;
            $this->_callee = $callee;
            $this->_cos_id = $cos_id;
            $this->_cid_name = $cid_name;
            $this->_cid_number = $cid_number;
        }
    
        /**
         * Perform the call
         */
        public function call(){
            $client = new restClient( );
    
            $client->setTenant( 'VitalPBX' );
            
            $data = [
                'caller' => $this->_caller,
                'callee' => $this->_callee,
                'cos_id' => $this->_cos_id
            ]
            
            if( !empty($this->_cid_name) ) {
                $data['cid_name'] = $this->_cid_name;
            }
            
            if( !empty($this->_cid_number) ) {
                $data['cid_number'] = $this->_cid_number;
            } 
    
            $client->POST('core/click_to_call', $data);
        }
    }
```

## Notes
For further information about VitalPBX's API, visit the following link: [API Documentation](https://rebrand.ly/qnwtalw)

[VitalPBX WebSite](https://vitalpbx.org) | [Professional Support](https://vitalpbx.org/product/professional-support-packages/) | [VitalPBX Community](https://community.vitalpbx.org/)
