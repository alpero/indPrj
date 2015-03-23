<?php
/*
 File Name   : Home.php
 Date        : 3/15/2015
 Author      : Adam Lee Pero
 Description : 
  Landing page for the Game's Review site.
*/
 // Required Files
 require_once('header.php');
 require_once('Database.php');
 
 // Create the tables if they do not already exist.
 Database::createTables();
 
 // Require Active Session
 if (!isset($_SESSION['email'])) header('Location: login.php');
 
 // Redirect if the user is currently logged in.
 else header('Location: listGames.php');
?>
