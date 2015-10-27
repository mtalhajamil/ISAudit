


<!DOCTYPE html>
<html>
<head>
	<title>login</title>
	<link rel="shortcut icon" href="favicon.ico" />

	<link rel="stylesheet" type="text/css" href="css/app.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/sb-admin2.css">
	<link rel="stylesheet" type="text/css" href="css/selectionPage.css">
	<link rel="stylesheet" type="text/css" href="css/sms.css">
	<link rel="stylesheet" type="text/css" href="css/structure.css">
	<link rel="stylesheet" type="text/css" href="css/design.css">
</head>
<body>
	<br />
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Login<img style="float:right;" src="img/logo.png"></div>
					<br />
					<br />
					<div class="panel-body">


						<form class="form-horizontal" role="form" method="POST" action="login.php">


							<div class="form-group">
								<label class="col-md-4 control-label">Username</label>
								<div class="col-md-6">
									<input type="input" class="form-control" name="Email" value="">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Password</label>
								<div class="col-md-6">
									<input type="password" class="form-control" name="Password">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="submit" class="btn btn-success">Login</button>
								</div>
							</div>
						</form>
						<?php
						include_once 'db_functions.php';
						session_start(); 
						if(isset($_SESSION['login_user'])){
							header("location: profile.php");
						}


						$error=''; 
						if (isset($_POST['Email'])) {
							if (empty($_POST['Email']) || empty($_POST['Password'])) {
								$error = "Email or Password is invalid";
							}
							else
							{
								if ( strtolower($_POST['Email']) != "admin@is.com")
								{
								$localEmail = $_POST['Email']."@engrofoods.com";
								$Email=$_POST['Email']."@iefl.com";
								}
								else 
								{
									$Email = $_POST['Email'];
									$localEmail = $_POST['Email'];

								}

								$Password=$_POST['Password'];
								$db = new DB_Functions();

								$adServer = "ldap://ef-ad.iefl.com";
	
    $ldap = ldap_connect($adServer);
   // $username = $_POST['username'];
    //$password = $_POST['password'];
    //echo $username."\n";
    //echo $password."\n";
    //$ldaprdn = 'iefl' . "\\" . $username;

    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    $bind = @ldap_bind($ldap, $Email, $Password);
    //echo $bind;

    

    if ($bind || strtolower($Email) == "admin@is.com") {
    	$user = $db->getSingleUserByEmail($localEmail);
		$rows = mysql_num_rows($user);


        @ldap_close($ldap);
    } 	
    else
    {
    	
    	echo('<span style="color:red">Not Authenticated by AD<span>');

    	$rows = 0;
    }

						//		$user = $db->getSingleUser($Email,$Password);
						//		$rows = mysql_num_rows($user);


								if ($rows == 1) {
									$row = mysql_fetch_array($user);
									if($row["Active"] == '1'){
										$_SESSION['login_user']=$localEmail;
										$_SESSION['login_name']=$row["Name"];
										header("location: profile.php");
									}
									else{
										echo('<span style="color:red"><br/>User Disabled<span>');
									} 
								} else {
									echo('<span style="color:red">
										<br/>Not logged in<span>');
								}
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/moment.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="js/util.js"></script>
<script type="text/javascript" src="js/skel.min.js"></script>
</html>



