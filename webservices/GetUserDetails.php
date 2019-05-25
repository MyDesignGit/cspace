<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
include './config.php';
function GetUserDetailsByDates($from,$to,$conn){
    $stmt = $conn->prepare('SELECT * FROM Users WHERE (CreatedOn BETWEEN ? AND ?)');
    $stmt->bind_param('ss', $from,$to); // 's' specifies the variable type => 'string'
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        return $details=Array(
        "Email"=> $row['Email'],
        "ActivityType"=>$row['ActivityType'],
        "RegId"=> $row['Id'],
        "Name"=> $row['Name'],
        "Phone"=> $row['Phone']
        );
    }
}
$data = json_decode(file_get_contents('php://input'), true);
if($data){
$result=GetUserDetailsByDates($data["FromDate"],$data["ToDate"],$conn);  
if($result!=NULL){
    echo json_encode($result);
} else {
    echo "No record Found";
}
}