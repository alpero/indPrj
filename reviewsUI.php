<?php
/*
 File Name   : reviewsUI.php
 Date        : 3/15/2015
 Author      : Adam Lee Pero
 Description : 
  Contains functions for adding UI Forms pertaining to the Reviews Table.
*/
 // Required Files
 require_once('Persons.php');
 require_once('Games.php');
 require_once('Reviews.php');
 
 // ************************************************************************ 
 // ADD REVIEW FORM                                                        *
 // Displays a form for adding a review to the database.                   *
 // ************************************************************************
 function addReviewForm() {
  // Name of the file that is calling this function
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  
  echo "
   <form method='POST' action='$fileName'>
    <input type='hidden' name='id'      id='id' value=''         >
    <input type='hidden' name='gamesID' id='id' value='$_GET[id]'>
    <table>
     <tr>
      <td>Review: </td>
      <td><textarea name='review' rows='10' cols='50'></textarea></td>
     </tr><tr>
      <td>Rating: </td>
      <td>
        <select name='rating'>
         <option value='1'>1</option>
         <option value='2'>2</option>
         <option value='3'>3</option>
         <option value='4'>4</option>
         <option value='5'>5</option>
        </select> 
      </td>
     </tr><tr>
      <td><input type='submit' name='submit' id='submit' value='Submit Review'></td>
      <td><input type='reset' value='clear'></td>
     </tr>
    </table>
   </form>";
 }
 
 // ************************************************************************ 
 // EDIT REVIEW FORM                                                       *
 // Displays a form for editing a review within the database.              *
 // ************************************************************************
 function editReviewForm() {
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  $rec = unserialize($_POST['record']);
  
  echo "
   <form method='POST' action='$fileName'>
    <input type='hidden' name='id'        value=$rec[id]       >
    <input type='hidden' name='personsID' value=$rec[personsID]>
    <input type='hidden' name='gamesID'   value=$rec[gamesID]  >
    <table>
     <tr>
      <td>Review: </td>
      <td><textarea name='review' rows='10' cols='50'>". $rec['review'] ."</textarea></td>
     </tr><tr>
      <td>Rating: </td>
      <td>
        <select name='rating'>";
  
  // Select the previous rating.
  echo "<option value='1' ";
  if ($rec['rating'] == 1) echo "selected";
  echo ">1</option><option value='2' ";
  if ($rec['rating'] == 2) echo "selected";
  echo ">2</option><option value='3' ";
  if ($rec['rating'] == 3) echo "selected";
  echo ">3</option><option value='4' ";
  if ($rec['rating'] == 4) echo "selected";
  echo ">4</option><option value='5' ";
  if ($rec['rating'] == 5) echo "selected";
  echo ">5</option>";
  
  echo "</select> 
      </td>
     </tr><tr>
      <td><input type='submit' name='submit' id='submit' value='Edit Review'></td>
      <td><input type='reset' value='clear'></td>
     </tr>
    </table>
   </form>";
 }
 
 // ************************************************************************ 
 // LIST REVIEWS                                                           *
 // Displays a list of every review for a specified game.                  *
 // ************************************************************************
 function listReviews($gameID) {
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  $reviews  = Reviews::getByGamesID($gameID);
  $counter  = 1;
  
  // If no reviews were found...
  if (count($reviews) == 0) echo "No reviews for this game.<br><br>";
  
  // else, display reviews.
  else {
  // Used by the administrative buttons within the table.
  echo '
   <!-- function for setting the serialized record -->
   <script>
    function setRecord(rec) {
     document.getElementById("record").value = rec;
    }
   </script>';
  
   // Form and Table opening tags
   echo "<form method='POST' action='$fileName'>" .
    "<table border=1  width=1000><col width=250><col width=700><col width=50>";
   
   // Hidden Fields
   echo "<input type='hidden' id='record' name='record'>";
   echo "<input type='hidden' name='gamesID' value=$_GET[id]>";
    
   foreach ($reviews as $review) {
    $serializedReview = addslashes(serialize($review));
    $person = Persons::getByID($review['personsID']);
    
    // Left
    echo "<tr><td valign='top'><p>#" . $counter . "</p><p>" . $person['firstName'] 
     . " " . $person['lastName'] . "</p><p>Rated: " . $review['rating'] . "</td>";
     
    // Middle
    echo "<td valign='top'>" . $review['review'] . "</td>";
    
    // Right
    echo "<td valign='top'>";
    if ($_SESSION[id] == $review['personsID']) {
     echo "<input name='editReview' type='submit' value='   edit    '
	  onclick='setRecord(\"" . $serializedReview . "\")' />
      <input name='deleteReview' type='submit' value='delete'
      onclick='setRecord(\"" . $serializedReview . "\")'>"; 
    } else {
     echo "<input name='reportReview' type='submit' value='report '
      onclick='setRecord(\"" . $serializedReview . "\")'></td></tr>"; }
    
    $counter++;
   }
   
   // Form and Table closing tags
   echo "</table></form>";
  }
 }
?>
