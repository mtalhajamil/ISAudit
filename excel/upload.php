<?php
$uploadedStatus = 0;
if ( isset($_POST["submit"]) ) {
if ( isset($_FILES["file"])) {
//if there was an error uploading the file
if ($_FILES["file"]["error"] > 0) {
echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
}
else {
if (file_exists($_FILES["file"]["name"])) {
unlink($_FILES["file"]["name"]);
}
$storagename = "example1.xlsx";
move_uploaded_file($_FILES["file"]["tmp_name"],  $storagename);
$uploadedStatus = 1;
}
} else {
echo "No file selected <br />";
}
}
?>

<table width="600" style="margin:115px auto; background:#f8f8f8; border:1px solid #eee; padding:20px 0 25px 0;">
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
<tr><td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">
<a href="http://www.discussdesk.com" target="_blank">DiscussDesk.com</a></td></tr>
<tr><td colspan="2" style="font:bold 15px arial; text-align:center; padding:0 0 5px 0;">Browse and Upload Your File </td></tr>
<tr>
<td width="50%" style="font:bold 12px tahoma, arial, sans-serif; text-align:right; border-bottom:1px solid #eee; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Select file</td>
<td width="50%" style="border-bottom:1px solid #eee; padding:5px;"><input type="file" name="file" id="file" /></td>
</tr>
<tr>
<td style="font:bold 12px tahoma, arial, sans-serif; text-align:right; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Submit</td>
<td width="50%" style=" padding:5px;"><input type="submit" name="submit" /></td>
</tr>
</table>