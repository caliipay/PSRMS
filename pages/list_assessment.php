<?php
session_start();
require_once("dbcontrollerPDO.php");
include("pagination_function.php");
$db_handle = new DBController();
$query = "";
$output = array();
$query .= "SELECT DAFAC_DAFAC_SN, IDP_ID, CONCAT(Lname, ', ', Fname, ' ', Mname) AS IDPName, (case when (Gender = 1) THEN 'Male' ELSE 'Female' END) as Gender, Age, COALESCE(MIN(j.INTAKE_ANSWERS_ID), 0) AS intake_answersID, (case when (Age > 18) THEN 2 ELSE 1 END) as age_group FROM `idp` i  LEFT JOIN intake_answers j on i.IDP_ID = j.IDP_IDP_ID ";
if(isset($_POST["search"]["value"])) {
    $query .= " WHERE Lname LIKE :keyword OR Fname LIKE :keyword OR Mname LIKE :keyword  OR Fname LIKE :keyword OR IDP_ID LIKE :keyword OR DAFAC_DAFAC_SN LIKE :keyword ";
}
if(isset($_POST["order"])) {
    $query .= 'GROUP BY i.IDP_ID, IDPName ORDER BY '.($_POST['order']['0']['column'] + 1).' '.$_POST['order']['0']['dir'].' ';
} else {
    $query .= 'GROUP BY i.IDP_ID, IDPName ORDER BY 1 asc ';
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
        if($row['intake_answersID'] == 0) {
            $sub_array[] = '<button class="btn btn-info btn-sm btn-fill" id="'.$row["IDP_ID"].'" onClick ="load_modal(this.id)"><i class="pe-7s-info"></i>Assessment History</button><a href="apply_intake.php?id='.$row["IDP_ID"].'&ag='.$row["age_group"].'" class="btn btn-success btn-sm btn-fill"><i class="icon_check_alt"></i>Apply Intake</a>';
        } else {
            $sub_array[] = '<button class="btn btn-info btn-sm btn-fill" id="'.$row["IDP_ID"].'" onClick ="load_modal(this.id)"><i class="pe-7s-info"></i>Assessment History</button><a href="apply_form.php?id='.$row["IDP_ID"].'" class="btn btn-primary btn-sm btn-fill">Apply Assessment Form</a><a href="apply_intake.php?id='.$row["IDP_ID"].'&ag='.$row["age_group"].'" class="btn btn-success btn-sm btn-fill"><i class="icon_check_alt"></i>Apply Intake</a>';
        }
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