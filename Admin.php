<?php
/*
 File Name   : Admin.php
 Date        : 3/15/2015
 Author      : Adam Lee Pero
 Description : 
  Manages the records within the Admin Table.
*/
 // Required Files
 require_once('Database.php');
 
 class Admin { 
  // ************************************************************************
  // GRANT - Grants administrative privileges to a user id.                 *
  // ************************************************************************
  public static function grant($id) {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("INSERT INTO indPrj_admin (personsID) VALUES (?)");
   
   $stmt->bind_param('i', $id);
    
   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
  
  // ************************************************************************
  // REVOKE - Removes a user id's administrative privileges.                *
  // ************************************************************************
  public static function revoke($id) {
   $mysqli = Database::getMYSQLI();
   
   $stmt = $mysqli->prepare("DELETE indPrj_admin FROM indPrj_admin WHERE id = ?");
   
   $stmt->bind_param('i', $id);
   
   $stmt->execute();
   $stmt->close();
   $mysqli->close();
  }
  
  // ************************************************************************
  // IS ADMIN - Returns true if the user id is an administrator.            *
  // ************************************************************************
  public static function isAdmin($id) {
   $str = "SELECT * FROM indPrj_admin WHERE personsID = '$id'";
   $rows = Database::query($str);
  
   if (mysql_num_rows($rows) == 1) return true;
   else                            return false;
  }
 }
?>
