<?php
/*
 File Name   : register.php
 Date        : 3/15/2015
 Author      : Adam Lee Pero
 Description : 
  Allows the user to add a record to the persons table.
*/
 // Required Files
 require_once('header.php');
 require_once('Persons.php');
 require_once('Admin.php');
 
 // ************************************************************************
 // Display Site Logo
 displayLogoOnly();

 // If the addPerson button was pressed...
 if (isset($_POST['addPerson'])) {
  // Validate Input
  if (!Persons::validateName    ($_POST['firstName']) ||
      !Persons::validateName    ($_POST['lastName'] ) || 
      !Persons::validateEMAIL   ($_POST['email']    ) ||
      !Persons::validatePassword($_POST['password'] )) {
   header('Location: register.php?action=invalid');
  } else {
   // add the person to the database.
   Persons::add($_POST['firstName'], $_POST['lastName'], $_POST['email'], 
    $_POST['password']);
  
   // If the admin check box was selected...
   if (isset($_POST['admin'])) { 
    //  Grant Administrative Privileges
    $rec = Persons::getByEMAIL($_POST['email']);
    Admin::grant($rec['id']);
   }
  
   // redirect to the landing page.
   header('Location: home.php');
  }
 } else {
  // else, display the entry form.
  addPersonsForm();
  
  // Display error message if user input was invalid.
  if (isset($_GET['action']) AND $_GET['action'] == 'invalid')
   echo "<br>Invalid Input!<br>";
   
  // Display Input Validation Rules 
  echo "<br>&rarr; Names must contain only characters from the English alphabet.<br>" . 
   "&rarr; EMAIL must be formatted correctly.<br>&rarr; Password must be between 4 "  .
   "and 8 characters, contain both letters<br> and numbers, and void of special "     .
   "characters or spaces.";
    
  // Display Back Button
  echo "<p>&larr; <a href='home.php'>BACK</a></p>";
 }
 // ************************************************************************
 
 // ************************************************************************
 // ADD PERSONS FORM                                                       *
 // Displays a form for adding a persons record to the database.           *
 // ************************************************************************
 function addPersonsForm() {
  // Name of the file that is calling this function
  $fileName = basename($_SERVER['SCRIPT_FILENAME']);
  
  echo "
   <form method='POST' action='$fileName'>
    <!-- hidden field used for storing user id -->
    <input type='hidden' name='id' id='id' value=''>
    <table>
     <tr>
      <td>First Name: </td>
      <td><input type='text' name='firstName' id='firstName' value='' size='30'></td>
     </tr><tr>
      <td>Last Name: </td>
      <td><input type='text' name='lastName' id='lastName' value='' size='30'></td>
     </tr><tr>
      <td>Email: </td>
      <td><input type='text' name='email' id='email' value='' size='20'></td>
     </tr><tr>
      <td>Password: </td>
      <td><input type='text' name='password' id='password' value='' size='20'></td>
     </tr><tr>
      <td>Admin: </td>
      <td><input type='checkbox' name='admin'></td>
     </tr><tr>
      <td><input type='submit' name='addPerson' id='addPerson' value='Add Entry'></td>
      <td><input type='reset' value='Reset Form'></td>
     </tr>
    </table>
   </form>";
 }
?>
