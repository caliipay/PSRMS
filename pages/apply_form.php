
<?php
require('check_credentials.php');
unset($_SESSION['idpID']);
include ('footer.php');
include ('head.php');
?>

<?php $ul_assessment = "active"; include ('sidebar.php'); ?>

<div class="main-panel">

    <?php include ('navbar.php'); ?>

    <?php
    require_once("dbcontroller.php");
    $idpID = $_GET['id'];
    $userID = $_SESSION['UserID'];
    $db_handle = new DBController();
    $forms = $db_handle->runFetch("SELECT * FROM `form` WHERE 1 ORDER BY FormType");
    $idp = $db_handle->runFetch("SELECT * FROM `idp` WHERE IDP_ID = ".$idpID);
    $idp_name;
    $idp_age_group;
    ?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="padding: 20px 50px;">
                        <!-- <div class="header"> -->
                        <h3><b>IDP Form Application</b></h3>
                        <!-- </div> -->
                        <div class="row">
                            <div class="col-md-12">
                                <p><i>This section is for the application of the different assessment Forms available to the selected IDP.</i></p>
                                <h4>Current IDP: 
                                    <?php
                                    if(!empty($idp)) {
                                        foreach ($idp as $result) {
                                    ?>
                                    <b><?php echo($result['Lname'].', '.$result['Fname'].' '.$result['Mname']); ?></b>
                                    <?php
                                            $idp_name = $result['Lname'].', '.$result['Fname'].' '.$result['Mname'];
                                            if($result['Age'] < 18) {
                                                $idp_age_group = 2;
                                            } else {
                                                $idp_age_group = 1;
                                            }

                                        }
                                    }
                                    ?>
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="informed_consent.php" method="post">
                                    <div class="form-group">
                                        <div class="col-md-12"><h5><b>Select Tool(s):</b></h5></div>
                                        <div class="col-md-12">
                                            <?php
                                            if(!empty($forms)) {
                                                foreach ($forms as $form) {
                                            ?>
                                            <div class="col-md-6">
                                                <input id="<?php echo($form["FormID"]); ?>" type="checkbox" name="type-<?php echo($form["FormID"]); ?>" value="<?php echo($form["FormID"]); ?>">&nbsp;
                                                <label for="<?php echo($form["FormID"]); ?>"><?php echo($form["FormType"]) ?></label>
                                            </div>
                                            <?php
                                                }
                                            }
                                            ?>
                                            <input type="hidden" name="idpID" value="<?php echo($idpID); ?>">
                                            <input type="hidden" name="idp_name" value="<?php echo($idp_name); ?>">
                                            <input type="hidden" name="previous_page" value="<?php echo($_SERVER['HTTP_REFERER']); ?>"> 
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-info btn-fill form-control" type="submit"><i class="fa fa-check"></i>&nbsp;Submit</button> 
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    //scan the page for labels, and assign a reference to the label from the actual form element:
    var labels = document.getElementsByTagName('LABEL');
    for (var i = 0; i < labels.length; i++) {
        if (labels[i].htmlFor != '') {
            var elem = document.getElementById(labels[i].htmlFor);
            if (elem)
                elem.label = labels[i];         
        }
    }
    //keeping track of the clicked element order
    checkedOrder = []
    appendOrder = " ";
    inputList = document.getElementsByTagName('input')
    for(var i=0;i<inputList.length;i++) {
        if(inputList[i].type === 'checkbox') {
            inputList[i].onclick = function() {
                if (this.checked) {
                    checkedOrder.push(this.value)
                    appendOrder = " - " + (checkedOrder.indexOf(this.value) + 1);
                    this.label.innerHTML += (appendOrder);
                } else {
                    checkedOrder.splice(checkedOrder.indexOf(this.value),1)
                    labelString = this.label.innerHTML;
                    this.label.innerHTML = this.label.innerHTML.substr(0, labelString.length - appendOrder.length);
                }
                console.log(checkedOrder)
            }    
        }
    }
</script>