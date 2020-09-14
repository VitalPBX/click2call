<?php
include_once ("includes/Misc.php");
include_once ("includes/Config.php");
include_once ("includes/restClient.php");
include_once ("includes/Click2Call.php");

//Execute click2call
if(isset($_POST['caller']) && isset($_POST['callee'])){
    $caller = $_POST['caller'];
    $callee = $_POST['callee'];

	try {
		$Click2Call = new Click2Call($caller, $callee);
		$Click2Call->call();

		http_response_code(200);
		echo json_encode((object)[
            'msg' => 'Call has been successfully performed'
        ]);
	}catch (Exception $e){
        http_response_code(500);
		echo $e->getMessage();
    }

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="css/styles.css" type="text/css">
    <title>Click2Call App</title>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-info sticky-top">
        <a class="navbar-brand">
            <img src="images/logo.png" height="60" alt="click2call logo">
        </a>
        <form class="form-inline d-none d-xs-none d-md-block">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
        </form>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-right" style="line-height: 0;" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="images/avatar.png" width="50" height="50" class="profilePic" style="padding: 0; margin: 0 10px"><i class="fas fa-sort-down"></i>
                        <?php
                        echo '<span>'.Config::EXTENSION.'</span> - <span>'.Config::USERNAME.'</span>';
                        ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                        <a href="#" class="dropdown-item"><i class="fal fa-user"></i> Account</a>
                        <a href="#" class="dropdown-item"><i class="far fa-cog"></i> Settings</a>
                        <a href="#" class="dropdown-item"><i class="fad fa-sign-out"></i> Log Out</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <h1 class="text-center" style="padding-top: 50px;">Click2Call Contacts</h1>

    <?php
     //Dynamically Create the Click2Call Contacts

    $extension = Config::EXTENSION;
     foreach (Config::CUSTOMERS as $customer){
         $customer = (object) $customer;
         $visualPhone = Misc::phoneFormat($customer->phone);
	     $time = date("Y-m-d H:i:s");

         $html = <<<HTML
<div class="container" style="padding-top: 20px;">
        <div class="card flex-row flex-wrap">
            <div class="border-0 mx-auto">
                <img src="images/{$customer->image}" class="profilePic" width="150" height="150" alt="Profile Picture">
            </div>
            <div class="card-block px-2" style="width: 80%; margin: auto;">
                <h2 class="card-title">{$customer->name}</h2>
                <div class="row">
                    <div class="col-lg-8">
                        <p class="card-text">
                            Company: {$customer->company} <br>
                            Email: {$customer->email} <br>
                            Phone: {$visualPhone}
                        </p>
                    </div>
                    <div class="col-lg-4">
                        <form action="#" class="float-lg-right">
                            <div class="form-group form-inline">
                                <button type="button" name="click2call" data-phone="{$customer->phone}" data-extension="{$extension}" class="btn btn-success click2call" style="margin: 0 5px;"><i class="fas fa-phone"></i></button>
                                <a href="mailto:{$customer->email}" class="btn btn-primary" style="margin: 0 5px;"><i class="fas fa-envelope"></i></a>
                                <a href="sms:{$customer->phone}" class="btn btn-warning" style="margin: 0 5px;"><i class="fas fa-sms"></i></a>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                <div class="card-footer w-100 text-muted">
                    Added {$time}
                </div>
            </div>
</div>
HTML;

         echo  $html;
     }
    
    ?>

    <div class="fixed-bottom bg-dark" style="margin: 0; height: 74px;">
        <p class="text-light text-center" style="margin-top: 25px;;">Click2Call™ is a Registered Trademark for VitalPBX LLC.<br>VitalPBX™ © 2020</p>
    </div>


    <!-- Position it -->
    <div class="d-flex justify-content-center align-items-center" style="width:100%; min-height: 200px; position: absolute; top: 0; right: 0; z-index: 3000;">
        <!-- Then put toasts within -->
        <div id="notifications" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fa fa-phone-volume"></i>&nbsp;
                <strong class="mr-auto" id="notification-title">Click to Call</strong>
                <small class="text-muted">just now</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body" id="notification-body">
                Here Goes the body
            </div>
        </div>
    </div>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
</body>
</html>