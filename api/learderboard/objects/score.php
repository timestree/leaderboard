<?php
class Score{
  
    // database connection and table name
    private $conn;
    private $table_name = "scores";
  
    // object properties
    public $id;
    public $name;
    public $age;
    public $address;
    public $score;
    public $created;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }


    // read scores
    function read(){
    
        // select all query
        $query = "SELECT
                    id, name, age, address, score, created
                FROM
                    " . $this->table_name . " 
                WHERE archived != '1'
                ORDER BY
                    score desc, name asc";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // create scores
    function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name, age=:age, address=:address";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->age=htmlspecialchars(strip_tags($this->age));
        $this->address=htmlspecialchars(strip_tags($this->address));
    
        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":age", $this->age);
        $stmt->bindParam(":address", $this->address);
        
        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
        
    }

    // for update function
    function readOne(){
    
        // query to read single record
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " 
                WHERE
                    id = ?
                LIMIT
                    0,1";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind id of score to be updated
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->name = $row['name'];
        $this->score = $row['score'];
    }


    // update the score
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    score = :score
                WHERE
                    id = :id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->score=htmlspecialchars(strip_tags($this->score));
    
        // bind new values
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':score', $this->score);

        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        print_r ($stmt);

        return false;
    }



    // delete the score
    function delete(){
    
        // update query for archived
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    archived = 1
                WHERE
                    id = :id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // bind new values
        $stmt->bindParam(':id', $this->id);

        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        print_r ($stmt);

        return false;
    }

}
?>
