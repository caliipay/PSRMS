<?php
session_start();
require_once("dbcontrollerPDO.php");
$db_handle = new DBController();
if(isset($_SESSION["userID"])) {
    session_unset(); 
    session_destroy();
    echo "<script type='text/javascript'>alert('Two logins detected! Please sign in again.'); 
    location='login_page.php';
    </script>";
} else {
    $db_handle->prepareStatement("SELECT * FROM `account` WHERE `Username` = :uName");
    $db_handle->bindVar(':uName', $_POST['email'], PDO::PARAM_STR,0);
    $result = $db_handle->runFetch();
    echo(json_encode($result));

    if (password_verify($_POST['pwd'], $result[0]['Password'])) {
        $_SESSION["UserID"] = $result[0]['USER_UserID'];
        $_SESSION["UserGroup"] = $result[0]['USING_ORGANIZATION_UsingOrganizationID'];
        $_SESSION["account_type"] = $result[0]['Type'];
        header("Location: dashboard.php");
    } else {
        echo "<script type='text/javascript'>alert('Invalid credentials.'); 
        location='login_page.php';
        </script>";
    }

    /*$_SESSION["userID"] = $_POST['userID'];
    if($_POST['userID'] == 1) {
        $_SESSION["account_type"] = 1;
    } else {
        $_SESSION["account_type"] = 0;
    }
    $_SESSION['disaster_id'] = 1;
    header( "Location: dashboard.php" );
    //echo(json_encode($_SESSION));*/
}
?>