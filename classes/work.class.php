<?php
class Work {
   // Connection
   private $conn;

   // DB table
   private $table = 'work';

   // DB columns
   public $id;
   public $workplace;
   public $title;
   public $workdesc;
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

            $work = array(
               'id' => $id,
               'workplace' => $workplace,
               'title' => $title,
               'workdesc' => $workdesc,
               'startdate' => $startdate,
               'enddate' => $enddate
            );

            array_push($data['data'], $work);
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
                  workplace = :workplace,
                  title = :title,
                  workdesc = :workdesc,
                  startdate = :startdate,
                  enddate = :enddate';
      $stmt = $this->conn->prepare($query);
      
      // Sanitize input
      $this->workplace = htmlspecialchars(strip_tags($this->workplace));
      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->workdesc = htmlspecialchars(strip_tags($this->workdesc));
      $this->startdate = htmlspecialchars(strip_tags($this->startdate));
      $this->enddate = htmlspecialchars(strip_tags($this->enddate));

      // Bind data to params
      $stmt->bindParam(':workplace', $this->workplace);
      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':workdesc', $this->workdesc);
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
               workplace = :workplace,
                  title = :title,
                  workdesc = :workdesc,
                  startdate = :startdate,
                  enddate = :enddate
               WHERE
                  id = :id';
      $stmt = $this->conn->prepare($query);

      // Sanitize input
      $this->id = htmlspecialchars(strip_tags($id));
      $this->workplace = htmlspecialchars(strip_tags($this->workplace));
      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->workdesc = htmlspecialchars(strip_tags($this->workdesc));
      $this->startdate = htmlspecialchars(strip_tags($this->startdate));
      $this->enddate = htmlspecialchars(strip_tags($this->enddate));


      // Bind data to params
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':workplace', $this->workplace);
      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':workdesc', $this->workdesc);
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