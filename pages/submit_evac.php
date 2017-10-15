<?php
include("check_credentials.php");
require_once("dbcontrollerPDO.php");
$db_handle = new DBController();
$ename = $_POST['Ename'];
$barangay = $_POST['selected_barangay'];
$evac_type = $_POST['evac_type'];
$manager = $_POST['manager'];
$contact = $_POST['contact'];
$address = $_POST['address'];
$db_handle->prepareStatement("INSERT INTO `evacuation_centers`(`EvacName`, `EvacAddress`, `EvacType`, `EvacManager`, `EvacManagerContact`, `SpecificAddress`) VALUES (:evacName, :evacAddress, :evacType, :evacManager, :evacManagerContact, :specificAddress)");
$db_handle->bindVar(':evacName', $ename, PDO::PARAM_STR,0);
$db_handle->bindVar(':evacAddress', $barangay, PDO::PARAM_INT,0);
$db_handle->bindVar(':evacType', $evac_type, PDO::PARAM_INT,0);
$db_handle->bindVar(':evacManager', $manager, PDO::PARAM_STR,0);
$db_handle->bindVar(':evacManagerContact', $contact, PDO::PARAM_STR,0);
$db_handle->bindVar(':specificAddress', $address, PDO::PARAM_STR,0);
$db_handle->runUpdate();

if($db_handle->getUpdateStatus()) 
{
    echo "<script type='text/javascript'>alert('Add Succesful!');
    location='".$_SESSION['loc']."';
    </script>";
}
?>