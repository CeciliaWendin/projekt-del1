<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/course.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare course object
$course = new Course($db);
  
// get id of course to be edited
$data = json_decode(file_get_contents("php://input"));
  
// set ID property of course to be edited
$course->id = $data->id;
  
// set course property values
$course->university = $data->university;
$course->name = $data->name;
$course->startdate = $data->startdate;

  
// update the course
if($course->update()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "course was updated."));
}
  
// if unable to update the course, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to update course."));
}
?>