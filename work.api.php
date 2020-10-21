<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT');

// Required files
require_once('config/database.php');
require_once('classes/work.class.php');

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
$work = new Work($dbConn);

// Depending on which request method is used, return or manipulate data
switch($method) {
   case 'GET':
      if(!isset($id)) {
         $result = $work->read();
      } else {
         $result = $work->readOne($id);
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

      $work->workplace = $data->workplace;
      $work->title = $data->title;
      $work->workdesc = $data->workdesc;
      $work->startdate = $data->startdate;
      $work->enddate = $data->enddate;

      if($work->create()) {
         http_response_code(201); // Created
         $result = array('message' => 'Work created');
      } else {
         http_response_code(503); // Server error
         $result = array('message' => 'Something went wrong when creating work');
      }
      break;
   case 'PUT':
      if(!isset($id)) {
         http_response_code(510); // Not extended
         $result = array('message' => 'No id found');
      } else {
         $data = json_decode(file_get_contents('php://input'));

         $work->workplace = $data->workplace;
         $work->title = $data->title;
         $work->workdesc = $data->workdesc;
         $work->startdate = $data->startdate;
         $work->enddate = $data->enddate;

         if($work->update($id)) {
            http_response_code(200); // OK
            $result = array('message' => 'Work updated');
         } else {
            http_response_code(503); // Server error
            $result = array('message' => 'Something went wrong when updating work');
         }
      }
      break;
   case 'DELETE':
      if(!isset($id)) {
         http_response_code(510); // Not extended
         $result = array('message' => 'No id found');
      } else {
         if($work->delete($id)) {
            http_response_code(200); // OK
            $result = array('message' => 'Work is deleted');
         } else {
            http_response_code(503); // Server error
            $result = array('message' => 'Something went wrong when deleting work');
         }
      }
      break;
}

// Echo the result as JSON
echo json_encode($result);

// Close DB connection
$db = $database->close();