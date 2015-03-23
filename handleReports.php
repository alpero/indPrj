<?php
/*
 File Name   : Reports.php
 Date        : 3/21/2015
 Author      : Adam Lee Pero
 Description : 
  Handles report submissions, and administrative actions on the reports table.
*/
 // Required Files
 require_once("header.php");
 require_once("Reports.php");
 require_once("reportsUI.php");
 
 // Require Active Session
 requireSession();
 
 // Add the header to the page.
 addHeader();
 
 // If the Report Button was pressed from the viewGame page...
 if (isset($_POST['reportSubmitted'])) { 
  reportSubmissionForm();
  echo "<p>&larr; <a href='viewGame.php?id=" . $_POST['gamesID'] . "'>BACK</a></p>";
 }
 
 // If the Submit button was pressed from the Report Submission Form was pressed...
 elseif (isset($_POST['submitReport'])) {
  Reports::add($_SESSION[id], $_POST['reviewsID'], $_POST['reason'], $_POST['comment'],
   'OPEN');
  header('Location: viewGame.php?id=' . $_POST['gamesID']);
 }
 
 // If the View Reports button was pressed from the listGames page...
 elseif (isset($_POST['veiwReports'])) {
  echo "<h3>OPEN REPORTS:</h3>";
  displayOpenReports();
  echo "<h3>VALID REPORTS:</h3>";
  displayValidReports();
  echo "<h3>INVALID REPORTS:</h3>";
  displayInvalidReports();
  echo "<p>&larr; <a href='home.php'>BACK</a></p>";
 }
 
 // If the Valid button was pressed from the displayOpenReports function...
 elseif (isset($_POST['validReport'])) { 
  Reports::valid($_POST['id']);
  header('Location: home.php');
 }
 
 // If the Invalid button was pressed from the displayOpenReports function...
 elseif (isset($_POST['invalidReport'])) { echo $_POST[id] . "test2";
  Reports::invalid($_POST['id']);
  header('Location: home.php');
 }
 
 // No button was pressed...
 else header('Location home.php');
?>
