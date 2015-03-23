<?php
/*
 File Name   : viewGame.php
 Date        : 3/15/2015
 Author      : Adam Lee Pero
 Description : 
  Displays a single game and a list of reviews for said game.
  Allows administrators to add, edit, and delete games.
*/
 // Required Files
 require_once("header.php");
 require_once("Reviews.php");
 require_once("gamesUI.php");
 require_once("reviewsUI.php");
 
 // Require Active Session
 requireSession();
 
 // Add the header to the page.
 addHeader();
 
 // ************************************************************************
 // If a new review was submitted...
 if (isset($_POST['submit']) && $_POST['submit'] == 'Submit Review') {
  Reviews::add($_SESSION['id'], $_POST['gamesID'], $_POST['review'], $_POST['rating']);
  header('Location: viewGame.php?id=' . $_POST['gamesID']);
 }
 
 // If a review edit was submitted...
 if (isset($_POST['submit']) && $_POST['submit'] == 'Edit Review') {
  Reviews::update($_POST['id'], $_POST['personsID'], $_POST['gamesID'], 
   $_POST['review'], $_POST['rating']);
  header('Location: viewGame.php?id=' . $_POST['gamesID']);
 }
 
 // If the edit button was pressed from the listReviews function...
 elseif (isset($_POST['editReview'])) {
  editReviewForm();
  echo "<p>&larr; <a href='viewGame.php?id=" . $_POST['gamesID'] . "'>BACK</a></p>";
 }
 
 // If the delete button was pressed from the listReviews function...
 elseif (isset($_POST['deleteReview'])) {
  $rec = unserialize($_POST['record']);
  Reviews::delete($rec['id']);
  header('Location: viewGame.php?id=' . $_POST['gamesID']);
 }
 
 // If the report button was pressed from the listReviews functions...
 elseif (isset($_POST['reportReview'])) {
  // Redirect to the Submit Report page, and pass it post data.
  $rec = unserialize($_POST['record']);
  echo "<form method='POST' name='frm' action='handleReports.php'>"  .
   "<input type='hidden' name='reportSubmitted'                  >" .
   "<input type='hidden' name='reviewsID' value='$rec[id]'       >" .
   "<input type='hidden' name='personsID' value='$rec[personsID]'>" .
   "<input type='hidden' name='gamesID'   value='$rec[gamesID]'>"   .
   "<input type='hidden' name='review'    value='$rec[review]'   >" .
   "</form><script>document.frm.submit();</script>";
 }
 
 else firstVisit();
 // ************************************************************************
 
 // ************************************************************************
 // FIRST VISIT - Actions to be performed when no button has been pressed. *
 // ************************************************************************
 function firstVisit() {
  // View selected game if get is set.
  if (isset($_GET['id'])) {
   // View selected game.
   viewGame($_GET['id']);
   
   // View reviews for selected game.
   listReviews($_GET['id']);
   
   // Add reviews form if the current user has not already added a review.
   if (Reviews::numReviewsForGameByPerson($_GET[id], $_SESSION[id]) == 0)
    addReviewForm();
    
   // Back Button
   echo "<p>&larr; <a href='listGames.php'>BACK</a></p>";
  
  // Redirect to the previous page if no game was selected.
  } else header('Location: listGames.php');
 }
?>
