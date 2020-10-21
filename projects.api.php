<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT');

// Required files
require_once('config/database.php');
require_once('classes/project.class.php');

// Save the request method for later use
$method = $_SERVER['REQUEST_METHOD'];

// If a param of ID is set, save that too
if(isset($_GET['id'])) {
   $id = $_GET['id'] != '' ? $_GET['id'] : null;
}

// Database instance
$database = new Database();
$dbConn = $database->connect();

// Work instance
$project = new Projects($dbConn);

// Depending on which request method is used, return or manipulate data
switch($method) {
   case 'GET':
      if(!isset($id)) {
         $result = $project->read();
      } else {
         $result = $project->readOne($id);
      }

      if(sizeof($result) > 0) {
         http_response_code(200); // OK
      } else {
         http_response_code(404); // Not found
         $result = array('message' => 'No result found');
      }
      break;
   case 'POST':
      $data = json_decode(file_get_contents('php://input'));

      $project->title = $data->title;
      $project->url = $data->url;
      $project->description = $data->description;

      if($project->create()) {
         http_response_code(201); // Created
         $result = array('message' => 'Project created');
      } else {
         http_response_code(503); // Server error
         $result = array('message' => 'Something went wrong when creating project');
      }
      break;
   case 'PUT':
      if(!isset($id)) {
         http_response_code(510); // Not extended
         $result = array('message' => 'No id found');
      } else {
         $data = json_decode(file_get_contents('php://input'));

         $project->title = $data->title;
         $project->url = $data->url;
         $project->description = $data->description;

         if($project->update($id)) {
            http_response_code(200); // OK
            $result = array('message' => 'Project updated');
         } else {
            http_response_code(503); // Server error
            $result = array('message' => 'Something went wrong when updating project');
         }
      }
      break;
   case 'DELETE':
      if(!isset($id)) {
         http_response_code(510); // Not extended
         $result = array('message' => 'No id found');
      } else {
         if($project->delete($id)) {
            http_response_code(200); // OK
            $result = array('message' => 'Project is deleted');
         } else {
            http_response_code(503); // Server error
            $result = array('message' => 'Something went wrong when deleting project');
         }
      }
      break;
}

// Echo the result as JSON
echo json_encode($result);

// Close DB connection
$db = $database->close();