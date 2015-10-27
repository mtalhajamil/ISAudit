<!DOCTYPE html>
<html>
<head>
	<title>User Page</title>
	<link rel="shortcut icon" href="favicon.ico" />

	<link rel="stylesheet" type="text/css" href="css/app.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/sb-admin2.css">
	
	<link rel="stylesheet" type="text/css" href="css/structure.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
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
	$users = $db->getAllUsers();

	if ($users != false)
		$no_of_users = mysql_num_rows($users);
	else
		$no_of_users = 0;
	?>
	

	<div class="panel panel-default">
		<div class="panel-heading">
			Users[<a href="logout.php">Log Out From My Profile</a>]
			[<a href="profile.php">Profile</a>]
			[<a href="reportView.php">Reports</a>]
			[<a href="GRAPH/allReportGraph.php">Charts</a>]
			<img style="float:right;" src="img/logo.png">
		</div>
		<br />
		<br />
		<br />
		<br />
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="userTable">
					<thead>
						<tr>
							<th>UserID</th>
							<th>Name</th>
							<th>Email</th>
							<th hidden>Password</th>
							<th>Active</th>
							<th>Permissions</th>
							<th>Admin</th>
							<th>Auditor</th>
							<th>Notify &nbsp;<input type="checkbox" class="notifyAll"></th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if ($no_of_users > 0) {
							$counter = 1;
							while ($row = mysql_fetch_array($users)){
								if(strtolower($row["Name"]) !== "admin"){
									?>

									<tr>
										<td><?php echo $row["UserId"] ?></td>
										<td><?php echo $row["Name"] ?></td>
										<td><a href="#" class="changeEmail"><?php echo $row["Email"] ?></a></td>
										<td hidden><a href="#" class="changePassword">Change Password</a></td>
										<?php if($row["Active"]) 
										echo('<td><input type="checkbox" class="activeCheckbox" checked></td>');
										else 
											echo('<td><input type="checkbox" class="activeCheckbox"></td>');?>
										<?php if($row["Permissions"]) 
										echo('<td>RW <input type="checkbox" class="permissionCheckbox" checked></td>');
										else 
											echo('<td>RW <input type="checkbox" class="permissionCheckbox"></td>');?>
										<?php if($row["Admin"]) 
										echo('<td><input type="checkbox" class="adminCheckbox" checked></td>');
										else 
											echo('<td><input type="checkbox" class="adminCheckbox"></td>');?>
										<?php if($row["Auditor"]) 
										echo('<td><input type="checkbox" class="auditorCheckbox" checked></td>');
										else 
											echo('<td><input type="checkbox" class="auditorCheckbox"></td>');?>
										<td><input style="margin:0 auto;" type="checkbox" id="chk<?php echo $counter++ ?>" class="notifyCheckbox"></td>
										<td><a href="#" class="deleteButton">Delete</a></td>
									</tr>
									<?php }
								}
								?>
								<tr>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<!--<th></th>-->
									<th><button class="btn btn-success" id="sendButton" >Send Emails</button></th>
									<th></th>
								</tr>
								<?php
							} else { ?> 
							<li>
								No Users Registered Yet!
							</li>
							<?php } ?>
						</tbody>
					</table>


					<!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>-->

					<!-- Modal -->
				<div id="myModal" class="modal fade" role="dialog" style="z-index:5000;">
						<div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Modal Header</h4>
								</div>
								<div class="modal-body">
									<p>Some text in the modal.</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>-->

						</div>
					</div>


					<div id="sentStatus"></div>

					
				</div>

			</div>



		</body>

		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript">


		$(function(){
			$('.activeCheckbox').change(function() {
				var SNo = $(this).parent().parent().find('td:first').text();
					//alert(SNo);
					if($(this).is(":checked")) {
						editActive(SNo,'1');
					}
					else{
						editActive(SNo,'0');
					}
				});
		});

		$(function(){
			$('.permissionCheckbox').change(function() {
				var UserId = $(this).parent().parent().find('td:first').text();
				if($(this).is(":checked")) {
					editPermission(UserId,'1');
				}
				else{
					editPermission(UserId,'0');
				}
			});
		});


		$(function(){
			$('.adminCheckbox').change(function() {
				var UserId = $(this).parent().parent().find('td:first').text();
					//alert(SNo);
					if($(this).is(":checked")) {
						editAdmin(UserId,'1');
					}
					else{
						editAdmin(UserId,'0');
					}
				});
		});

		$(function(){
			$('.notifyAll').change(function() {
					//var UserId = $(this).parent().parent().find('td:first').text();
					//alert(SNo);
					if($(this).is(":checked")) {
						$("#userTable tr td:nth-child(9) input[type=checkbox]").prop("checked", true);
					}
					else{
						$("#userTable tr td:nth-child(9) input[type=checkbox]").prop("checked", false);
					}
				});
		});

		$(function(){
			$('.auditorCheckbox').change(function() {
				var UserId = $(this).parent().parent().find('td:first').text();
				if($(this).is(":checked")) {
					editAuditor(UserId,'1');
				}
				else{
					editAuditor(UserId,'0');
				}
			});
		});


		$('table#userTable .deleteButton').click(function(){
			var r = confirm("Are You Sure?");
			if (r == true) {
				var SNo = $(this).parent().parent().find('td:first').text();
				$(this).parent().parent().hide();
				$.ajax({
					url: "posting.php", 
					type: 'POST',
					data:"DeleteUserId=" + SNo,
					success:function(res){
						alert("User Deleted");
					}
				});
			} else {
				x = "You pressed Cancel!";
			}


		});

		$('table#userTable .changeEmail').click(function(){
			var mail = prompt("Change Email of: " + $(this).text(), $(this).text() );
			if (mail != null) {
				var id = $(this).parent().parent().find('td:first').text();
				
				//$(this).parent().parent().find('td').eq(2).text() = mail;
				$.ajax({
					url: "posting.php", 
					type: 'POST',
					data:"ChangeEmailId=" + id + "&NewEmailId=" + mail,
					success:function(res){
						alert("Email Changed!");
						location.reload();
					}
				});
				
			}
		});


		$('table#userTable .changePassword').click(function(){
			var mail = prompt("Change Password of: " + $(this).parent().parent().find('td').eq(1).text(), "*******" );
			if (mail != null) {
				var id = $(this).parent().parent().find('td:first').text();
				
				//$(this).parent().parent().find('td').eq(2).text() = mail;
				$.ajax({
					url: "posting.php", 
					type: 'POST',
					data:"ChangePasswordId=" + id + "&NewPassword=" + mail,
					success:function(res){
						alert("Password Changed!");
						location.reload();
					}
				});
				
			}
		});

		$(function(){
			$('table#userTable .notifyCheckbox').change(function() {

				var SNo = $(this).parent().parent().find('td').eq(2).text();

			});
		});

		$('#sendButton').click(function(){
			var table = document.getElementById("userTable").rows.length - 2;
			var arr=[];
			for (var i = 1; i <= table; i++) {
					//alert('#chk'+i);
					if ($('#chk'+i).is(':checked')) {
						var email = $('#chk'+i).parent().parent().find('td').eq(2).text();
						var username = $('#chk'+i).parent().parent().find('td').eq(1).text();
						//arr.push({"email":email,"username":username});

						$.ajax({
							url: "email4.php", 
							type: 'POST',
							data: "email=" + email + "&username=" + username,
							success:function(res){

								$('#sentStatus').append('<br />Email Sent To:' + res);
								console.log(res);						
							}
						});
					}
				}
				//window.location.href = "http://eflaudit.net/email4.php";				
			});

		function editActive(SNo,status)
		{
			$.ajax({
				url: "posting.php", 
				type: 'POST',
				data:"SNo=" + SNo + "&status=" + status,
				success:function(res){console.log(res);}
			});

		}
		function editPermission(UserId,permission)
		{
			$.ajax({
				url: "posting.php", 
				type: 'POST',
				data:"UserId=" + UserId + "&permission=" + permission,
				success:function(res){console.log(res);}
			});

		}
		function editAdmin(UserId,permission)
		{
			$.ajax({
				url: "posting.php", 
				type: 'POST',
				data:"AdminUserId=" + UserId + "&permissionAdmin=" + permission,
				success:function(res){console.log(res);}
			});

		}
		function editAuditor(UserId,permission)
		{
			$.ajax({
				url: "posting.php", 
				type: 'POST',
				data:"AuditorUserId=" + UserId + "&permissionAuditor=" + permission,
				success:function(res){console.log(res);}
			});

		}
		</script>



		</html>