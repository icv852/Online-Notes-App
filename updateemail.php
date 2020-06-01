<?php
//Start the session
if(!isset($_SESSION)){ 
        session_start(); 
    }
//Connect to database
include("connection.php");

//get user_id and new email sent through Ajax
$user_id = $_SESSION['user_id'];
$newemail = $_POST['email'];

//check if new email exists
$sql = "SELECT * FROM users WHERE email='$newemail'";
$result = mysqli_query($link, $sql);
$count = mysqli_num_rows($result);
if($count>0){
    echo "<div class='alert alert-danger'>There is already a user registered with that email! Please choose another one!</div>";
    exit;
}

//get the current email
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);

$count = mysqli_num_rows($result);

if($count == 1){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $email = $row['email'];
}else{
    echo "There was an error retrieving the email from the database";
    exit;
}

//create a unique activation code
$activationKey = bin2hex(openssl_random_pseudo_bytes(16));

//insert new activation code in the users table
$sql = "UPDATE users SET activation2='$activationKey' WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div class='alert alert-danger'>There was an error inserting the user details in the database!</div>";
}else{
    //send email with link to activatenewemail.php with current email, new email and activation code
    $message = "Please click on this link to prove that you own this email:\n\n";
    $message .= "http://vicwebomega.000webhostapp.com/activatenewemail.php?email=" . urlencode($email) . "&newemail=" . urlencode($newemail) . "&key=$activationKey";
    if(mail($newemail, 'Email Update for your Online Notes App', $message, 'From:' . 'icv852@gmail.com')){
        echo "<div class='alert alert-success'>An email has been sent to $newemail. Please click on the link to prove that you own that email address.</div>";
    }
}




?>
