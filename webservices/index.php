<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
include './Db.php';
include './Sendmail.php';
include './SendSMS.php';
$userdata = json_decode(file_get_contents('php://input'), true);
$last_id;
$values = array(
    "ActivityType" => $userdata["Type"],
    "contact" => $userdata["contact"],
    "email" => $userdata["email"],
    "investment" => $userdata["investment"],
    "meetingdate" => $userdata["meetingdate"],
    "name" => $userdata["name"],
    "sproject" => $userdata["sproject"],
);
if ($userdata["Type"] == "Create") {
    //Calling insert function
    $last_id = AddUser($values, $conn);
    if (is_numeric($last_id)) {
        success($last_id, $conn);
    } else {
        echo json_encode("failed" . $result);
    }
} else
if ($userdata["Type"] == "Collaborate") {
    //Calling insert function
    $last_id = AddUser($values, $conn);
    //Get user details
    $details = GetUserDetails($last_id, $conn);
    //Send Email
    $sentmail = SendMailRegister($details);
    //Send SMS
    // $sms = SendSMS($details);
    // && $sms = "success"
    if ($sentmail = 1) {
        include "main.php";
    } else{
        echo json_encode("failed" . $result);
    }
} else
if ($userdata["Type"] == "Connect") {
    //Calling insert function
    $last_id = AddUser($values, $conn);
    //Get user details
    $details = GetUserDetails($last_id, $conn);
    //Send Email
    $sentmail = SendMailRegister($details);
    //Send SMS
    // $sms = SendSMS($details);
    // && $sms = "success"
    if ($sentmail = 1) {
        include "main.php";
    } else{
        echo json_encode("failed" . $result);
    }
}

function success($last_id, $conn)
{
    //Get user details
    $details = GetUserDetails($last_id, $conn);
    //Send Email
    $sentmail = SendMailRegister($details);
    //Send SMS
    // $sms = SendSMS($details);
    // && $sms = "success"
    if ($sentmail = 1) {
        echo json_encode("success");
    } else {
        echo json_encode("failed" . $result);
    }
}
