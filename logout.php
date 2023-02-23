<?php
session_start();

//unset individual session variables
    unset($_SESSION['firstname']);
    unset($_SESSION['othernames']);
    unset($_SESSION['emailaddress']);
    unset($_SESSION['contact']);
    unset($_SESSION['password']);
            //OR//-
    //remove all sessions
    session_unset();

    //redirect the user to the login page

    header('Location: login.php');

?>