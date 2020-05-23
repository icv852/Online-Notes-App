<head>
    <title>Reset Password:</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

    <!--Google Font "Argo"-->
    <link href="https://fonts.googleapis.com/css2?family=Arvo&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="styling.css">

</head>

<!--This file receives the user_id and key generated to create the new password-->
<!--This file displays a form to input new password-->
<body>
<h1>Reset Password:</h1>
<div id="resultmessage"></div>
<?php
session_start();
include('connection.php');
//If user_id or key is missing show an error
if(!isset($_GET['user_id']) ||
  !isset($_GET['key'])){
    echo '<div>There was an error. Please click on the link your received by email.</div>'; exit;
}
//else
    //Store them in two variables
$user_id = $_GET['user_id'];
$key = $_GET['key'];
$time = time() - 86400;
    //Prepare variables for the query
$user_id = mysqli_real_escape_string($link, $user_id);
$key = mysqli_real_escape_string($link, $key);
    //Run query: Check combination of user_id & key exists and less than 24h old
$sql = "SELECT user_id FROM forgotpassword WHERE validkey='$key' AND user_id='$user_id' AND time > '$time' AND status='pending'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger">Error running the query!</div>'; 
    echo '<div class"alert alert-danger">' . mysqli_error($link) . '</div>'; 
    exit;
}
//if combination does not exist
    //show an error message
$count = mysqli_num_rows($result);
if($count !== 1){
    echo '<div class="alert alert-danger">Please try again.</div>';
    exit;
}
//print reset password form with hidden user_id and key fields
echo "
<form method='post' id='passwordreset'>
<input type='hidden' name='key' value='$key'>
<input type='hidden' name='user_id' value='$user_id'>
<div class='form-group'>
    <label for='password'>Enter your new Password:</label>
    <input type='password' name='password' id='password' placeholder='Enter Password' class='form-control'>
</div>
<div class='form-group'>
    <label for='password'>Re-enter Password:</label>
    <input type='password' name='password2' id='password2' placeholder='Re-enter Password' class='form-control'>
</div>
<input type='submit' name='resetpassword' class='btn btn-success btn-lg' value='Reset Password'>
</form>
";
?>

<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<!--Script for Ajax Call to storeresetpassword.php which processes form data-->
<script>
    //Once the form is submitted
    $("#passwordreset").submit(function(event) {
        //prevent default php processing
        event.preventDefault();
        //collect user inputs
        var datatopost = $(this).serializeArray();
        //    console.log(datatopost);
        //send them to signup.php using AJAX
        $.ajax({
            url: "storeresetpassword.php",
            type: "POST",
            data: datatopost,
            success: function(data) {
                $('#resultmessage').html(data);
            },
            error: function() {
                $("#signupmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
            }
        });
    });
</script>
    
</body>
