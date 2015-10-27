		<!DOCTYPE html>
		<html>
		<head>
			<title>Reports</title>
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


			include('session.php');
			include_once 'db_functions.php';
			$db = new DB_Functions();

			////////////////////Get Serial////////////////////////////////////
			$lastSerial = $db->getLatestSerial();
			$SNoRow = mysql_fetch_array($lastSerial);
			$LatestSNo = $SNoRow["SNo"] + 1;

			/////////////////////////////////////////////////////////////////////

			///////////////////////////Date///////////////////////////////////////
			$currentData = getdate();
			$cDate = sprintf("%02d", $currentData["year"]);
			$cDate = $cDate . "-" . sprintf("%02d", $currentData["mon"]);
			$cDate = $cDate . "-" . sprintf("%02d", $currentData["mday"]);
			

			$curDate = date_create($cDate);
			$curDate = date_format($curDate, 'Y-m-d');
			

			///////////////////////////////////////////////////////////////////////

			if(isset($_POST["insertion"]))
				$result = $db->insertReport($_POST);


			if(isset($_POST["editing"]))
				$result = $db->editReport($_POST,$_POST['SNo']);

			/////////////////////////////////////////////////////////////////////////////
			// include_once 'db_functions.php';
			// $db = new DB_Functions();

			////////////////////////////////////get Reports//////////////////////////////////////////////////

			$RN = $_GET['RN'];

			$FU = "All";
			if($_GET['FU'] !== "All")
				$FU = $_GET['FU'];


			//echo($RN);
			//$reports = $db->getAllReports();
			$reports = $db->getReportByName($RN);


			if ($reports != false)
				$no_of_reports = mysql_num_rows($reports);
			else
				$no_of_reports = 0;

			///////////////////////////////////////////////////////////////////////////////

			
			$editUsers = $db->getAllUsers();
			$currentUser = $db->getSingleUserByEmail($login_session);


			$currentUserRow = mysql_fetch_array($currentUser);

			

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


			/////////////////////////////admin///////////////////////////////////////////

			if("admin" === strtolower($login_name) || "1" === $currentUserRow["Admin"])
				echo('<span id="adminUser" hidden>admin</span>');
			//////////////////////////////////////////////////////////////////////

			?>

			<!-- /.row -->
			<div class="row">
				
				<div class="panel panel-default">
					<div class="panel-heading">
						Reports[<a href="logout.php">Logout</a>]
						[<a href="profile.php">Profile</a>]
						[<a href="reportView.php">Reports</a>]
						[<a href="GRAPH/allReportGraph.php">Charts</a>]
						<img style="float:right;" src="img/logo.png">
					</div>
					<br />
					<br />
					<!-- /.panel-heading -->
					<div class="panel-body">
						<div class="table-responsive">


							<table class="table table-striped table-bordered table-hover" id="reportTable">
								<thead>
									<tr style="white-space: nowrap;">
										<th hidden>SNo</th>
										<th>Obs Ref</th>
										<th>Report Name</th>
										<th hidden>Process</th>
										<th hidden>Sub Process</th>
										<th >Issue Rating</th>
										<th>Observation</th>
										<th>Risk</th>
										<th>Recommendation</th>
										<th>Managment Comments</th>
										<th>Responsibility</th>
										<th>Agreed Date</th>
										<th>Closure Date</th>
										<th>Status</th>
										<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Comments &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
										<th hidden>Severity</th>
										<th>Responsible Person</th>
										<th hidden>Responsible Person 2</th>
										<th hidden>Responsible Person 3</th>
										<th hidden>Responsible Person 4</th>
										<th hidden>Responsible Person 5</th>
										<?php if("admin" === strtolower($login_name) || "1" === $currentUserRow["Admin"]){ ?>
										<th>Delete Row</th>
										<?php } ?>
										<?php if(("1" === $currentUserRow["Permissions"] && "1" !== $currentUserRow["Auditor"]) || "1" === $currentUserRow["Admin"] || "admin" === strtolower($login_name)){	?>
										<th>Edit Row</th>
										<?php } ?>
									</tr>

								</thead>

								<tbody>

									<?php
									if ($no_of_reports > 0) {
										?>
										<?php
										echo $FU;
										while ($row = mysql_fetch_array($reports)) {
											if($login_name === $row["ResponsiblePerson"] || $FU === $row["ResponsiblePerson"] || $login_name === $row["ResponsiblePerson2"] || $login_name === $row["ResponsiblePerson3"] || $login_name === $row["ResponsiblePerson4"] || $login_name === $row["ResponsiblePerson5"] || (("admin" === strtolower($login_name) || "1" === $currentUserRow["Admin"] || "1" === $currentUserRow["Auditor"]) && $FU === "All")){
												$clip = substr($row["AgreedDate"], 0, 11);


												$time = strtotime($clip);
												$newformat = date('Y-m-d',$time);

												//if( strtotime($newformat) < strtotime($curDate) && strtolower($row["Status"]) === "open") echo('<tr class="warning" style="font-size:10px;">');
												if( strtolower($row["Status"]) === "close") echo('<tr class="warning" style="font-size:10px;">');
												else echo('<tr class="success" style="font-size:10px;">') ?>

												<td hidden><?php echo $row["SNo"] ?></td>
												<td title="Obs Ref"><?php echo $row["ObsRef"] ?></td>
												<td title="Report Name"><?php echo $row["ReportName"] ?></td>
												<td hidden><?php echo $row["Process"] ?></td>
												<td hidden><?php echo $row["SubProcess"] ?></td>
												<td title="Issue Rating"><?php echo $row["IssueRating"] ?></td>
												<td title="Observation"><?php echo $row["Observation"] ?></td>
												<td title="Risk"><?php echo $row["Risk"] ?></td>
												<td title="Recommendation"><?php echo $row["Recommendation"] ?></td>
												<td title="Managment Comments"><?php echo $row["ManagComment"] ?></td>
												<td title="Responsibility"><?php echo $row["Responsibility"] ?></td>
												<td title="Agreed Date"><?php echo $row["AgreedDate"] ?></td>
												<td title="Closure Date"><?php echo $row["ClosureDate"] ?></td>
												<td title="Status"><?php echo $row["Status"] ?></td>
												<td title="Comments"><?php echo $row["Comments"] ?></td>
												<td hidden><?php echo $row["Severity"] ?></td>
												<td title="Responsible Person"><?php echo $row["ResponsiblePerson"] ?></td>
												<td hidden><?php echo $row["ResponsiblePerson2"] ?></td>
												<td hidden><?php echo $row["ResponsiblePerson3"] ?></td>
												<td hidden><?php echo $row["ResponsiblePerson4"] ?></td>
												<td hidden><?php echo $row["ResponsiblePerson5"] ?></td>
												<?php if("admin" === strtolower($login_name) || "1" === $currentUserRow["Admin"]){ ?>
												<td><a class="deleteButton">Delete</a></td>
												<?php } ?>
												<?php if(("1" === $currentUserRow["Permissions"] && "1" !== $currentUserRow["Auditor"]) || "1" === $currentUserRow["Admin"] || "admin" === strtolower($login_name)){	?>
												<td><a class="editButton" data-toggle="modal" data-target="#editModal">Edit</a></td>
												<?php } ?>
											</tr>

											<?php }
										}} else { ?> 
										<li>
											No Reports Yet!
										</li>
										<?php } ?>


									</tbody>
								</table>
								<?php if("admin" === strtolower($login_name) || "1" === $currentUserRow["Admin"]){ ?>
								<button class="btn btn-success" data-toggle="modal" data-target="#insertModal">Insert Record</button>
								<?php } ?>
								<form action="exportExcel.php?RN=<?php echo $RN; ?>" style="display:inline;" method="post" >
									<button id="export_excel" name="export_excel" value="export_excel"  class="btn btn-success" >Export to excel</button>
								</form>

							</div>

							<!-- /.table-responsive -->
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
					
				</div>
				<!-- /.row -->
			</div>




			<!-- Modal -->
			<div id="insertModal" class="modal fade" role="dialog">
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
						<form action="report.php?RN=<?php echo($RN); ?>&FU=<?php echo($FU); ?>" method="post">
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
								<textarea type='text' name="ReportName" class="form-control"/><?php echo $RN ?></textarea>
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

							Issue Rating

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
								<p>Managment Comment
									<textarea type='text' name="ManagComment" class="form-control"/></textarea>
								</p>



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
															<li><a>Open</a></li>
															<li><a>Close</a></li>
														</ul>
													</div>
													<hr />
													<p>Comments
														<textarea type='text' name="Comments" class="form-control"/></textarea>
													</p>
													<hr />



													Responsible Person

													<div class="dropdown">
														<button class="btn btn-success dropdown-toggle User" type="button" data-toggle="dropdown">Select User
															<span class="caret"></span></button>
															<input type='hidden' name="ResponsiblePerson" class="form-control textUser"  />
															<ul class="dropdown-menu liUser">
																<?php usersList(); ?>
															</ul>
														</div>

														<!--Permissions -->

														<div class="dropdown" hidden>
															<button class="btn btn-success dropdown-toggle Permission" type="button" data-toggle="dropdown">Select Permission
																<span class="caret"></span></button>
																<input type='hidden' name="Permission" class="form-control textPermission"  />
																<ul class="dropdown-menu liPermission">
																	<li><a>RO</a></li>
																	<li><a>RW</a></li>
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

									<!-- Modal -->
									<div id="editModal" class="modal fade" role="dialog">
										<div class="modal-dialog">

											<!-- Modal content-->
											<div class="modal-content">
												<form action="report.php?RN=<?php echo($RN); ?>&FU=<?php echo($FU); ?>" method="post">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">Insert Record</h4>
													</div>

													<div class="modal-body">


														<p>Obs Ref
															<textarea id="E1" type='text' name="ObsRef" class="form-control"/></textarea>
														</p>
														<p>Report Name
															<textarea id="E2" type='text' name="ReportName" class="form-control"/></textarea>
														</p>
														<p hidden>Process
															<textarea id="E3" type='text' name="Process" class="form-control"/></textarea>
														</p>
														<p hidden>Sub Process
															<textarea id="E4" type='text' name="SubProcess" class="form-control"/></textarea>
														</p>
														<p hidden>Issue Rating
															<textarea id="E5" type='text' name="Severity" class="form-control"/></textarea>
														</p>

														Issue Rating

														<div class="dropdown">
															<button id="E16" class="btn btn-success dropdown-toggle Criticality" type="button" data-toggle="dropdown">Select Issue Rating
																<span class="caret"></span></button>
																<input id="E17" type='hidden' name="IssueRating" class="form-control textCriticality"  />
																<ul class="dropdown-menu liCriticality">
																	<li><a href="#">1-High</a></li>
																	<li><a href="#">2-Medium</a></li>
																	<li><a href="#">3-Low</a></li>
																	<li><a href="#">4-Improvement</a></li>
																</ul>
															</div>

															<hr />

															<p>Observation
																<textarea id="E6" type='text' name="Observation" class="form-control"/></textarea>
															</p>
															<p>Risk
																<textarea id="E7" type='text' name="Risk" class="form-control"/></textarea>
															</p>
															<p>Recommendation
																<textarea id="E8" type='text' name="Recommendation" class="form-control"/></textarea>
															</p>
															<p>Managment Comment
																<textarea id="E9" type='text' name="ManagComment" class="form-control"/></textarea>
															</p>


															<div class="dropdown" hidden>
																<button id="E21" class="btn btn-success dropdown-toggle User2" type="button" data-toggle="dropdown">Select User
																	<span class="caret"></span></button>
																	<input id="E22" type='hidden' name="ResponsiblePerson2" class="form-control textUser2"  />
																	<ul class="dropdown-menu liUser2">

																		<?php usersList(); ?>

																	</ul>
																</div>

																<div class="dropdown" hidden>
																	<button id="E23" class="btn btn-success dropdown-toggle User3" type="button" data-toggle="dropdown">Select User
																		<span class="caret"></span></button>
																		<input id="E24" type='hidden' name="ResponsiblePerson3" class="form-control textUser3"  />
																		<ul class="dropdown-menu liUser3">

																			<?php usersList(); ?>

																		</ul>
																	</div>

																	<div class="dropdown" hidden>
																		<button id="E25" class="btn btn-success dropdown-toggle User4" type="button" data-toggle="dropdown">Select User
																			<span class="caret"></span></button>
																			<input id="E26" type='hidden' name="ResponsiblePerson4" class="form-control textUser4"  />
																			<ul class="dropdown-menu liUser4">

																				<?php usersList(); ?>

																			</ul>
																		</div>

																		<div class="dropdown" hidden>
																			<button id="E27" class="btn btn-success dropdown-toggle User5" type="button" data-toggle="dropdown">Select User
																				<span class="caret"></span></button>
																				<input id="E28" type='hidden' name="ResponsiblePerson5" class="form-control textUser5"  />
																				<ul class="dropdown-menu liUser5">

																					<?php usersList(); ?>

																				</ul>
																			</div>
																			<hr />

																			<p>Responsibility
																				<textarea id="E10" type='text' name="Responsibility" class="form-control"/></textarea>
																			</p>

																			Agreed Date
																			<div class='input-group date' id='AgreedDate2'>
																				<input type='text' id="E11" name="AgreedDate" class="form-control" />
																				<span class="input-group-addon">
																					<span class="glyphicon glyphicon-calendar"></span>
																				</span>
																			</div>
																			<hr />

																			Closure Date

																			<div class='input-group date' id='ClosureDate2'>
																				<input type='text' id="E12" name="ClosureDate" class="form-control" />
																				<span class="input-group-addon">
																					<span class="glyphicon glyphicon-calendar"></span>
																				</span>
																			</div>
																			<hr />
																			Status
																			<div class="dropdown">
																				<button id="E14" class="btn btn-success dropdown-toggle Status" type="button" data-toggle="dropdown">Select Status
																					<span class="caret"></span></button>
																					<input id="E15" type='hidden' name="Status" class="form-control textStatus"  />
																					<ul class="dropdown-menu liStatus">
																						<li><a>Open</a></li>
																						<li><a>Close</a></li>
																					</ul>
																				</div>

																				<hr />

																				<p>Comments
																					<textarea id="E13" type='text' name="Comments" class="form-control"/></textarea>
																				</p>
																				<hr />
																				I
																				<!--Permissions -->

																				<div class="dropdown" hidden>
																					<button id="E20" class="btn btn-success dropdown-toggle Permission" type="button" data-toggle="dropdown">Select Permission
																						<span class="caret"></span></button>
																						<input id="E21" type='hidden'  class="form-control textPermission"  />
																						<ul class="dropdown-menu liPermission">
																							<li><a>RO</a></li>
																							<li><a>RW</a></li>
																						</ul>
																					</div>

																					Responsible Person

																					<div class="dropdown">
																						<button id="E18" class="btn btn-success dropdown-toggle User" type="button" data-toggle="dropdown">Select User
																							<span class="caret"></span></button>
																							<input id="E19" type='hidden' name="ResponsiblePerson" class="form-control textUser"  />
																							<ul class="dropdown-menu liUser">

																								<?php usersList(); ?>

																							</ul>
																						</div>
																					</div>

																					<span hidden>Serial No</span>
																					<input id="E0" type='text' name="SNo" class="form-control" readonly/></textarea>

																					<input type='hidden' name="editing" value="abc" class="form-control textUser"/>
																					<div class="modal-footer">
																						<button type="submit" class="btn btn-success">Save Editing</button>
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


																$('table#reportTable .deleteButton').click(function(){

																	var r = confirm("Are You Sure????");
																	if (r == true) {
																		var SNo = $(this).parent().parent().find('td:first').text();
																		$(this).parent().parent().hide();
																		$.ajax({
																			url: "posting.php", 
																			type: 'POST',
																			data:"DeleteReport=" + SNo,
																			success:function(res){
																				alert('Report Deleted');
																			}
																		});
																	} else {
																		x = "OK";
																	}

																	

																});


																$('table#reportTable .editButton').click(function(){

																	for (i = 0; i < 13; i++) { 
																		$('#E'+i).val($(this).parent().parent().find('td').eq(i).text());
																	}
																	$('#E13').val($(this).parent().parent().find('td').eq(14).text());

																	$("#E14").html($(this).parent().parent().find('td').eq(13).text());
																	$("#E15").val($(this).parent().parent().find('td').eq(13).text());

																	$("#E16").html($(this).parent().parent().find('td').eq(5).text());
																	$("#E17").val($(this).parent().parent().find('td').eq(5).text());

																	$("#E18").html($(this).parent().parent().find('td').eq(16).text());
																	$("#E19").val($(this).parent().parent().find('td').eq(16).text());

																});

																$(function () {

																	$('#AgreedDate').datetimepicker({
																		locale: 'en'
																	});

																	$('#ClosureDate').datetimepicker({
																		locale: 'en'
																	});

																});

																$(function () {


																	$('#AgreedDate2').datetimepicker({
																		locale: 'en'
																	});

																	$('#ClosureDate2').datetimepicker({
																		locale: 'en'
																	});
																});

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
																	if($("#adminUser").text() !== "admin"){

																		for (i = 0; i < 50; i++) { 
																			$('#E'+i).prop("readonly", true);
																		}

																		//$("#E14").hide();

																		$("#E16").hide();
																		$("#E18").hide();
																		$("#E12").prop("readonly",false);
																		$('#E13').prop("readonly", false);

																	}

																});




															</script>
															</html>