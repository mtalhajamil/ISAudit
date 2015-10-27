<?php


include('session.php');
include_once 'db_functions.php';
$db = new DB_Functions();

$RN = $_GET['RN'];
if ( $RN == 'All')
{
$reports = $db->getAllReports();
}
else 
{
$reports = $db->exportByReportName($RN);
}

//export to excel
if (isset($_POST['export_excel']))
{

	export($RN,$reports);
}

function export($a,$reports) {     
		//echo $a;

			$xls_filename = 'export_'.$a.' '.date('Y-m-d').'.xlsx';  //Define Excel (.xls) file name


			/** PHPExcel */
			require_once 'excel/PHPExcel.php';


			// Create new PHPExcel object
			//echo date('H:i:s') . " Create new PHPExcel object\n";
			$objPHPExcel = new PHPExcel();

			 //Start of printing column names as names of MySQL fields
			for ($i = 0; $i<mysql_num_fields($reports); $i++) {
				//echo mysql_field_name($result, $i) . "\t";
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, 1, mysql_field_name($reports, $i));
			}
			//print("\n");

			$col = 0; 
			$row = 2; 
			while($mrow = mysql_fetch_assoc($reports)) { 
				$col = 0; 
				foreach($mrow as $key=>$value) { 
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value); 
					$col++; 
					
				} 
				$row++; 
			} 

 //Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);

 //Save Excel 2007 file
			//echo date('H:i:s') . " Write to Excel2007 format\n";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');//
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$xls_filename");
header('Cache-Control: max-age=0');
$objWriter->save('php://output');
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Export PHP File</title>
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
	File Exported
</body>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/moment.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="js/util.js"></script>
<script type="text/javascript" src="js/skel.min.js"></script>
</html>