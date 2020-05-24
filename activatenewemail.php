<?php
//The user is re-directed to the file after clicking the link received by email and aiming at proving they own the new email address
//link contains 3 GET parameters: email, new email and activation key
if(!isset($_SESSION)){ 
        session_start(); 
    }
include('connection.php');
//If email, new email or activation key is missing show an error
if(!isset($_GET['email']) ||
   !isset($_GET['newemail']) ||
  !isset($_GET['key'])){
    echo '<div>There was an error. Please click on the link you received by email.</div>'; exit;
}
//else
    //Store them in three variables
$email = $_GET['email'];
$newemail = $_GET['newemail'];
$key = $_GET['key'];
    //Prepare variables for the query
$email = mysqli_real_escape_string($link, $email);
$newemail = mysqli_real_escape_string($link, $newemail);
$key = mysqli_real_escape_string($link, $key);
    //Run query: update email
$sql = "UPDATE users SET email='$newemail', activation2='0' WHERE (email='$email' AND activation2='$key') LIMIT 1";
$result = mysqli_query($link, $sql);
    //If query is successful, show success message
if(mysqli_affected_rows($link) == 1){
    session_destroy();
    setcookie("rememberme", "", time()-3600);
    echo '<div>Your email has been updated.</div>';
    echo '<a href="index.php">Log in</a>';
}else{
    //else
        //Show error message
    echo '<div class="alert alert-danger">Your email could not be updated. Please try again later.</div>';
}
?>