<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate project object
include_once '../objects/project.php';
  
$database = new Database();
$db = $database->getConnection();
  
$project = new Project($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->title) &&
    !empty($data->url) &&
    !empty($data->description) &&
    !empty($data->img_url) 
){
  
    // set project property values
    $project->title = $data->title;
    $project->url = $data->url;
    $project->description = $data->description;
    $project->img_url = $data->img_url;
  
    // create the project
    if($project->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Project was created."));
    }
  
    // if unable to create the project, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create project."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create project. Data is incomplete."));
}
?>