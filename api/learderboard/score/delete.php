<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/global.php';
include_once '../config/database.php';
include_once '../objects/score.php';
  

// get database connection
$database = new Database();
$db = $database->getConnection();
  
$score = new Score($db);

// get id of score to be edited
$data = json_decode(file_get_contents("php://input"));


// check required fields
if(
    is_integer($data->id) &&
    $token == $data->token
    )
{


    // get score info
    $score->id = $data->id;
    $score->readOne();

    if($score->name!=null){


      


        // update the score
        if($score->delete()){
        
            // set response code - 200 ok
            http_response_code(200);
            echo json_encode(array("message" => "Score is deleted."));
        }
        
        // if unable to update the score, tell the user
        else{
        
            // set response code - 503 service unavailable
            http_response_code(503);
            echo json_encode(array("message" => "Unable to update score."));
        }
        


    }
    
    else{
        // set response code - 404 Not found
        http_response_code(404);
        echo json_encode(array("message" => "User does not exist."));
    }
} 
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Unable to update score. Data is incomplete."));
}

?>