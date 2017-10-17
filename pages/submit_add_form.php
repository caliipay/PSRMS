<?php
require_once("dbcontroller.php");
$formType = $_POST['formType'];
$itemStart = $_POST['itemStart'];
$formInstructions = $_POST['formInstructions'];
$db_handle = new DBController();
if (empty($formType)) {
     echo "<script type='text/javascript'>alert('empty field!');
     location='dashboard.php#?';</script>";
} else {
    $form = $db_handle->runUpdate("INSERT INTO `form` (`FormID`, `FormType`, `Instructions`, `AgeGroup`, `ItemStart`) VALUES (NULL, '".$formType."', \"".nl2br($formInstructions)."\", NULL, ".$itemStart.")");
    
    if($db_handle->getUpdateStatus()) {
        echo "<script type='text/javascript'>alert('Add Succesful!');
        location='forms.php';
        </script>";
    }
}
?>