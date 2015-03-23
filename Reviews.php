<?php
/*
 File Name   : Reviews.php
 Date        : 3/15/2015
 Author      : Adam Lee Pero
 Description : 
  Manages the records within the Reviews Table.
*/
 // Required Files
 require_once('Database.php');
 
 class Reviews { 
  // ******************************************************************************
  // toArray                                                                      *
  // Returns an associative array containing every record in the Reviews Table.   *
  // ******************************************************************************
  public static function toArray() {
   $str = "
    SELECT id, personsID, gamesID, review, rating
    FROM   indPrj_reviews";
   
   // Obtain an array of reviews records.
   $records = Database::query($str);
   
   // Push each row into a new array to be outputted.
   $x      = 0;
   $output = array();
   while($row = mysql_fetch_array($records)){
    $output[$x]['id']        = $row['id'];
    $output[$x]['personsID'] = $row['personsID'];
    $output[$x]['review']    = $row['review'];
    $output[$x]['rating']    = $row['rating'];
    $x++;
   }
   
   return $output;
  }
  
  // ******************************************************************************
  // GET BY GAMES ID                                                              *
  // Returns an associative array containing every Reviews record with the        *
  // matching Games ID.                                                           *
  // ******************************************************************************
  public static function getByGamesID($gamesID) {
   $str = "
    SELECT id, personsID, gamesID, review, rating
    FROM   indPrj_reviews
    WHERE  gamesID = " . $gamesID;
   
   // Obtain an array of reviews records.
   $records = Database::query($str);
   
   // Push each row into a new array to be outputted.
   $x      = 0;
   $output = array();
   while($row = mysql_fetch_array($records)){
    $output[$x]['id']        = $row['id'];
    $output[$x]['personsID'] = $row['personsID'];
    $output[$x]['gamesID']   = $row['gamesID'];
    $output[$x]['review']    = $row['review'];
    $output[$x]['rating']    = $row['rating'];
    $x++;
   }
   
   return $output;
  }
 
  // ******************************************************************************
  // GET BY ID                                                                    *
  // Returns an associative array of the Reviews Record with the matching ID.     *
  // ******************************************************************************
  public static function getByID($id) {
   $str = "
    SELECT id, personsID, gamesID, review, rating
    FROM   indPrj_reviews
    WHERE  id = " . $id;
    
   return mysql_fetch_array(Database::query($str));
  }
  
  // ******************************************************************************
  // Average Rating                                                               *
  // Returns the average rating for a specified game.                             *
  // ******************************************************************************
  public static function averageRating($gamesID) {
   $average = mysql_fetch_assoc(Database::query("
    SELECT AVG(rating) 
    AS     rating
    FROM   indPrj_reviews 
    WHERE  gamesID = " . $gamesID));
    
   return (integer)$average[rating];
  }
  
  // ******************************************************************************
  // NUM REVIEWS FOR GAME BY PERSON                                               *
  // Returns the number of reviews that exist for a specified game made by        *
  // a specified person.                                                          *
  // ******************************************************************************
  public static function numReviewsForGameByPerson($gamesID, $personsID) {
   $count = mysql_fetch_assoc(Database::query("
    SELECT COUNT(*)
    AS     num
    FROM   indPrj_reviews
    WHERE  personsID = " . $personsID . " AND  gamesID = " . $gamesID));
   
   return $count[num];
  }
 
  // ************************
  // DATABASE MANAGEMENT    *
  // ************************
 
  // ************************************************
  // ADD - Adds a record to the database.           *
  // ************************************************
  public static function add($personsID, $gamesID, $review, $rating) {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    INSERT INTO indPrj_reviews (personsID, gamesID, review, rating)
    VALUES (?,?,?,?)");
   
   $stmt->bind_param('iiss', $personsID, $gamesID, $review, $rating);
    
   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
  
  // ************************************************
  // UPDATE - Updates a record within the database. *
  // ************************************************
  public static function update($id, $personsID, $gamesID, $review, $rating) {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    UPDATE indPrj_reviews
    SET personsID = ?, gamesID = ?, review = ?, rating = ?
    WHERE id = ?");
    
   $stmt->bind_param('iisii', $personsID, $gamesID, $review, $rating, $id);

   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
  
  // ************************************************
  // DELETE - Deletes a record within the database. *
  // ************************************************
  public static function delete($id) {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("DELETE indPrj_reviews FROM indPrj_reviews WHERE id = ?");
   
   $stmt->bind_param('i', $id);
   
   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
  
  // ************************
  // INPUT VALIDATION       *
  // ************************
  
  // *******************************************************************
  // VALIDATE RATING                                                   *
  // Must be a single digit number between 1 and 5.                    *
  // *******************************************************************
  public static function validateRating($rating) {
   if (!is_numeric($rating) || $rating < 1 || $rating > 5) 
    return false; 
   else 
    return true;
  }
 } 
?>
