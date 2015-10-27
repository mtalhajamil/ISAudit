<?php


/************************ YOUR DATABASE CONNECTION START HERE   ****************************/
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 100);
//error_reporting(0);

include_once '../db_functions.php';
$db = new DB_Functions();

/************************ YOUR DATABASE CONNECTION END HERE  ****************************/


set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include 'PHPExcel/IOFactory.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Import Records</title>
	<link rel="shortcut icon" href="../favicon.ico" />

	<link rel="stylesheet" type="text/css" href="../css/app.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap-datetimepicker.css">
	<link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../css/sb-admin2.css">
	<link rel="stylesheet" type="text/css" href="../css/selectionPage.css">
	<link rel="stylesheet" type="text/css" href="../css/sms.css">
	<link rel="stylesheet" type="text/css" href="../css/structure.css">
	<link rel="stylesheet" type="text/css" href="../css/design.css">
</head>
<body>
	<div class="panel panel-default">
		<div class="panel-heading">Login<img style="float:right;" src="../img/logo.png"></div>
		<br />
		<br />
		<form action="import.php" method="post" enctype="multipart/form-data">
			Select File to upload:
			<input type="file" name="fileToUpload" id="fileToUpload">
			<input type="submit" value="Upload" name="submit">
		</form>
	</div>

</body>
</html>

<?php

$target_dir = "";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$inputFileName = $target_file; 

try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	
}

$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet

for($i=2;$i<=$arrayCount;$i++){

	$obsref =  trim($allDataInSheet[$i]["A"]);
	$reportname = trim($allDataInSheet[$i]["B"]);
	$replaced = preg_replace('/[^\x00-\x7F]+/', '', $reportname);
			//echo $replaced;
	$process = trim($allDataInSheet[$i]["C"]);
	$process = preg_replace('/[^\x00-\x7F]+/', '', $process);

	$subprocess = trim($allDataInSheet[$i]["D"]);
	$issuerating = trim($allDataInSheet[$i]["E"]);
	$observation = trim($allDataInSheet[$i]["F"]);
			//echo " ".$i." \n";
	$risk = trim($allDataInSheet[$i]["G"]);
	$recommendation = trim($allDataInSheet[$i]["H"]);
	$managecomment = trim($allDataInSheet[$i]["I"]);
	$responsibleperson = trim($allDataInSheet[$i]["J"]);
	$agreeddate = trim($allDataInSheet[$i]["K"]);
			//echo " ".$i." \n";
	$closuredate = trim($allDataInSheet[$i]["M"]);
			//echo " closure date is ".$closuredate." \n";
	$status = trim($allDataInSheet[$i]["L"]);			
		//	echo " ".$i." \n";
	$comments = trim($allDataInSheet[$i]["N"]);


	$sqlQuery = "insert into report(ObsRef,ReportName,Process,SubProcess,IssueRating,Observation,Risk,Recommendation,ManagComment,ResponsiblePerson,AgreedDate,ClosureDate,Status,Comments,Severity,Permission) values('".$obsref."','".$replaced."','".$process."','".$subprocess."','".$issuerating."','".$observation."','".$risk."','".$recommendation."','".$managecomment."','".$responsibleperson."','".$agreeddate."','".$closuredate."','".$status."','".$comments."','High','RO')";
	$insert = $db->openCloseChartq2($sqlQuery);
	$msg = 'Record has been added. <div style="Padding:20px 0 0 0;"></div>';

}
echo "<div style='font: bold 18px arial,verdana;padding: 45px 0 0 500px;'>".$msg."</div>";

include('../session.php');
?>