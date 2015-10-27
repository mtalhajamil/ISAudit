<?php

include 'session.php';
include_once 'db_functions.php';
$db = new DB_Functions();

$close = 0;
$open = 0;
$count = 0;
// $q1 = "select Distinct ReportName from report";
// mysqli_set_charset($connection,"UTF8");
$var = array();
$data = array();

if ( $query1 = $db.openCloseChart())
{
	while ($obj = mysqli_fetch_object($query1))
	{
		$var[$count]= $obj;
		//echo $var[$count]->ReportName;
		//echo $obj->ReportName;

		$q2 = "select Status from report where ReportName = '".$var[$count]->ReportName."'";

		if ( $query2 = $db.openCloseChartq2($q2))
		{
			while($obj1 = mysqli_fetch_object($query2))
			{
				if ($obj1->Status == 'Closed' || $obj1->Status == 'closed')
				{
					$close++;
				}

				if ($obj1->Status == 'Open' || $obj1->Status == 'open')
				{
					$open++;
				}


			}
		}

		$data[$count] = array('name' => $obj->ReportName, 'closed'=> $close, 'opened' => $open);
		$count++;
		$close=0;
		$open=0;

	}
	echo json_encode($data);

}
?>