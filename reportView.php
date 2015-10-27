<?php 
include('session.php');
include_once 'db_functions.php';
$db = new DB_Functions();

//////////////////////////////////////////////////////////////////////

if(isset($_POST["insertion"]))
	$result = $db->insertReport($_POST);

///////////////////////////////////////////////////////////////////////

$reportNames = $db->getAllReportList();

$currentUser = $db->getSingleUserByEmail($login_session);
$currentUserRow = mysql_fetch_array($currentUser);



function usersList(){
	$db = new DB_Functions();
	$users = $db->getAllUsers();
	if ($users != false)
		$no_of_users = mysql_num_rows($users);
	else
		$no_of_users = 0;

	echo('<li><a >All</a></li>');
	if ($no_of_users > 0) {
		while ($row = mysql_fetch_array($users)) {
			echo('<li><a >'.$row["Name"].'</a></li>');
		}
	} else {  
		echo ('<li>No Users Registered Yet!</li>');
	} 
}

function reportList(){
	$db = new DB_Functions();
	$reportNames = $db->getAllReportList();
	if ($reportNames != false)
		$no_of_reports = mysql_num_rows($reportNames);
	else
		$no_of_reports = 0;

	echo('<li><a>NA</a></li>');
	if ($no_of_reports > 0) {
		while ($row = mysql_fetch_array($reportNames)) {
			echo('<li><a >'.$row["ReportName"].'</a></li>');
		}
	} else {  
		echo ('<li>No Reports Added Yet!</li>');
	} 
}

if("1" === $currentUserRow["Admin"] || "admin" === strtolower($login_name) || "1" === $currentUserRow["Auditor"]){
	$reports = $db->getAllReportList();
}
else{
	$reports = $db->getReportList($login_name);
}


if ($reportNames != false)
	$no_of_reportNames = mysql_num_rows($reportNames);
else
	$no_of_reportNames = 0;




?>

