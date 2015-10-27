<!DOCTYPE html>
<html>
<head>
	<title>Registration Form</title>
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
	<?php
	include_once 'db_functions.php';
	include('session.php');

	if(strtolower($login_name) !== "admin"){
		header("location: profile.php");
	}
	
	$db = new DB_Functions();
	?>
	<br />
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Register
						<img style="float:right;" src="img/logo.png">
					</div>
					<br />
					<br />
					<div class="panel-body">



						<form class="form-horizontal" role="form" method="POST" action="register.php">


							<div class="form-group">
								<label class="col-md-4 control-label">Name</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="Name" value="">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">E-Mail Address</label>
								<div class="col-md-6">
									<input type="email" class="form-control" name="Email" value="">
								</div>
							</div>

							<div class="form-group" hidden>
								<label class="col-md-4 control-label">Password</label>
								<div class="col-md-6">
									<input type="password" class="form-control" name="Password">
								</div>
							</div>

							<div class="form-group" hidden>
								<label class="col-md-4 control-label">Confirm Password</label>
								<div class="col-md-6">
									<input type="password" class="form-control">
								</div>
							</div>

							

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="submit" class="btn btn-success">
										Register
									</button>
								</div>
							</div>
						</form>
						<?php 

						if(isset($_POST["Name"]))	
						{
							if(strtolower($_POST["Name"]) !== "admin"){
								$result = $db->insertUser($_POST);
								if(!$result)
									echo('<span style="color:red">Email or Name Already Registered<span>');
								else
									header("location: users.php");

							}
							else
								echo('<span style="color:red">Name admin is not allowed<span>');

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