<?php
session_start();
include("css_include.php");
include("core_include.php");
require_once("dbcontroller.php");
$db_handle = new DBController();
$idpID = $_POST['idpID'];
$idpName = $_POST['idp_name'];
$ids = array();
//extract formIDs from $_POST and save it to $ids array
foreach($_POST as $key => $post) {
    if(substr($key,0,5) === "type-") {
        $ids[] = substr($key, 5);
    }
}
?>
<form id="formInput" action="take_form.php" method="post">
    <!-- container for idpID -->
    <input type="hidden" name="idpID" value="<?php echo($idpID); ?>">
    <!-- container for idpName -->
    <input type="hidden" name="idpName" value="<?php echo($idpName); ?>">
    <!-- container for formID array -->
    <input type="hidden" name="toolID" value='<?php echo(json_encode($ids)); ?>'>
    <!-- container for previous page -->
    <input type="hidden" name="previous" value="<?php echo($_SERVER['HTTP_REFERER']); ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-left">
                <h1 class="mt-5">Informed consent</h1>
                <br>
                <p class="lead">Our aim is to learn from your knowledge and experience so that we will be better able to provide support. We cannot promise to give you support in exchange for this interview. We are here only to ask questions and learn from your experiences. You are free to take part or not. We will use this information to decide how best to support people in similar situations. If you do choose to be interviewed, I can assure you that your information will remain anonymous so no-one will know what you have said. We cannot give you anything for taking part, but we greatly value your time and responses.</p>
                <ul class="list-unstyled">
                    <li><h4>Do you wish to continue?</h4></li>
                    <li><h4><input type="checkbox" id="consent">&nbsp;<label for="consent">&nbsp;<button class="btn btn-success btn-fill btn-sm" type="submit" id="submitButton" disabled>Continue</button></h4></li>
                </ul>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
$('#consent').click(function(){
    if($(this).is(':checked')){
        $('#submitButton').removeAttr('disabled');
    } else {
        $('#submitButton').attr("disabled","disabled");
    }
});
</script>
