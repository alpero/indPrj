<?php
/*
 File Name   : Database.php
 Date        : 3/15/2015
 Author      : Adam Lee Pero
 Description : 
  Static class used for querying the database.
*/
 class Database {
  // ***********************
  // Data Members          *
  // ***********************
  private static $database = "CIS355alpero";
  private static $server   = "localhost";
  private static $username = "CIS355alpero";
  private static $password = "Power135";
  
  // ****************************************
  // QUERY                                  *
  // Send a query to the database and       *
  // returns the results to the caller.     *
  // ****************************************
  public static function query($str) { 
   // Connect to the database.
   $connection = mysql_connect(self::$server, self::$username, self::$password)
    or die ("Connection Error: ".mysql_error());
   
   // Select the database.
   mysql_select_db(self::$database) 
    or die ("Error selecting DB: ".mysql_error());
   
   // Obtain query result.
   $output = mysql_query($str);
   
   // Close the database connection
   mysql_close($connection);
   
   // Return query result.
   return $output;
  }
  
  // ****************************************
  // GET MYSQLI                             *
  // ****************************************
  public static function getMYSQLI() {
   $mysqli = new mysqli(self::$server, self::$username, self::$password, 
    self::$database);

   // check connection
   if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
   }
   
   return $mysqli;
  }
  
  // ****************************************
  // Create Tables                          *
  // Creates all of the tables within the   *
  // database if they do not already exist. *
  // ****************************************
  public static function createTables() {
   // PERSONS TABLE
   $personsTable = "
    CREATE TABLE IF NOT EXISTS `indPrj_persons` ( 
     `id`        int(11)      NOT NULL AUTO_INCREMENT, 
     `firstName` varchar(20)  NOT NULL, 
     `lastName`  varchar(20)  NOT NULL, 
     `email`     varchar(50)  NOT NULL, 
     `password`  varchar(128) NOT NULL, 
     PRIMARY KEY (`id`) )";
  
   // GAMES TABLE
   $gamesTable = "
    CREATE TABLE IF NOT EXISTS `indPrj_games` ( 
     `id`          int(11)      NOT NULL AUTO_INCREMENT,
     `title`       varchar(20)  NOT NULL, 
     `description` varchar(20)  NOT NULL, 
     PRIMARY KEY (`id`) )";
    
   // REVIEWS TABLE 
   $reviewsTable = "
    CREATE TABLE IF NOT EXISTS `indPrj_reviews` ( 
     `id`        int(11)      NOT NULL AUTO_INCREMENT, 
     `personsID` int(11)      NOT NULL, 
     `gamesID`   int(11)      NOT NULL, 
     `review`    varchar(20)  NOT NULL, 
     `rating`    int(11)      NOT NULL, 
     PRIMARY KEY (`id`), 
     FOREIGN KEY (personsID) REFERENCES indPrj_persons(id),
     FOREIGN KEY (gamesID)   REFERENCES indPrj_games(id) )";
    
   // ADMIN TABLE
   $adminTable = "
    CREATE TABLE IF NOT EXISTS `indPrj_admin` (
     `id`        int(11) NOT NULL AUTO_INCREMENT,
     `personsID` int(11) NOT NULL,
     PRIMARY KEY (`id`),
     FOREIGN KEY (personsID) REFERENCES indPrj_persons(id) )";
     
   $reportsTable = "
    CREATE TABLE IF NOT EXISTS `indPrj_reports` (
     `id`        int(11)      NOT NULL AUTO_INCREMENT,
     `personsID` int(11)      NOT NULL,
     `reviewsID` int(11)      NOT NULL,
     `reason`    ENUM('Offensive Language', 'Verbal Abuse', 'other'),
     `comment`   varchar(20),
     `status`    ENUM('OPEN', 'VALID', 'INVALID') NOT NULL,
     PRIMARY KEY (`id`),
     FOREIGN KEY (personsID) REFERENCES indPrj_persons(id),
     FOREIGN KEY (personsID) REFERENCES indPrj_persons(id) )";
     
   // Create Tables
   self::query($personsTable);
   self::query($gamesTable);
   self::query($reviewsTable);
   self::query($adminTable);
   self::query($reportsTable);
  }
 }
?>
