<?php
class Course {
   // Connection
   private $conn;

   // DB table
   private $table = 'courses';

   // DB columns
   public $id;
   public $university;
   public $name;
   public $startdate;
   public $enddate;

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

            $course = array(
               'id' => $id,
               'university' => $university,
               'name' => $name,
               'startdate' => $startdate,
               'enddate' => $enddate
            );

            array_push($data['data'], $course);
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
                  university = :university,
                  name = :name,
                  startdate = :startdate,
                  enddate = :enddate';
      $stmt = $this->conn->prepare($query);
      
      // Sanitize input
      $this->university = htmlspecialchars(strip_tags($this->university));
      $this->name = htmlspecialchars(strip_tags($this->name));
      //$this->startdate = htmlspecialchars(strip_tags($this->startdate));
      //$this->enddate = htmlspecialchars(strip_tags($this->enddate));

      // Bind data to params
      $stmt->bindParam(':university', $this->university);
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':startdate', $this->startdate);
      $stmt->bindParam(':enddate', $this->enddate);

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
               university = :university,
               name = :name,
               startdate = :startdate,
               enddate = :enddate
               WHERE
                  id = :id';
      $stmt = $this->conn->prepare($query);

      // Sanitize input
      $this->id = htmlspecialchars(strip_tags($id));
      $this->university = htmlspecialchars(strip_tags($this->university));
      $this->name = htmlspecialchars(strip_tags($this->name));
      //$this->startdate = htmlspecialchars(strip_tags($this->startdate));
      //$this->enddate = htmlspecialchars(strip_tags($this->enddate));


      // Bind data to params
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':university', $this->university);
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':startdate', $this->startdate);
      $stmt->bindParam(':enddate', $this->enddate);

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