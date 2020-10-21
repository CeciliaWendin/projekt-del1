<?php
class Projects {
   // Connection
   private $conn;

   // DB table
   private $table = 'projects';

   // DB columns
   public $id;
   public $title;
   public $url;
   public $description;

   // Constructor 
   public function __construct($dbConn) {
      $this->conn = $dbConn;
   }

   // READ
   public function read() {
      $query = 'SELECT * FROM ' . $this->table;
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      $num = $stmt->rowCount();

      $data = array();
  
      if ($num > 0) {
         $data['data'] = array();
         $data['itemCount'] = $num;

         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row); // extract data from row as variables

            $project = array(
               'id' => $id,
               'title' => $title,
               'url' => $url,
               'description' => $description
            );

            array_push($data['data'], $project);
         }
      }
      return $data;
   }

   // READ ONE
   public function readOne($id) {
      $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ' . $id . ' LIMIT 1';
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if(!$data) {
         $data = array();
      }

      return $data;

   }

   // CREATE
   public function create() {
      $query = 'INSERT INTO 
                  ' . $this->table . '
               SET
                  title = :title,
                  url = :url,
                  description = :description'; 

      $stmt = $this->conn->prepare($query);
      
      // Sanitize input
      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->url = htmlspecialchars(strip_tags($this->url));
      $this->description = htmlspecialchars(strip_tags($this->description));

      // Bind data to params
      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':url', $this->url);
      $stmt->bindParam(':description', $this->description);

      if($stmt->execute()) {
         return true;
      }

      return false;
   }
   
   // UPDATE
   public function update($id) {
      $query = 'UPDATE 
                  ' . $this->table . '
               SET
               title = :title,
               url = :url,
               description = :description
               WHERE
                  id = :id';
      $stmt = $this->conn->prepare($query);

      // Sanitize input
      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->url = htmlspecialchars(strip_tags($this->url));
      $this->description = htmlspecialchars(strip_tags($this->description));


      // Bind data to params
      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':url', $this->url);
      $stmt->bindParam(':description', $this->description);

      if($stmt->execute()) {
         return true;
      }

      return false;
   }

   // DELETE
   public function delete($id) {
      $query = 'DELETE FROM
                  ' . $this->table . '
               WHERE
                  id = :id';
      $stmt = $this->conn->prepare($query);

      // Sanitize input
      $this->id = htmlspecialchars(strip_tags($id));

      // Bind data to params
      $stmt->bindParam(':id', $this->id);

      if($stmt->execute()) {
         return true;
      }

      return false;
   }
}