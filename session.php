<?php
include_once 'db_functions.php';
session_start();
error_reporting(0);
$user_check=$_SESSION['login_user'];
$db = new DB_Functions();
$user = $db->getSingleUserByEmail($user_check);
$row = mysql_fetch_assoc($user);
$login_session =$row['Email'];
$login_name =$row['Name'];
$login_pass =$row['Password'];

if(!isset($_SESSION['filter_user'])){
	$_SESSION['filter_user'] = "notset";
}

if(!isset($_SESSION['login_user'])){
	if($_SERVER['REQUEST_URI'] === "/audit/GRAPH/allReportGraph.php")
		header('Location: ../login.php'); 
	else if($_SERVER['REQUEST_URI'] === "/audit//GRAPH/openCloseGraph.php")
		header('Location: ../login.php');
	else if($_SERVER['REQUEST_URI'] === "/audit/excel/import.php")
		header('Location: ../login.php'); 
	else
		header('Location: login.php'); 	
	
}
?>