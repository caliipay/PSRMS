<?php
session_start();
require_once("dbcontrollerPDO.php");
include("pagination_function.php");
$db_handle = new DBController();
$query = "";
$output = array();
$query .= "SELECT IDP_ID, DAFAC_DAFAC_SN, CONCAT(Lname, ', ', Fname, ' ', Mname) AS IDPName, (case when (Gender = 1) THEN 'Male' ELSE 'Female' END) as Gender, Age FROM `idp` ";
if(isset($_POST["search"]["value"])) {
    $query .= " WHERE Lname LIKE :keyword OR Fname LIKE :keyword OR Mname LIKE :keyword  OR Fname LIKE :keyword OR IDP_ID LIKE :keyword OR DAFAC_DAFAC_SN LIKE :keyword ";
}
if(isset($_POST["order"])) {
    $query .= 'ORDER BY '.($_POST['order']['0']['column'] + 1).' '.$_POST['order']['0']['dir'].' ';
} else {
    $query .= 'ORDER BY 1 asc ';
}
if($_POST["length"] != -1) {
    $query .= 'LIMIT '.$_POST['start'].', '.$_POST['length'];
}
$statement = $db_handle->prepareStatement($query);
if(isset($_POST["search"]["value"])) {
    $db_handle->bindVar(':keyword', '%'.$_POST["search"]["value"].'%', PDO::PARAM_STR,0);
}
$result = $db_handle->runFetch();
$data = array();
$rowCount = $db_handle->getFetchCount();
if($db_handle->getFetchCount() != 0) {
    foreach($result as $row) {
        $sub_array = array();
        $sub_array[] = $row["DAFAC_DAFAC_SN"];
        $sub_array[] = $row["IDP_ID"];
        $sub_array[] = $row["IDPName"];
        $sub_array[] = $row["Gender"];
        $sub_array[] = $row["Age"];
        $sub_array[] = '<button class="btn btn-info btn-sm btn-fill" id="'.$row['IDP_ID'].'" onClick ="load_modal(this.id)"><i class="pe-7s-info"></i> View</button>';//<a class="btn btn-warning btn-sm btn-fill" href="deletecswd.php?id="'.$row['IDP_ID'].'"><i class="pe-7s-delete-user"></i> Update </a>
        $data[] = $sub_array;
    }
} else {
    $data = [];
}
$output = array(
    "draw" => intval($_POST["draw"]),
    "recordsTotal" => $rowCount,
    "recordsFiltered" => get_total_all_records(),
    "data" => $data
);
echo(json_encode($output));
?>