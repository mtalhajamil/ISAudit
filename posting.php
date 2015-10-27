<?php 

include_once 'db_functions.php';
$db = new DB_Functions();

if(isset($_POST["status"]))
	$result = $db->editActiveUser($_POST["status"],$_POST["SNo"]);

if(isset($_POST["permission"]))
	$result = $db->editPermissionUser($_POST["permission"],$_POST["UserId"]);

if(isset($_POST["AdminUserId"]))
	$result = $db->editAdminUser($_POST["permissionAdmin"],$_POST["AdminUserId"]);

if(isset($_POST["AuditorUserId"]))
	$result = $db->editAuditorUser($_POST["permissionAuditor"],$_POST["AuditorUserId"]);

if(isset($_POST["DeleteUserId"]))
	$result = $db->deleteUser($_POST["DeleteUserId"]);

if(isset($_POST["DeleteReport"]))
	$result = $db->deleteReportRow($_POST["DeleteReport"]);

if(isset($_POST["ChangePassword"]))
	$result = $db->changePassword($_POST["ChangePassword"],$_POST["Email"],$_POST["Pass"]);

if(isset($_POST["replaceName"]))
	$result = $db->replaceResponsible($_POST["replaceName"],$_POST["newName"]);

if(isset($_POST["ChangeEmailId"]))
	$result = $db->editEmail($_POST["ChangeEmailId"],$_POST["NewEmailId"]);

if(isset($_POST["ChangePasswordId"]))
	$result = $db->editPasswordById($_POST["ChangePasswordId"],$_POST["NewPassword"]);

if(isset($_POST["selectUser"])){
	if($_POST["selectUser"] == "All"){
		$result = $db->getAllReportList();
	}
	else{
		$result = $db->getReportList($_POST["selectUser"]);
	}
	
	$arr= array();
	$count=0;
	while($row = mysql_fetch_object($result))
	{
		$arr[$count] = array('name1' => $row->ReportName );
		$count++;
	}
	echo json_encode($arr);
}



