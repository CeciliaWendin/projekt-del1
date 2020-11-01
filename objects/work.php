<?php
class Work{
  
    // database connection and table name
    private $conn;
    private $table_name = "work";
  
    // object properties
    public $id;
    public $workplace;
    public $title;
    public $workdesc;
    public $startdate;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
function read(){
  
    // select all query
    $query = "SELECT
                *
            FROM
                " . $this->table_name . " 
            ORDER BY
                startdate DESC";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}
// create course
function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                workplace=:workplace, title=:title, workdesc=:workdesc, startdate=:startdate";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->workplace=htmlspecialchars(strip_tags($this->workplace));
    $this->title=htmlspecialchars(strip_tags($this->title));
    $this->workdesc=htmlspecialchars(strip_tags($this->workdesc));
    $this->startdate=htmlspecialchars(strip_tags($this->startdate));
  
    // bind values
    $stmt->bindParam(":workplace", $this->workplace);
    $stmt->bindParam(":title", $this->title);
    $stmt->bindParam(":workdesc", $this->workdesc);
    $stmt->bindParam(":startdate", $this->startdate);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}
// used when filling up the update course form
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
  
    // bind id of course to be updated
    $stmt->bindParam(1, $this->id);
  
    // execute query
    $stmt->execute();
  
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    // set values to object properties
    $this->workplace = $row['workplace'];
    $this->title = $row['title'];
    $this->workdesc = $row['workdesc'];
    $this->startdate = $row['startdate'];
}
// update the course
function update(){
  
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                workplace = :workplace,
                title = :title,
                workdesc = :workdesc,
                startdate = :startdate
            WHERE
                id = :id";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->workplace=htmlspecialchars(strip_tags($this->workplace));
    $this->title=htmlspecialchars(strip_tags($this->title));
    $this->workdesc=htmlspecialchars(strip_tags($this->workdesc));
    $this->startdate=htmlspecialchars(strip_tags($this->startdate));
  
    // bind new values
    $stmt->bindParam(":workplace", $this->workplace);
    $stmt->bindParam(":title", $this->title);
    $stmt->bindParam(":workdesc", $this->workdesc);
    $stmt->bindParam(":startdate", $this->startdate);
    $stmt->bindParam(':id', $this->id);
  
    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
// delete the course
function delete(){
  
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
  
    // bind id of record to delete
    $stmt->bindParam(1, $this->id);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
}
?>