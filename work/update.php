<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/work.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare work object
$work = new Work($db);
  
// get id of work to be edited
$data = json_decode(file_get_contents("php://input"));
  
// set ID property of work to be edited
$work->id = $data->id;
  
// set work property values
$work->workplace = $data->workplace;
$work->title = $data->title;
$work->workdesc = $data->workdesc;
$work->startdate = $data->startdate;

  
// update the work
if($work->update()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "work was updated."));
}
  
// if unable to update the work, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to update work."));
}
?>