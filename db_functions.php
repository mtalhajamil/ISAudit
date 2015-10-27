<?php

class DB_Functions {

    private $db;

    //put your code here
    // constructor
    function __construct() {
        include_once 'db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }

    // destructor
    function __destruct() {

    }




    /**
     * Inserting all reports
     */
    public function insertUser($val) {


        //$result = mysql_query("INSERT INTO report (SNo, ReportName, ResponsiblePerson ,Status ,Severity) VALUES ('".$val['sNo']."', '".$val['name']."', '".$val['status']."', '".$val['user']."', '".$val['severity']."')");


        $columns = implode(", ",array_keys($val));
        $escaped_values = array_map('mysql_real_escape_string', array_values($val));
        $values  = implode("', '", $escaped_values);
        $sql = "INSERT INTO user ($columns) VALUES ('$values')";
        $result = mysql_query($sql);
        

        return $result;
    }

    /**
     * Getting all users
     */
    public function getAllUsers() {
        $result = mysql_query("select * FROM user");
        return $result;
    }

    /**
     * Getting all reports
     */
    public function getAllReports() {
        $result = mysql_query("select * FROM report");
        return $result;
    }

    public function getAllReportList() {
        $result = mysql_query("SELECT * FROM report GROUP BY ReportName");
        return $result;
    }

    public function getReportByName($RN) {
        $result = mysql_query("SELECT * FROM report WHERE ReportName='$RN'");
        return $result;
    }

    public function exportByReportName($RN) {
        $result = mysql_query("SELECT ObsRef, ReportName, IssueRating, Observation, Risk, Recommendation, ManagComment, ResponsiblePerson, Responsibility, AgreedDate, ClosureDate, Status, Comments, Severity FROM report WHERE ReportName='$RN'");
        return $result;
    }

    /**
     * delete a row of reports
     */
    public function deleteReportRow($SNo) {
        $result = mysql_query("DELETE FROM report WHERE sNo = '$SNo' ");
        return $result;
    }

    public function getLatestSerial() {
        $result = mysql_query("Select SNo FROM report ORDER BY SNo DESC LIMIT 1");
        return $result;
    }

    /**
     * Inserting all reports
     */
    public function insertReport($val) {


        //$result = mysql_query("INSERT INTO report (SNo, ReportName, ResponsiblePerson ,Status ,Severity) VALUES ('".$val['sNo']."', '".$val['name']."', '".$val['status']."', '".$val['user']."', '".$val['severity']."')");
        $temp = array_pop($val);

        $columns = implode(", ",array_keys($val));
        $escaped_values = array_map('mysql_real_escape_string', array_values($val));
        $values  = implode("', '", $escaped_values);
        $sql = "INSERT INTO report ($columns) VALUES ('$values')";
        $result = mysql_query($sql);
         // var_dump($result);
         // var_dump($sql);

        return $result;
    }

    /**
     * EDiting all reports
     */
    public function editReport($val,$userID) {

        //var_dump($val);
        $i = 0;
        $temp = array_pop($val);
        $temp = array_pop($val);
        if (count($val) > 0) {
            foreach ($val as $key => $value) {

                $value = mysql_real_escape_string($value); // this is dedicated to @Jon
                $value = "'$value'";
                $array_keys = array_keys($val);
                $updates[] = "$array_keys[$i] = $value";
                $i++;
            }
        }
        $implodeArray = implode(',', $updates);
        $sql = ("UPDATE report SET $implodeArray WHERE SNo='$userID'");
        $result = mysql_query($sql);

        
        return $result;


    }

    public function getReportList($name) {

        $sql = ("SELECT DISTINCT(ReportName) ReportName from report WHERE ResponsiblePerson ='$name' OR ResponsiblePerson2 = '$name' OR ResponsiblePerson3 = '$name' OR ResponsiblePerson4 = '$name' OR ResponsiblePerson5 = '$name'");
        $result = mysql_query($sql);
        return $result;
    }

    public function editActiveUser($val,$userID) {
        $sql = ("UPDATE user SET Active = '$val' WHERE UserId='$userID'");
        //var_dump($sql);
        $result = mysql_query($sql);
        return $result;

    }


    public function editPermissionUser($val,$userID) {
        $sql = ("UPDATE user SET Permissions = '$val' WHERE UserId='$userID'");
        var_dump($sql);
        $result = mysql_query($sql);
        return $result;

    }

    public function editAdminUser($val,$userID) {
        $sql = ("UPDATE user SET Admin = '$val' WHERE UserId='$userID'");
        var_dump($sql);
        $result = mysql_query($sql);
        return $result;

    }

    public function editAuditorUser($val,$userID) {
        $sql = ("UPDATE user SET Auditor = '$val' WHERE UserId='$userID'");
        var_dump($sql);
        $result = mysql_query($sql);
        return $result;

    }

    public function deleteUser($UserID) {
        $result = mysql_query("DELETE FROM user WHERE UserId = '$UserID' ");
        return $result;
    }


    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $result = mysql_query("SELECT email from gcm_users WHERE email = '$email'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed
            return true;
        } else {
            // user not existed
            return false;
        }
    }


