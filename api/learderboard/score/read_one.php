<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/score.php';

// instantiate database and score object
$database = new Database();
$db = $database->getConnection();

$score = new Score($db);
if(
    is_integer( intval($_GET['id']) ) &&
    intval($_GET['id']) > 0
    )
{
        // set ID property of record to read
        $score->id = $_GET['id'];
        $score->readOne();

        // check if record found
        if($score->name!=null){

            // scores array
          
            $score_item=array(
                "id" => $score->id,
                "name" => html_entity_decode($score->name),
                "age" => $score->age,
                "address" => html_entity_decode($score->address),
                "score" => $score->score
            );

            // set response code - 200 OK
            http_response_code(200);

            // show score data in json format
            echo json_encode($score_item);
        }

        // no scores found will be here

        else{

            // set response code - 404 Not found
            http_response_code(404);

            // tell the user no scores found
            echo json_encode(
                array("message" => "No scores found.")
            );
        }
    }
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to read score. Data is incomplete."));
}
?>

