<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("location:index.php");
}
include('connection.php');

$user_id = $_SESSION['user_id'];

//get username and email
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);

$count = mysqli_num_rows($result);

if($count == 1){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $username = $row['username'];
    $email = $row['email'];
}else{
    echo "There was an error retrieving the username and email from the database";
}
?>

<!doctype html>
<html lang="en">

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

    <title>Profile</title>

    <style>
        #container {
            margin-top: 120px;
        }

        .buttons {
            margin-bottom: 20px;
        }
        
        tr{
            cursor: pointer;
        }

    </style>
</head>

<body>
    <!--    Navigation Bar-->
    <nav role="navigation" class="navbar navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand">Online Notes</a>
                <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse" id="navbarCollapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Profile</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="mainpageloggedin.php">My Notes</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Logged in as <b><?php echo $username; ?></b></a></li>
                    <li><a href="index.php?logout=1">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!--    Container-->
    <div class="container" id="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <h2 style="color:white">General Account Settings:</h2>
                <div class="table-responsive">
                    <table class="table table-hover table-condensed table-bordered">
                        <tr data-target="#updateusername" data-toggle="modal">
                            <td>Username</td>
                            <td><?php echo $username; ?></td>
                        </tr>
                        <tr data-target="#updateemail" data-toggle="modal">
                            <td>Email</td>
                            <td><?php echo $email ?></td>
                        </tr>
                        <tr data-target="#updatepassword" data-toggle="modal">
                            <td>Password</td>
                            <td>hidden</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--Update username-->
    <form method="post" id="updateusernameform">
        <div class="modal" id="updateusername" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 id="myModalLabel">Edit Username:</h4>
                    </div>
                    <div class="modal-body">
                        <!--Update username message from PHP file-->
                        <div id="updateusernamemessage"></div>
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input class="form-control" type="text" name="username" id="username" maxlength="30" value="<?php echo $username; ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn green" name="updateusername" type="submit" value="Submit">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--Update Email-->
    <form method="post" id="updateemailform">
        <div class="modal" id="updateemail" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 id="myModalLabel">Enter new email:</h4>
                    </div>
                    <div class="modal-body">
                        <!--Update email message from PHP file-->
                        <div id="updateemailmessage"></div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input class="form-control" type="text" name="email" id="email" maxlength="50" value="<?php echo $email ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn green" name="updateemail" type="submit" value="Submit">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    <!--Update Password-->
    <form method="post" id="updatepasswordform">
        <div class="modal" id="updatepassword" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 id="myModalLabel">Enter Current and New password:</h4>
                    </div>
                    <div class="modal-body">    
                        <!--Update password message from PHP file-->
                        <div id="updatepasswordmessage"></div>
                        <div class="form-group">
                            <label for="currentpassword" class="sr-only">Current Password:</label>
                            <input class="form-control" type="password" name="currentpassword" id="currentpassword" maxlength="30" placeholder="Your Current Password">
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Choose a Password:</label>
                            <input class="form-control" type="password" name="password" id="password" maxlength="30" placeholder="Choose a Password">
                        </div>
                        <div class="form-group">
                            <label for="password2" class="sr-only">Confirm Password:</label>
                            <input class="form-control" type="password" name="password2" id="password2" maxlength="30" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn green" name="updateemail" type="submit" value="Submit">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    
    
    <!--    Footer-->
    <div class="footer">
        <div class="container">
            <p>Victor Cheng Copyright &copy; 2020-<?php $today = date("Y"); echo $today?>.</p>
        </div>
    </div>




    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <script src="profile.js"></script>
</body>

</html>
