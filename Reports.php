<?php
/*
 File Name   : Reports.php
 Date        : 3/21/2015
 Author      : Adam Lee Pero
 Description : 
  Manages the records within the Reports Table.
*/
 // Required Files
 require_once('Database.php');
 
 class Reports {
  // ******************************************************************************
  // toArray                                                                      *
  // Returns an associative array containing every record in the Reports Table.   *
  // ******************************************************************************
  public static function toArray() {
   $str = "
    SELECT personsID, reviewsID, reason, comment, status
    FROM   indPrj_reports";
   
   // Obtain an array of reports records.
   $records = Database::query($str);
   
   // Push each row into a new array to be outputted.
   $x      = 0;
   $output = array();
   while($row = mysql_fetch_array($records)){
    $output[$x]['id']        = $row['id'];
    $output[$x]['personsID'] = $row['personsID'];
    $output[$x]['reviewsID'] = $row['reviewsID'];
    $output[$x]['reason']    = $row['reason'];
    $output[$x]['comment']   = $row['comment'];
    $output[$x]['status']    = $row['status'];
    $x++;
   }
   
   return $output;
  }
  
  
  // ******************************************************************************
  // GET OPEN                                                                     *
  // Returns an associative array containing every open report.                   *
  // ******************************************************************************
  public static function getOpen(){
   $str = "
    SELECT id, personsID, reviewsID, reason, comment, status
    FROM   indPrj_reports
    WHERE  status = 'OPEN'";
   
   // Obtain an array of reports records.
   $records = Database::query($str);
   
   // Push each row into a new array to be outputted.
   $x      = 0;
   $output = array();
   while($row = mysql_fetch_array($records)){
    $output[$x]['id']        = $row['id'];
    $output[$x]['personsID'] = $row['personsID'];
    $output[$x]['reviewsID'] = $row['reviewsID'];
    $output[$x]['reason']    = $row['reason'];
    $output[$x]['comment']   = $row['comment'];
    $output[$x]['status']    = $row['status'];
    $x++;
   }
   
   return $output;  
  }
  
  // ******************************************************************************
  // GET VALID                                                                    *
  // Returns an associative array containing every valid report.                  *
  // ******************************************************************************
  public static function getValid() {
   $str = "
    SELECT personsID, reviewsID, reason, comment, status
    FROM   indPrj_reports
    WHERE  status = 'VALID'";
   
   // Obtain an array of reports records.
   $records = Database::query($str);
   
   // Push each row into a new array to be outputted.
   $x      = 0;
   $output = array();
   while($row = mysql_fetch_array($records)){
    $output[$x]['id']        = $row['id'];
    $output[$x]['personsID'] = $row['personsID'];
    $output[$x]['reviewsID'] = $row['reviewsID'];
    $output[$x]['reason']    = $row['reason'];
    $output[$x]['comment']   = $row['comment'];
    $output[$x]['status']    = $row['status'];
    $x++;
   }
   
   return $output;
  }
  
  // ******************************************************************************
  // GET INVALID                                                                  *
  // Returns an associative array containing every invalid report.                *
  // ******************************************************************************
  public static function getInvalid() {
   $str = "
    SELECT personsID, reviewsID, reason, comment, status
    FROM   indPrj_reports
    WHERE  status = 'INVALID'";
   
   // Obtain an array of reports records.
   $records = Database::query($str);
   
   // Push each row into a new array to be outputted.
   $x      = 0;
   $output = array();
   while($row = mysql_fetch_array($records)){
    $output[$x]['id']        = $row['id'];
    $output[$x]['personsID'] = $row['personsID'];
    $output[$x]['reviewsID'] = $row['reviewsID'];
    $output[$x]['reason']    = $row['reason'];
    $output[$x]['comment']   = $row['comment'];
    $output[$x]['status']    = $row['status'];
    $x++;
   }
   
   return $output;
  }
 
  // ************************
  // DATABASE MANAGEMENT    *
  // ************************
 
  // ************************************************
  // ADD - Adds a record to the database.           *
  // ************************************************
  public static function add($personsID, $reviewsID, $reason, $comment, $status) {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    INSERT INTO indPrj_reports (personsID, reviewsID, reason, comment, status)
    VALUES (?,?,?,?,?)");
   
   $stmt->bind_param('iisss', $personsID, $reviewsID, $reason, $comment, $status);
    
   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
    
  // ************************************************
  // UPDATE - Updates a record within the database. *
  // ************************************************
  public static function update($id, $personsID, $reviewsID, $reason, $comment, $status) {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    UPDATE indPrj_reports
    SET    personsID = ?, reviewsID = ?, reason = ?, comment = ?, status = ?
    WHERE  id = ?");
    
   $stmt->bind_param('iiisi', $personsID, $reviewsID, $reason, $comment, $status, $id);

   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
  
  // ************************************************
  // DELETE - Deletes a record within the database. *
  // ************************************************
  public static function delete($id) {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("DELETE indPrj_reports FROM indPrj_reports WHERE id = ?");
   
   $stmt->bind_param('i', $id);
   
   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
  
  // ************************************************
  // OPEN - Set status to open.                     *
  // ************************************************
  public static function open($id) {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    UPDATE indPrj_reports
    SET    status = 'OPEN'
    WHERE  id = ?");
    
   $stmt->bind_param('i', $id);

   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
  
  // ************************************************
  // VALID - Set status to valid.                   *
  // ************************************************
  public static function valid($id) {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    UPDATE indPrj_reports
    SET    status = 'VALID'
    WHERE  id = ?");
    
   $stmt->bind_param('i', $id);

   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
  
  // ************************************************
  // INVALID - Set status to invalid.               *
  // ************************************************
  public static function invalid($id) {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    UPDATE indPrj_reports
    SET    status = 'INVALID'
    WHERE  id = ?");
    
   $stmt->bind_param('i', $id);

   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
 }
?>
