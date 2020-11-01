<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/work.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare work object
$work = new Work($db);
  
// set ID property of record to read
$work->id = isset($_GET['id']) ? $_GET['id'] : die();
  
// read the details of work to be edited
$work->readOne();
  
if($work->workplace!=null){
    // create array
    $work_arr = array(
        "id" =>  $work->id,
        "workplace" => $work->workplace,
        "title" => $work->title,
        "workdesc" => $work->workdesc,
        "startdate" => $work->startdate
  
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($work_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user work does not exist
    echo json_encode(array("message" => "work does not exist."));
}
?>