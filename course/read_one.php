<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/course.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare course object
$course = new Course($db);
  
// set ID property of record to read
$course->id = isset($_GET['id']) ? $_GET['id'] : die();
  
// read the details of course to be edited
$course->readOne();
  
if($course->name!=null){
    // create array
    $course_arr = array(
        "id" =>  $course->id,
        "university" => $course->university,
        "name" => $course->name,
        "startdate" => $course->startdate
  
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($course_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user course does not exist
    echo json_encode(array("message" => "Course does not exist."));
}
?>