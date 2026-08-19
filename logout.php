<?php
require_once "database.php";
session_unset();
session_destroy();
header('Location:login.php');
if (isset($_SESSION['user_id'])) {
    header("Location: mydivar.php");
    exit();
}
?>