<!DOCTYPE html>
<html>
<head>
	<title>Report List</title>
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
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Reports[<a href="logout.php">Logout</a>]
					[<a href="profile.php">Profile</a>]
					[<a href="GRAPH/allReportGraph.php">Charts</a>]
					<img style="float:right;" src="img/logo.png">
				</div>

				<br />
				<br />
				<!-- /.panel-heading -->
				<div class="panel-body">
					<?php if("1" === $currentUserRow["Admin"] || "admin" === strtolower($login_name) || "1" === $currentUserRow["Auditor"]){ ?>
					<div class="dropdown">
						<button class="btn btn-success dropdown-toggle userSelect" type="button" data-toggle="dropdown">Select User
							<span class="caret"></span></button>
							<input type='hidden' name="userSelect" class="form-control textUserSelect"  />
							<ul class="dropdown-menu liUserSelect">

								<?php usersList(); ?>

							</ul>
						</div>
						<?php } ?>
						<div class="table-responsive">

							<table class="table table-striped table-bordered table-hover" id="reportTable">
								<thead>
									<tr>
										<th>SNo</th>
										<th>Report Name</th>

									</tr>
								</thead>

								<tbody id="reportViewBody">
									<?php
									$i = 0;
									while ($row = mysql_fetch_array($reports)){
									//if($login_name === $row["ResponsiblePerson"] || "1" === $currentUserRow["Admin"] || "admin" === strtolower($login_name) || "1" === $currentUserRow["Auditor"]){
										?>

										<tr style="background-color: white">
											<td><?php echo ++$i ?></td>
											<td><a href="report.php?RN=<?php echo urlencode($row["ReportName"])?>&FU=All" class="viewButton"><?php echo $row["ReportName"]?></a></td>

										</tr>
										<?php }//} ?>
									</tbody>
								</table>
								<?php if("admin" === strtolower($login_name) || "1" === $currentUserRow["Admin"]){ ?>
								<button class="btn btn-success" data-toggle="modal" data-target="#insertModal">Insert Record</button>
								<a href="import.php" class="btn btn-success">Import Reports</a>
									<form action="exportExcel.php?RN=All" style="display:inline;" method="post" >
									<button id="export_excel" name="export_excel" value="export_excel"  class="btn btn-success" >Export to excel</button>
								</form>

								<?php } ?>

							</div>

							<!-- /.table-responsive -->
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
				</div>
			</div>
			<!-- /.row -->
		</div>

		<!-- Modal -->
		<div id="insertModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<form action="reportView.php" method="post">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Insert Record</h4>
						</div>

						<div class="modal-body">

							<!--<p>Serial No
								<textarea type='text' name="SNo" class="form-control"/></textarea>
							</p> -->
							<p>Obs Ref
								<textarea type='text' name="ObsRef" class="form-control"/></textarea>
							</p>
							<p>Report Name
								<textarea type='text' name="ReportName" class="form-control textReport"/></textarea>
								<div class="dropdown">
									<button class="btn btn-success dropdown-toggle Report" type="button" data-toggle="dropdown">Select From Previous Report
										<span class="caret"></span></button>

										<ul class="dropdown-menu liReport">
											<?php reportList(); ?>
										</ul>
									</div>
								</p>
								<p hidden>Process
									<textarea type='text' name="Process" class="form-control"/></textarea>
								</p>
								<p hidden>Sub Process
									<textarea type='text' name="SubProcess" class="form-control"/></textarea>
								</p>
								<p hidden>Issue Rating
									<textarea type='text' name="Severity" class="form-control"/></textarea>
								</p>

								Severity

								<div class="dropdown">
									<button class="btn btn-success dropdown-toggle Criticality" type="button" data-toggle="dropdown">Select Severity
										<span class="caret"></span></button>
										<input type='hidden' name="IssueRating" class="form-control textCriticality"  />
										<ul class="dropdown-menu liCriticality">
											<li><a href="#">1-High</a></li>
											<li><a href="#">2-Medium</a></li>
											<li><a href="#">3-Low</a></li>
											<li><a href="#">4-Improvement</a></li>
										</ul>
									</div>
									<hr />

									<p>Observation
										<textarea type='text' name="Observation" class="form-control"/></textarea>
									</p>
									<p>Risk
										<textarea type='text' name="Risk" class="form-control"/></textarea>
									</p>
									<p>Recommendation
										<textarea type='text' name="Recommendation" class="form-control"/></textarea>
									</p>
									<p>Managment Comment ON
										<textarea type='text' name="ManagComment" class="form-control"/></textarea>
									</p>


									Responsible Person

									<div class="dropdown">
										<button class="btn btn-success dropdown-toggle User" type="button" data-toggle="dropdown">Select User
											<span class="caret"></span></button>
											<input type='hidden' name="ResponsiblePerson" class="form-control textUser"  />
											<ul class="dropdown-menu liUser">
												<?php usersList(); ?>
											</ul>
										</div>



										<div class="dropdown" hidden>
											<button class="btn btn-success dropdown-toggle User2" type="button" data-toggle="dropdown">Select User
												<span class="caret"></span></button>
												<input type='hidden' name="ResponsiblePerson2" class="form-control textUser2"  />
												<ul class="dropdown-menu liUser2">
													<?php usersList(); ?>
												</ul>
											</div>



											<div class="dropdown" hidden>
												<button class="btn btn-success dropdown-toggle User3" type="button" data-toggle="dropdown">Select User
													<span class="caret"></span></button>
													<input type='hidden' name="ResponsiblePerson3" class="form-control textUser3"  />
													<ul class="dropdown-menu liUser3">
														<?php usersList(); ?>
													</ul>
												</div>


												<div class="dropdown" hidden>
													<button class="btn btn-success dropdown-toggle User4" type="button" data-toggle="dropdown">Select User
														<span class="caret"></span></button>
														<input type='hidden' name="ResponsiblePerson4" class="form-control textUser4"  />
														<ul class="dropdown-menu liUser4">
															<?php usersList(); ?>
														</ul>
													</div>


													<div class="dropdown" hidden>
														<button class="btn btn-success dropdown-toggle User5" type="button" data-toggle="dropdown">Select User
															<span class="caret"></span></button>
															<input type='hidden' name="ResponsiblePerson5" class="form-control textUser5"  />
															<ul class="dropdown-menu liUser5">
																<?php usersList(); ?>
															</ul>
														</div>

														<hr />

														<p>Responsibility
															<textarea type='text' name="Responsibility" class="form-control"/></textarea>
														</p>

														Agreed Date
														<div class='input-group date' id='AgreedDate'>
															<input type='text' name="AgreedDate" class="form-control" />
															<span class="input-group-addon">
																<span class="glyphicon glyphicon-calendar"></span>
															</span>
														</div>
														<hr />

														Closure Date

														<div class='input-group date' id='ClosureDate'>
															<input type='text' name="ClosureDate" class="form-control" />
															<span class="input-group-addon">
																<span class="glyphicon glyphicon-calendar"></span>
															</span>
														</div>
														<hr />
														Status
														<div class="dropdown">
															<button class="btn btn-success dropdown-toggle Status" type="button" data-toggle="dropdown">Select Status
																<span class="caret"></span></button>
																<input type='hidden' name="Status" class="form-control textStatus"  />
																<ul class="dropdown-menu liStatus">
																	<li><a href="#">Open</a></li>
																	<li><a href="#">Close</a></li>
																</ul>
															</div>
															<hr />
															<p>Comments
																<textarea type='text' name="Comments" class="form-control"/></textarea>
															</p>
															<hr />



															<!--Permissions -->

															<div class="dropdown" hidden>
																<button class="btn btn-success dropdown-toggle Permission" type="button" data-toggle="dropdown">Select Permission
																	<span class="caret"></span></button>
																	<input type='hidden' name="Permission" class="form-control textPermission"  />
																	<ul class="dropdown-menu liPermission">
																		<li><a href="#">RO</a></li>
																		<li><a href="#">RW</a></li>
																	</ul>
																</div>
															</div>
															<input type='hidden' name="insertion" value="abc" class="form-control textUser"  />
															<div class="modal-footer">
																<button type="submit" class="btn btn-success">Save</button>
															</form>
														</div>
													</div>
												</div>

											</div>

										</div>
										<!-- Modal Ends-->

									</body>
									<script type="text/javascript" src="js/jquery.min.js"></script>
									<script type="text/javascript" src="js/moment.js"></script>
									<script type="text/javascript" src="js/bootstrap.min.js"></script>
									<script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
									<script type="text/javascript" src="js/util.js"></script>
									<script type="text/javascript" src="js/skel.min.js"></script>
									<script type="text/javascript">

										$(function(){
											$(".liUserSelect li a").click(function(){
												$(".userSelect:first-child").text($(this).text());
												$(".userSelect:first-child").val($(this).text());
												$(".textUserSelect").val($(this).text());

												var name = $(this).text();

												$.ajax({
													url: "posting.php", 
													type: 'POST',
													data:"selectUser=" + $(this).text(),
													dataType: 'json',													
													success:function(res){
														$('#reportViewBody tr').remove();
														var count = 1;

														for (var i = 0; i < res.length; i++) { 
															$('#reportViewBody').append("<tr style='background-color: white'><td>"+count++ +"</td><td><a target='_blank' href='report.php?RN="+encodeURIComponent(res[i].name1)+"&FU="+name+"' class='viewButton'>"+res[i].name1+"</a></td></tr>");
															
														}

													}
												});
											});
										});

										$(function () {

											$(function(){
												$(".liUser li a").click(function(){
													$(".User:first-child").text($(this).text());
													$(".User:first-child").val($(this).text());
													$(".textUser").val($(this).text());
												});
											});

											$(function(){
												$(".liUser2 li a").click(function(){
													$(".User2:first-child").text($(this).text());
													$(".User2:first-child").val($(this).text());
													$(".textUser2").val($(this).text());
												});
											});

											$(function(){
												$(".liUser3 li a").click(function(){
													$(".User3:first-child").text($(this).text());
													$(".User3:first-child").val($(this).text());
													$(".textUser3").val($(this).text());
												});
											});

											$(function(){
												$(".liUser4 li a").click(function(){
													$(".User4:first-child").text($(this).text());
													$(".User4:first-child").val($(this).text());
													$(".textUser4").val($(this).text());
												});
											});

											$(function(){
												$(".liUser5 li a").click(function(){
													$(".User5:first-child").text($(this).text());
													$(".User5:first-child").val($(this).text());
													$(".textUser5").val($(this).text());
												});
											});


											$(function(){
												$(".liStatus li a").click(function(){
													$(".Status:first-child").text($(this).text());
													$(".Status:first-child").val($(this).text());
													$(".textStatus").val($(this).text());
												});
											});

											$(function(){
												$(".liCriticality li a").click(function(){
													$(".Criticality:first-child").text($(this).text());
													$(".Criticality:first-child").val($(this).text());
													$(".textCriticality").val($(this).text());
												});
											});

											$(function(){
												$(".liPermission li a").click(function(){
													$(".Permission:first-child").text($(this).text());
													$(".Permission:first-child").val($(this).text());
													$(".textPermission").val($(this).text());
												});
											});


											$(function(){
												$(".liReport li a").click(function(){
													$(".Report:first-child").text($(this).text());
													$(".Report:first-child").val($(this).text());
													$(".textReport").val($(this).text());
												});
											});

											$('#AgreedDate').datetimepicker({
												locale: 'en'
											});

											$('#ClosureDate').datetimepicker({
												locale: 'en'
											});

										});
</script>
</html>