<?php
/*
 File Name   : Persons.php
 Date        : 3/15/2015
 Author      : Adam Lee Pero
 Description : 
  Manages the records within the Persons Table.
*/
 // Required Files
 require_once('Database.php');
 
 class Persons { 
  // ******************************************************************************
  // toArray                                                                      *
  // Returns an associative array containing every record in the Persons Table.   *
  // ******************************************************************************
  public static function toArray() {
   $str = "
    SELECT id, firstName, lastName, email, password
    FROM   indPrj_persons";
   
   // Obtain an array of persons records.
   $records = Database::query($str);
   
   // Push each row into a new array to be outputted.
   $x      = 0;
   $output = array();
   while($row = mysql_fetch_array($records)){
    $output[$x]['id']        = $row['id'];
    $output[$x]['firstName'] = $row['firstName'];
    $output[$x]['lastName']  = $row['lastName'];
    $output[$x]['email']     = $row['email'];
    $output[$x]['password']  = $row['password'];
    $x++;
   }
   
   return $output;
  }
 
  // ******************************************************************************
  // GET BY ID                                                                    *
  // Returns an associative array of the Persons Record with the matching ID.     *
  // ******************************************************************************
  public static function getByID($id) { 
   $str = "
    SELECT id, firstName, lastName, email, password
    FROM   indPrj_persons
    WHERE  id = " . $id;
    
   return mysql_fetch_array(Database::query($str));
  }
  
  // ******************************************************************************
  // GET BY EMAIL                                                                 *
  // Returns an associative array of the Persons Record with the matching ID.     *
  // ******************************************************************************
  public static function getByEMAIL($email) {
   $str = "
    SELECT id, firstName, lastName, email, password
    FROM   indPrj_persons
    WHERE  email ='" . $email . "'";
    
   return mysql_fetch_array(Database::query($str));
  }
 
  // ************************
  // DATABASE MANAGEMENT    *
  // ************************
 
  // ************************************************
  // ADD - Adds a record to the database.           *
  // ************************************************
  public static function add($firstName, $lastName, $email, $password) {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    INSERT INTO indPrj_persons (firstName, lastName, email, password)
    VALUES (?,?,?,?)");
   
   $stmt->bind_param('ssss', $firstName, $lastName, $email, $password);
    
   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
    
  // ************************************************
  // UPDATE - Updates a record within the database. *
  // ************************************************
  public static function update($id, $firstName, $lastName, $email, $passwordHash) {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("
    UPDATE indPrj_persons
    SET firstName = ?, lastName = ?, email = ?, passwordHash = ?
    WHERE id = ?");
    
   $stmt->bind_param('ssssi', $firstName, $lastName, $email, $passwordHash, $id);

   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
  
  // ************************************************
  // DELETE - Deletes a record within the database. *
  // ************************************************
  public static function delete($id) {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("DELETE indPrj_persons FROM indPrj_persons WHERE id = ?");
   
   $stmt->bind_param('i', $id);
   
   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }  
  
  // ************************
  // INPUT VALIDATION       *
  // ************************
  
  // *******************************************************************
  // VALIDATE NAME                                                     *
  // All names must contain only characters from the English alphabet. *
  // Numbers, special characters, and spaces are not allowed.          *
  // *******************************************************************
  public static function validateName($name) {
   if (preg_match("/^[a-zA-Z]*$/",$name))
    return true;
   else
    return false;
  }
  
  // *******************************************************************
  // VALIDATE EMAIL                                                    *
  // Checks to see if the email is formatted correctly.                *
  // Does not verify the existence of the email address.               *
  // *******************************************************************
  public static function validateEMAIL($email) {
   if (filter_var($email, FILTER_VALIDATE_EMAIL))
    return true;
   else
    return false;    
  }

  // *******************************************************************
  // VALIDATE PASSWORD                                                 *
  // Passwords must be between 4 and 8 characters, contains a          *
  // letter and number, and void of special characters or spaces.      *
  // *******************************************************************
  public static function validatePassword($password) {
   if (
    (strlen($password) > 8 || strlen($password) < 4) ||  // Check Length
    (!preg_match("#[0-9]+#",      $password))        ||  // Contains a number.
    (!preg_match("#[a-zA-Z]+#",   $password))        ||  // Contains a letter.
    (!preg_match("/^[a-z0-9]+$/i",$password)))           // No special characters.
   {
    // Password did not meet one of the requirements.
    return false;  
   } else {
    // Password meets all requirements.
    return true;
   }
  }
 } 
?>
