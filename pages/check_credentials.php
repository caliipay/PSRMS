<?php
session_start();
if(!isset($_SESSION["UserID"])) {
    header( "Location: login_page.php" );
}
?>