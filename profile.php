<?php
include('session.php');
include_once 'db_functions.php';

function usersList(){
	$db = new DB_Functions();
	$users = $db->getAllUsers();
	if ($users != false)
		$no_of_users = mysql_num_rows($users);
	else
		$no_of_users = 0;

	echo('<li><a>NA</a></li>');
	if ($no_of_users > 0) {
		while ($row = mysql_fetch_array($users)) {
			echo('<li><a >'.$row["Name"].'</a></li>');
		}
	} else {  
		echo ('<li>No Users Registered Yet!</li>');
	} 
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
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
					<div class="panel-heading">Your Profile[<a href="logout.php">Log Out</a>]
						<img style="float:right;" src="img/logo.png">
					</div>
					<br />
					<br />
					<div class="panel-body">

						<div class="form-group">
							<label class="col-md-4 control-label">Name</label>
							<div class="col-md-6">
								<label class="col-md-4 control-label"><?php echo $login_name; ?></label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Email</label>
							<div class="col-md-6">
								<label class="col-md-4 control-label EmailAddress"><?php echo $login_session; ?></label>
								<input id="EmailAddress" value="<?php echo $login_session; ?>" hidden></input>
								<input id="oldPassword" value="<?php echo $login_pass; ?>" hidden></input>

							</div>
						</div>

						<?php if("admin" === strtolower($login_name)){ ?>

						<div class="form-group">
							<label class="col-md-4 control-label">Change Password</label>
							<div class="col-md-6">
								<label class="col-md-4 control-label"><a href="#" data-toggle="modal" data-target="#myModal">Click</a></label>
							</div>
						</div>

						
						<div class="form-group">
							<label class="col-md-4 control-label">Replace Report Responsibility</label>
							<div class="col-md-6">
								<label class="col-md-4 control-label"><a href="#" data-toggle="modal" data-target="#replaceModal">Click</a></label>
							</div>
						</div>
						<?php } ?>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<a href="reportView.php" class="btn btn-success">Report</a>
								<?php if("admin" === strtolower($login_name)){ ?>
								<a href="users.php" class="btn btn-success">User Control</a>
								<a href="register.php" class="btn btn-success">Register</a>
								<?php } ?>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Change Password</h4>
				</div>
				<div class="modal-body">
					Old Password: <input type="password" id="oldPass" class="form-control" />
					New Password: <input type="password" id="Pass1" class="form-control" />
					Confirm New:  <input type="password" id="Pass2" class="form-control" />
				</div>
				<div class="modal-footer">
					<button type="button" id="passButton" class="btn btn-success">Change</button>
				</div>
			</div>

		</div>
	</div>

	<!-- Modal -->
	<div id="replaceModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Replace User Reports</h4>
				</div>
				<div class="modal-body">
					Replace

					<div class="dropdown">
						<button class="btn btn-success dropdown-toggle UserOld" type="button" 

						data-toggle="dropdown">Select User
						<span class="caret"></span></button>
						<input type='hidden'  id="oldNameID" class="form-control textUserOld"  />
						<ul class="dropdown-menu liUserOld">
							<?php usersList(); ?>
						</ul>
					</div>

					With

					<div class="dropdown">
						<button class="btn btn-success dropdown-toggle UserNew" type="button" 

						data-toggle="dropdown">Select User
						<span class="caret"></span></button>
						<input type='hidden' id="newNameID" class="form-control textUserNew"  />
						<ul class="dropdown-menu liUserNew">
							<?php usersList(); ?>
						</ul>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" id="replaceButton" class="btn btn-

					success">Change</button>
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
<script type="text/javascript">


	$(function(){
		$(".liUserOld li a").click(function(){
			$(".UserOld:first-child").text($(this).text());
			$(".UserOld:first-child").val($(this).text());
			$(".textUserOld").val($(this).text());
		});
	});

	$(function(){
		$(".liUserNew li a").click(function(){
			$(".UserNew:first-child").text($(this).text());
			$(".UserNew:first-child").val($(this).text());
			$(".textUserNew").val($(this).text());
		});
	});


	$('#replaceButton').click(function(){
		var oldUser = document.getElementById('oldNameID').value;
		var newUser = document.getElementById('newNameID').value;
		
		$.ajax({
			url: "posting.php", 
			type: 'POST',
			data:"replaceName=" + oldUser + "&newName=" + newUser,
			success:function(res){
				alert('Responbile Person Changed');
			},
			error: function(err){
				alert(err);
			}
		});
	});

	
	$('#passButton').click(function(){
		var A = document.getElementById('Pass1').value;
		var B = document.getElementById('Pass2').value;

		if(A === B){
			if(document.getElementById('oldPass').value === $("#oldPassword").attr('value'))
			{
				$.ajax({
					url: "posting.php", 
					type: 'POST',
					data:"ChangePassword=" + A + "&Email=" + $("#EmailAddress").attr('value') + "&Pass=" + document.getElementById('oldPass').value,
					success:function(res){alert('Password Changed');}
				});

				location.reload();
			}
			else alert('Incorrect Password');
		}
		else{
			alert('Passwords Do not Match');
		}
		
	});
	

</script>
</html>