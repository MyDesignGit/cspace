<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
include './config.php';
function AddUser($values, $conn)
{
    try {
    $stmt = $conn->prepare("INSERT INTO Users (ActivityType,Phone,Email,ScaleOfInvestment,MeetingDate,Name,SProject,CreatedOn) VALUES (?, ?, ?,?,?,?,?,?)");
    $stmt->bind_param("ssssssss", $UserType, $Phone, $Email,$ScaleOfInvestment, $MeetingDate, $Name,$SProject,$CreatedOn);
    $UserType = $values["ActivityType"];
    $Phone = $values["contact"];
    $Email = $values["email"];
    $ScaleOfInvestment = $values["investment"];
    $MeetingDate = $values["meetingdate"];
    $Name = $values["name"];
    $SProject = $values["sproject"];
    date_default_timezone_set('Asia/Kolkata');
    $timestamp = date("Y-m-d H:i:s");
    $CreatedOn=$timestamp;
    $stmt->execute();
    if($stmt->error){
        return $stmt->error;
    } else {
        return $stmt->insert_id;
    }
    }
    catch(Exception $e)
    {
    return "Error: " . $e->getMessage();
    }
    $stmt->close();
}
function GetUserDetails($Id,$conn){
    $stmt = $conn->prepare('SELECT * FROM Users WHERE Id = ?');
    $stmt->bind_param('s', $Id); // 's' specifies the variable type => 'string'
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        return $details=Array(
        "Email"=> $row['Email'],
        "ActivityType"=>$row['ActivityType'],
        "RegId"=> $Id,
        "Name"=> $row['Name'],
        "Phone"=> $row['Phone']
        );
    }
}
