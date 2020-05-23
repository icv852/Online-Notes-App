<!--This file receives: user_id, generated key to reset passord, password1 and password2-->
<!--This file then resets password for user_id if all checks are correct-->

<head>
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

<body>
    <?php
session_start();
include('connection.php');
//If user_id or key is missing show an error
if(!isset($_POST['user_id']) ||
  !isset($_POST['key'])){
    echo '<div>There was an error. Please click on the link your received by email.</div>'; exit;
}
//else
    //Store them in two variables
$user_id = $_POST['user_id'];
$key = $_POST['key'];
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

//Define error messages
$missingPassword = '<p><strong>Please enter a password!</strong></p>';
$invalidPassword = '<p><strong>Your password should be at least 6 characters long and include one capital letter and one number!</strong></p>';
$differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';
$missingPassword2 = '<p><strong>Please confirm your password!</strong></p>';

//Get passwords
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
//If there are any errors print error
if($errors){
    $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
    echo $resultMessage;
    exit;
}

//Prepare variables for the query
$password = mysqli_real_escape_string($link, $password);
$password = hash('sha256', $password);
$user_id = mysqli_real_escape_string($link, $user_id);

//Run Query: Update users password in the users table
$sql = "UPDATE users SET password='$password' WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger">There was an error stroing the new password in the database!</div>'; 
    echo '<div class"alert alert-danger">' . mysqli_error($link) . '</div>'; 
    exit;
}

//Set the key status to "used" in the forgotpassword table to prevent the key from being used twice
$sql = "UPDATE forgotpassword SET status='used' WHERE validkey='$key' AND user_id='$user_id'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger">Error running the query!</div>'; 
    echo '<div class"alert alert-danger">' . mysqli_error($link) . '</div>'; 
}else{
    echo '<div class="alert alert-success">Your password has been updated successfully!<a href="index.php">Login</a></div>'; 
}
?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</body>