    public function getSingleUser($mail,$pass) {
        $Email = stripslashes($mail);
        $Password = stripslashes($pass);

        $sql = ("SELECT * from user where Password='$Password' AND Email='$Email'");
        
        $result = mysql_query($sql);
        
        return $result;
    }

    public function getSingleUserByEmail($mail) {
        $Email = stripslashes($mail);

        $sql = ("SELECT * from user where Email='$Email'");
        
        $result = mysql_query($sql);
        
        return $result;
    }

    public function getSingleEmail($user_check) {
        $check = stripslashes($user_check);

        $sql = ("SELECT Email from user where Email='$check'");
        $result = mysql_query($sql);
        return $result;
    }

    public function changePassword($ChangePassword,$Email,$Password) {

        $sql = ("UPDATE user SET Password = '$ChangePassword' WHERE Email='$Email' AND Password='$Password'");
        $result = mysql_query($sql);
        //var_dump($sql);
        return $result;
    }

    public function replaceResponsible($oldUser,$newUser) {

        $sql = ("UPDATE report SET ResponsiblePerson = '$newUser' WHERE ResponsiblePerson='$oldUser'");
        $result = mysql_query($sql);
        echo $sql;
        return $result;
    }


    public function editEmail($userId,$newEmail) {

        $sql = ("UPDATE user SET Email = '$newEmail' WHERE UserId='$userId'");
        $result = mysql_query($sql);
        echo $sql;
        return $result;
    }


    public function editPasswordById($userId,$newPassword) {

        $sql = ("UPDATE user SET Password = '$newPassword' WHERE UserId='$userId'");
        $result = mysql_query($sql);
        echo $sql;
        return $result;
    }

    /////////////////////////////////////////////////////////////////////

    public function openCloseChart() {
        //mysqli_set_charset($this->db->connect(),"UTF8");
        $sql = ("SELECT DISTINCT ReportName FROM report");
        $result = mysql_query($sql);
        //var_dump($sql);
        return $result;
    }

    public function openCloseChartUser($user) {
        //mysqli_set_charset($this->db->connect(),"UTF8");
        $sql = ("SELECT DISTINCT ReportName FROM report WHERE ResponsiblePerson = '$user' OR ResponsiblePerson2 = '$user' OR ResponsiblePerson3 = '$user' OR ResponsiblePerson4 = '$user' OR ResponsiblePerson5 = '$user'");
        $result = mysql_query($sql);
        //var_dump($sql);
        return $result;
    }

    public function openCloseChartq2($queryString) {

        $result = mysql_query($queryString);
       // var_dump($result);
        return $result;

    }

    

}
?>