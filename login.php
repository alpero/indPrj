<?php
/*
 File Name   : login.php
 Date        : 3/15/2015
 Author      : Adam Lee Pero
 Description : 
  Handles login and logout requests.
*/
 // Required Files
 require_once('Database.php');
 require_once('header.php');
 require_once('Admin.php');
 
 // Display Logo
 displayLogoOnly();
 
 // ************************************************************************
 // The logout button included in the header was clicked.
 if (isset($_GET['action']) AND $_GET['action'] == 'logout') {
  logout();
  header('Location: login.php');
 }
  
 // The login button was click from the Login Form.
 elseif (isset($_POST['login'])) {
  // valid login information
  if (login($_POST['email'], $_POST['password'])) header('Location: home.php'); 
  
  // invalid login information
  else header('Location: login.php?action=invalid');
 }
  
 // Login information was invalid.
 elseif (isset($_GET['action']) AND $_GET['action'] == 'invalid') {
  loginForm();
  echo "<br>Invalid email and/or password.";
 }
  
 // First Visit
 else loginForm();
 // ************************************************************************
 
 // ************************************************************************
 // LOGIN FORM - Displays a login form.                                    *
 // ************************************************************************
 function loginForm() {
  echo '
   <center>
   <form method="POST" action="login.php">
    <table>
     <tr>
      <td>EMAIL:</td>
      <td><input name="email" value=""></td>
     </tr><tr>
      <td>PASSWORD:</td>
      <td><input name="password" value=""></td>
     </tr><tr>
      <td><input type="submit" name="login" value="LOGIN"></td>
     </tr><tr>
      <td><a href="register.php">Create Account</a></td>
     </tr>
    </table>
   </form>   
   </center>';
 }
 
 // ************************************************************************
 // LOGIN -                                                                *
 // Returns true if the email and password match a record within           *
 // the Persons Table.                                                     *
 // PREREQ: Assumes the database does not allow duplicate emails.          *
 // ************************************************************************
 function login($email, $password) {
  $str = "
   SELECT * 
   FROM indPrj_persons
   WHERE email='$email' AND password ='$password'";
  
  $rows = Database::query($str);
  
  if (mysql_num_rows($rows) == 1) {
   // Login information is valid.
   $rec = mysql_fetch_assoc($rows);

   // Set the session variables.
   $_SESSION['id']        = $rec[id];
   $_SESSION['firstName'] = $rec[firstName];
   $_SESSION['lastName']  = $rec[lastName];
   $_SESSION['email']     = $rec[email];
   
   // Set administrative privileges.
   if (Admin::isAdmin($rec[id])) $_SESSION['admin'] = true;
   else                          $_SESSION['admin'] = false;    
   
   return true;
  } else {
   // Login information is invalid.
   return false;
  }
 }
 
 // ************************************************************************
 // LOGOUT -  Removes all session data, and destroys the current session.  *
 // ************************************************************************
 function logout() {
  $_SESSION = array();
  session_destroy();
 }
 
  /**********************************************************************************/
 /* FOR TESTING PURPOSES                                                           */
 /**********************************************************************************/
 echo "<br><br><b>For Testing Purposes:</b><br>";
 echo "<b>Login Accounts:</b><table><tr><th>email</th><th>password</th></tr><tr>" .
  "<td>admin</td><td>admin</td></tr><tr><td>1</td><td>1</td></tr><tr><td>2</td>"  .
  "<td>2</td></tr><tr><td>3</td><td>3</td></tr></table>";
 /**********************************************************************************/
 /* Not intended for the final release!                                            */
 /**********************************************************************************/
?>
