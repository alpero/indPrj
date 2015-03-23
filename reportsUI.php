<?php
/*
 File Name   : reportsUI.php
 Date        : 3/21/2015
 Author      : Adam Lee Pero
 Description : 
  Contains functions for adding UI Forms pertaining to the Reports Table.
*/
 // Required Files
 require_once('Reports.php');
 require_once('Reviews.php');
  
 // ************************************************************************
 // REPORT SUBMISSION FORM                                                 *
 // Displays a form for submitting a report.                               *
 // ************************************************************************
 function reportSubmissionForm() { 
  // Name of the file that is calling this function
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  
  echo "
   <form method='POST' action='$fileName'>
    <input type='hidden' name='reviewsID' value=". $_POST['reviewsID'] .">
    <input type='hidden' name='gamesID'   value=". $_POST['gamesID']   .">
    <table border=1>
     <col width=1000>
     <tr><td>Original Review:<br>". $_POST['review'] ."</td></tr>
     <tr><td><table>
      <tr>
       <td>Reason: </td>
       <td>
        <select name='reason'>
         <option value='Offensive Language'>Offensive Language</option>
         <option value='Verbal Abuse'      >Verbal Abuse      </option>
         <option value='other'             >other             </option>
        </select>
       </td>
      </tr><tr>
       <td>Comment: </td>
       <td><textarea name='comment' rows='10' cols='50'></textarea></td>
      </tr>
     </table></td></tr>
    </table>
    <input type='submit' name='submitReport' value='Submit'>
    <input type='reset' value='clear'>
   </form>";
 }
 
 // ************************************************************************
 // DISPLAY OPEN REPORTS                                                   *
 // Displays a list of open reports and allows them to be declared         *
 // valid or invalid.                                                      *
 // ************************************************************************
 function displayOpenReports() {
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  $reports = Reports::getOpen();
  
  // Used by the select button within the table.
  echo '
   <!-- function for setting the serialized record -->
   <script>
    function setID(num) { 
     document.getElementById("id").value = num;
    }
   </script>';
  
  // Opening Tags
  echo "
   <form method='POST' action='$fileName'>
   <input type='hidden' id='id' name='id' value=''>
   <table border=1><col width=300><col width=75><col width=300><col width=50><tr>
   <th>Review</th><th>Reason</th><th>Comment</th><th></th></tr>";
  
  // Display the reports if there are any.
  if (count($reports) == 0) echo "No reports found.<br>";
  else {
   foreach ($reports as $report) {
    $review = Reviews::getByID($report['reviewsID']);
    echo "<tr><td>". $review['review'] ."</td><td>". $report['reason'] ."</td><td>". 
     $report['comment'] ."</td><td><input type='submit' name='validReport' 
     value='VALID' onclick='setID(\"". $report['id'] ."\")'><br><input type='submit' 
     name='invalidReport' value='INVALID' onclick='setID(\"". $report['id'] 
     ."\")'></td></tr>";
   }
  }
  
  // Closing Tags
  echo "</table></form>";
 }
 
 // ************************************************************************
 // DISPLAY VALID REPORTS                                                  *
 // Displays a list of valid reports.                                      *
 // ************************************************************************
 function displayValidReports() {
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  $reports = Reports::getValid();
  
  // Display the reports if there are any.
  if (count($reports) == 0) echo "No reports found.<br>";
  else {
   echo "
    <table border=1><col width=300><col width=75><col width=300><col width=50><tr>
    <th>Review</th><th>Reason</th><th>Comment</th><th></th></tr>";
   foreach ($reports as $report) {
    $review = Reviews::getByID($report['reviewsID']);
    echo "<tr><td>". $review['review'] ."</td><td>". $report['reason'] ."</td><td>". 
     $report['comment'] ."</td></tr>";
   }
   echo "</table>";
  }
 }
 
 // ************************************************************************
 // DISPLAY INVALID REPORTS                                                *
 // Displays a list of invalid reports.                                    *
 // ************************************************************************
 function displayInvalidReports() {
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  $reports = Reports::getInvalid();
  
  // Display the reports if there are any.
  if (count($reports) == 0) echo "No reports found.<br>";
  else {
   echo "
    <table border=1><col width=300><col width=75><col width=300><col width=50><tr>
    <th>Review</th><th>Reason</th><th>Comment</th></tr>";
   foreach ($reports as $report) {
    $review = Reviews::getByID($report['reviewsID']);
    echo "<tr><td>". $review['review'] ."</td><td>". $report['reason'] ."</td><td>". 
     $report['comment'] ."</td></tr>";
   }
   echo "</table>";
  }  
 }
?>
