<?php
//The user is re-directed to the file after clicking the activation link
//Signup link contains two GET parameters: email and activation key
session_start();
include('connection.php');
//If email or activation key is missing show an error
if(!isset($_GET['email']) ||
  !isset($_GET['key'])){
    echo '<div>There was an error. Please click on the activation link your received by email.</div>'; exit;
}
//else
    //Store them in two variables
$email = $_GET['email'];
$key = $_GET['key'];
    //Prepare variables for the query
$email = mysqli_real_escape_string($link, $email);
$key = mysqli_real_escape_string($link, $key);
    //Run query: set activation field to "activated" for the provided email
$sql = "UPDATE users SET activation='activated' WHERE (email='$email' AND activation='$key') LIMIT 1";
$result = mysqli_query($link, $sql);
    //If query is successful, show success message and invite user to login
if(mysqli_affected_rows($link) == 1){
    echo '<div>Your account has been activated.</div>';
    echo '<a href="index.html">Log in</a>';
}else{
    //else
        //Show error message
    echo '<div class="alert alert-danger">Your account could not be activated. Please try again later.</div>';
}
?>