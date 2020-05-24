<?php
//Start the session
if(!isset($_SESSION)){ 
        session_start(); 
    }
//Connect to database
include("connection.php");

//Define error messages
$missingCurrentPassword = '<p>Please enter your current password!</p>';
$incorrectCurrentPassword = '<p>The password entered is incorrect!</p>';
$missingPassword = '<p>Please enter a new password!</p>';
$invalidPassword = '<p>Your password should be at least 6 characters long and include one capital letter and one number!</p>';
$differentPassword = '<p>Passwords don\'t match!</p>';
$missingPassword2 = '<p>Please confirm your password!</p>';


//check for errors
if(empty($_POST["currentpassword"])){
    $errors .= $missingCurrentPassword;
}else{
    $currentPassword = $_POST["currentpassword"];
    $currentPassword = filter_var($currentPassword, FILTER_SANITIZE_STRING);
    $currentPassword = mysqli_real_escape_string($link, $currentPassword);
    $currentPassword = hash('sha256', $currentPassword);
    //check if given password is correct
    $user_id = $_SESSION["user_id"];
    $sql = "SELECT password FROM users WHERE user_id='$user_id'";
    $result = mysqli_query($link, $sql);
    $count = mysqli_num_rows($result);
    if($count !== 1){
        echo '<div class="alert alert-danger">There was a problem running the query</div>';
    }else{
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if($currentPassword !== $row['password']){
            $errors .= $incorrectCurrentPassword;
        }
    }
    
    if(empty($_POST["password"])){
        $errors .= $missingPassword;
    }elseif(!(strlen($_POST["password"])>5
            and preg_match('/[A-Z]/',$_POST["password"])
            and preg_match('/[0-9]/',$_POST["password"]))){
        $errors .= $invalidPassword;
    }else{
        $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
        if(empty($_POST["password2"])){
            $errors .= $missingPassword2;
        }else{
            $password2 = filter_var($_POST["password2"], FILTER_SANITIZE_STRING);
            if($password !== $password2){
                $errors .= $differentPassword;
            }
        }
    }
}

//if there is an error print error message
if($errors){
    $resultMessage = '<div class="alert alert-danger">'. $errors .'</div>';
    echo $resultMessage;
}else{
    $password = mysqli_real_escape_string($link, $password);
    $password = hash('sha256', $password);
    //else run query and update password
    $sql = "UPDATE users SET password='$password' WHERE user_id='$user_id'";
    $result = mysqli_query($link, $sql);
    if(!$result){
        echo  '<div class="alert alert-danger">The password could not be reset. Please try again later.</div>';
    }else{
        echo  '<div class="alert alert-success">Your password has been updated successfully.</div>';
    }
}




?>
