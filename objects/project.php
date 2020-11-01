<?php
class Project{
  
    // database connection and table name
    private $conn;
    private $table_name = "projects";
  
    // object properties
    public $id;
    public $title;
    public $url;
    public $description;
    public $img_url;
  
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
                title DESC";
  
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
                title=:title, url=:url, description=:description, img_url=:img_url";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->title=htmlspecialchars(strip_tags($this->title));
    $this->url=htmlspecialchars(strip_tags($this->url));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->img_url=htmlspecialchars(strip_tags($this->img_url));
  
    // bind values
    $stmt->bindParam(":title", $this->title);
    $stmt->bindParam(":url", $this->url);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":img_url", $this->img_url);
  
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
    $this->title = $row['title'];
    $this->url = $row['url'];
    $this->description = $row['description'];
    $this->img_url = $row['img_url'];
}
// update the course
function update(){
  
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                title = :title,
                url = :url,
                description = :description
            WHERE
                id = :id";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->title=htmlspecialchars(strip_tags($this->title));
    $this->url=htmlspecialchars(strip_tags($this->url));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->img_url=htmlspecialchars(strip_tags($this->img_url));
  
    // bind new values
    $stmt->bindParam(":title", $this->title);
    $stmt->bindParam(":url", $this->url);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":img_url", $this->img_url);
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