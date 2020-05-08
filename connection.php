<?php
//<!--Connect to the database-->
$link = mysqli_connect("localhost", "root", "", "notesapp");
if(mysqli_connect_error()){
    die("ERROR: Unable to connect to database:" . mysqli_connect_error());
}
?>