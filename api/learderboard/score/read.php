<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/score.php';

// instantiate database and score object
$database = new Database();
$db = $database->getConnection();

$score = new Score($db);

// query score
$stmt = $score->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // scores array
    $scores_arr=array();
    $scores_arr["records"]=array();

    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $score_item=array(
            "id" => $id,
            "name" => html_entity_decode($name),
            "age" => $age,
            "address" => html_entity_decode($address),
            "score" => $score
        );

        array_push($scores_arr["records"], $score_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show scores data in json format
    echo json_encode($scores_arr);
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
