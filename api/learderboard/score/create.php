<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/global.php';
include_once '../config/database.php';
include_once '../objects/score.php';
  
$database = new Database();
$db = $database->getConnection();
  
$score = new Score($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->name) &&
    !empty($data->age) &&
    !empty($data->address) &&
    $token == $data->token
    )
{
  
    // set score property values
    $score->name = $data->name;
    $score->age = $data->age;
    $score->address = $data->address;
  
    // create the score
    if($score->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Score is created."));
    }
  
    // if unable to create the score, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create score."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create score. Data is incomplete."));
}
?>

