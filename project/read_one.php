<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/project.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare project object
$project = new Project($db);
  
// set ID property of record to read
$project->id = isset($_GET['id']) ? $_GET['id'] : die();
  
// read the details of project to be edited
$project->readOne();
  
if($project->title!=null){
    // create array
    $project_arr = array(
        "id" =>  $project->id,
        "title" => $project->title,
        "url" => $project->url,
        "description" => $project->description
        "img_url" => $project->img_url
  
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($project_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user project does not exist
    echo json_encode(array("message" => "Project does not exist."));
}
?>