<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/project.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare project object
$project = new Project($db);
  
// get id of project to be edited
$data = json_decode(file_get_contents("php://input"));
  
// set ID property of project to be edited
$project->id = $data->id;
  
// set project property values
$project->title = $data->title;
$project->url = $data->url;
$project->description = $data->description;
$project->img_url = $data->img_url;
  
// update the project
if($project->update()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "project was updated."));
}
  
// if unable to update the project, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to update project."));
}
?>