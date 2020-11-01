<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate work object
include_once '../objects/work.php';
  
$database = new Database();
$db = $database->getConnection();
  
$work = new Work($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->workplace) &&
    !empty($data->title) &&
    !empty($data->workdesc) &&
    !empty($data->startdate) 
){
  
    // set work property values
    $work->workplace = $data->workplace;
    $work->title = $data->title;
    $work->title = $data->workdesc;
    $work->startdate = $data->startdate;

  
    // create the work
    if($work->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "work was created."));
    }
  
    // if unable to create the work, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create work."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create work. Data is incomplete."));
}
?>