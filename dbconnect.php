<?php
//Connect to the Database
$dbconnect = mysqli_connect('localhost', 'root','', 'voting_system');

//Check whether database connection is successful
if(!$dbconnect){
    echo "Database failed to connect" . mysqli_connect_error();
}
?>