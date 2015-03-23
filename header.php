<?php
/*
 File Name   : header.php
 Date        : 3/08/2015
 Author      : Adam Lee Pero
 Description : 
  Defines the layout and functionality of every page.
*/
 // Session Start
 if (session_status() !== PHP_SESSION_ACTIVE) session_start();

 // ************************************************************************
 // DISPLAY LOGO ONLY                                                      *
 // This function is meant for pages that wish to display the sites logo   *
 // but not implement the rest of the header file.                         *
 // ************************************************************************
 function displayLogoOnly() {
  echo "<center><img src='img/banner.png' alt='banner'></center>";
 }
 
 // ************************************************************************ 
 // ADD HEADER                                                             *
 // Defines common functionality for every UI File.                        *
 // - Displays a welcome message.                                          *
 // - Generates a link that allows the user to log out of the website      *
 //  from the page they are currently on.                                  *
 // ************************************************************************
 function addHeader() {  
  // Display the sites logo.
  displayLogoOnly();
  
  // If the user is currently logged in...
  if (isset($_SESSION['email']))
   // display a welcome message.  
   echo "<div align='right'>Welcome, " . $_SESSION[firstName] . " " . $_SESSION[lastName] 
    . "." . " (<a href=\"login.php?action=logout\">logout</a>)</div>";
    
  // If the user is not currently logged in...
  else
   // ask the user to log in.
   echo "<div align='right'>Welcome! " . "(<a href=\"login.php\">login</a>" .
    " | <a href=\"register.php\">register</a>)</div>";
 }
 
 // ************************************************************************
 // BACK BUTTON                                                            *
 // Displays a link that directs back to the calling page.                 *
 // ************************************************************************
 function backButton() {
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  echo "<p>&larr; <a href='" . $fileName . "'>BACK</a></p>";
 }
 // ************************************************************************
 // REQUIRE SESSION                                                        *
 // Require an active session.                                             *
 // ************************************************************************
 function requireSession() {
  if (!isset($_SESSION['email'])) header('Location: login.php');
 }
?>
