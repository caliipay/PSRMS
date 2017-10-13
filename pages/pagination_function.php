<?php
function get_total_all_records() {
    include_once("dbcontrollerPDO.php");
    $db_handle = new DBController();
    $db_handle->prepareStatement("SELECT COUNT(*) as total FROM `idp`");
    $result = $db_handle->runFetch();
    return $result[0]['total'];
}
?> 