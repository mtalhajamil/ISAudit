<?php
/***** EDIT BELOW LINES *****/
$DB_Server = "localhost"; // MySQL Server
$DB_Username = "root"; // MySQL Username
$DB_Password = ""; // MySQL Password
$DB_DBName = "engro_report"; // MySQL Database Name
$DB_TBLName = "report"; // MySQL Table Name
$xls_filename = 'export_'.date('Y-m-d').'.xlsx'; // Define Excel (.xls) file name
 
/***** DO NOT EDIT BELOW LINES *****/
// Create MySQL connection
$sql = "Select * from $DB_TBLName";
$Connect = @mysql_connect($DB_Server, $DB_Username, $DB_Password) or die("Failed to connect to MySQL:<br />" . mysql_error() . "<br />" . mysql_errno());
// Select database
$Db = @mysql_select_db($DB_DBName, $Connect) or die("Failed to select database:<br />" . mysql_error(). "<br />" . mysql_errno());
// Execute query
$result = @mysql_query($sql,$Connect) or die("Failed to execute query:<br />" . mysql_error(). "<br />" . mysql_errno());
 

/** PHPExcel */
require_once 'PHPExcel.php';


// Create new PHPExcel object
echo date('H:i:s') . " Create new PHPExcel object\n";
$objPHPExcel = new PHPExcel();

// Start of printing column names as names of MySQL fields
for ($i = 0; $i<mysql_num_fields($result); $i++) {
  //echo mysql_field_name($result, $i) . "\t";
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, 1, mysql_field_name($result, $i));
}
print("\n");

$col = 0; 
$row = 2; 
while($mrow = mysql_fetch_assoc($result)) { 
    $col = 0; 
    foreach($mrow as $key=>$value) { 
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value); 
        $col++; 
    } 
    $row++; 
} 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
echo date('H:i:s') . " Write to Excel2007 format\n";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($xls_filename);


?>