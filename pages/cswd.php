<?php $ul_index = "active"; $ul_forms = ""; $ul_idp =""; include ('sidebar.php'); ?>
<?php include ('head.php'); ?>

<style type="text/css">

    #home_based_div{
        display: none;
    }
    #displayHead{
        display: none;
    }

    .panel-heading{
        color: #1F77D0;
    }

</style>
<div class="main-panel">
<?php
    include ('navbar.php');
    include ('footer.php');
    require_once("dbcontroller.php");
    $db_handle = new DBController();
?>
    <form method="POST" action="adddemo.php">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        <!-- page start-->
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-lg-12">

                                <div class="row">

                                    <div  id = "personal_info_div" class="col-lg-6">
                                        <div class="panel panel-info">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                <div class="panel-heading"><h6><b>Personal Information</b></h6></div>
                                            </a>
                                            <div class="panel-body panel-collapse collapse in" id="collapseOne">
                                                <div class="form-group col-md-4">
                                                    <label>Last Name<span class="required">*</span></label>
                                                    <input class="form-control" id = 'Lname' name='Lname' placeholder="Enter Last name" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label>First Name<span class="required">*</span></label>
                                                    <input class="form-control" name='Fname' placeholder="Enter First name" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label>Middle Name<span class="required">*</span></label>
                                                    <input class="form-control" name='Mname' placeholder="Enter Middle Name" required>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>Date of birth<span class="required">*</span></label>
                                                    <input type="date" name='Bdate' class="form-control" required>

                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>Age<span class="required">*</span></label>
                                                    <input class="form-control" name='Age' placeholder="Enter age" type="number" min="0" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label>Gender<span class="required">*</span></label>
                                                    <select name='Gender' class="form-control" required>
                                                        <option value="1">Male</option>
                                                        <option value="2">Female</option>
                                                    </select>             
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>Ethnicity<span class="required">*</span></label>
                                                    <select name='Ethnicity' class="form-control" required>
                                                        <option value="1">Maranao</option>
                                                        <option value="2">Cebuano</option>
                                                    </select>             
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>Religion<span class="required">*</span></label>
                                                    <select name='Religion' class="form-control" required>
                                                        <option value="1">Islam</option>
                                                        <option value="2">Roman Catholic</option>
                                                    </select>             
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>Marital Status<span class="required">*</span></label>
                                                    <select name='MaritalStatus' class="form-control" required>
                                                        <option value="1">Single</option>
                                                        <option value="2">Married</option>
                                                        <option value="3">Annulled</option>
                                                        <option value="4">Widowed</option>
                                                    </select>             
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label>Relation to the family head<span class="required">*</span></label>
                                                    <select class="form-control col-md-12" id="relation" name='relation'  required>
                                                        <option value="1">Head</option>
                                                        <option value="2">Wife</option>
                                                        <option value="3">Son</option>
                                                        <option value="4">Daughter</option>
                                                        <option value="other">Others</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-6" id = 'serial_no_div'>
                                                    <label>Serial No<span class="required">*</span></label>
                                                    <input class="form-control" id = 'serial_no' name='serial_no' placeholder="Enter Serial No" required>
                                                    <br>

                                                </div>




                                                <div id="displayHead"  class="form-group">	
                                                    <label>Select Head of the Family:</label>
                                                    <select class="form-control" id= 'selected_head' name='selected_head' >
                                                        <option>  <label>Select Head of the Family<span class="required">*</span></label> </option>
                                                        <?php

                                                        $results = $db_handle->runFetch("SELECT * FROM dafac_no");

                                                        foreach ($results as $result) {

                                                        ?>
                                                        <option value='<?= $result['DAFAC_SN']; ?>' ><?= $result['Name']; ?></option>
                                                        <?php } ?>

                                                    </select>
                                                    <div class="form-group">
                                                        <label>If family head do not exist.</label>
                                                        <input id='target2' class="form-control" style='display:none' type='text' name='relationOther' placeholder="Enter head of the family"/>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label>Educational Attainment<span class="required">*</span></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <select class="form-control" id="education" onchange = "ShowHideDiv()">
                                                                <option value="elementary">Elementary</option>
                                                                <option value="highschool">Highschool</option>
                                                                <option value="college">College</option>    
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select class="form-control" name='education' id="elementary1">
                                                                <option value="1">Grade 1</option>
                                                                <option value="2">Grade 2</option>
                                                                <option value="3">Grade 3</option>
                                                                <option value="4">Grade 4</option>
                                                                <option value="5">Grade 5</option>
                                                                <option value="6">Grade 6</option>
                                                                <option value="7">Elementary Graduate</option>												 
                                                            </select>
                                                            <select class="form-control" name='education' id="highschool1" style="display: none;">
                                                                <option value="8">Grade 7</option>
                                                                <option value="9">Grade 8</option>
                                                                <option value="10">Grade 9</option>
                                                                <option value="11">Grade 10</option>
                                                                <option value="12">Grade 11</option>
                                                                <option value="13">Grade 12</option>
                                                                <option value="14">High School Graduate</option>

                                                            </select>
                                                            <select class="form-control" name='education' id="college1" style="display: none;">
                                                                <option value="15">1st year</option>
                                                                <option value="16">2nd year</option>
                                                                <option value="17">3rd year</option>
                                                                <option value="18">4th year</option>      
                                                                <option value="19">College Graduate</option>

                                                            </select>
                                                        </div>
                                                        <!--/.col-md-6-->
                                                    </div>
                                                    <!--/.row-->
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label>Employment/Occupation</label>
                                                    <input class="form-control" name="occupation" placeholder="Enter occupation" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Monthly Net Income</label>
                                                    <input class="form-control" name="net_income" placeholder="Enter Monthly Income " required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Phone Number<span class="required">*</span></label>
                                                    <input class="form-control" name='PhoneNum' placeholder="Enter phone number" id = "PhoneNum">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Email<span class="required">*</span></label>
                                                    <input class="form-control" id='Email' name='Email' placeholder="your@mail.com">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div id = "contact_div">
    <div class="col-lg-6">
    <div class="panel panel-info" id="accordion">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
    <div class="panel-heading"><h6><b>Contact Information</b></h6></div>
    </a>
    <div class="panel-body panel-collapse collapse in" id="collapseFour">                           
    <div class="form-group col-md-6">
    <label>Phone Number<span class="required">*</span></label>
    <input class="form-control" name='PhoneNum' placeholder="Enter phone number" id = "PhoneNum">
    </div>
    <div class="form-group col-md-6">
    <label>Email<span class="required">*</span></label>
    <input class="form-control" id='Email' name='Email' placeholder="your@mail.com">
    </div>
    <div class="form-group col-md-6">
    <label>Other Contact<span class="required">*</span></label>
    <input class="form-control" id='OtherContact' name='OtherContact' placeholder="Enter other contact">
    </div>
    </div>
    </div>
    </div>
    </div> -->


                                    <div id = "relocation_div">
                                        <div class="col-lg-6">
                                            <div class="panel panel-info" id="accordion">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                                    <div class="panel-heading"><h6><b>Relocation Address</b></h6></div>
                                                </a>
                                                <div class="panel-body panel-collapse collapse in" id="collapseThree">      
                                                    <div class="form-group col-md-6">
                                                        <label>Type of Relocation<span class="required">*</span></label>

                                                        <select class="form-control" name="EvacType" id="EvacType" >
                                                            <option value="1">Evacuation Center</option>
                                                            <option value="2">Home-based</option>
                                                        </select> 
                                                    </div> 
                                                    <div id="EvacName" class="form-group col-md-6">
                                                        <label>Name of the Evacuation Center<span class="required">*</span></label>
                                                        <select name="EvacName" class="form-control">
                                                            <?php

                                                            $results = $db_handle->runFetch("SELECT * FROM evacuation_centers");

                                                            foreach ($results as $result) {

                                                            ?>
                                                            <option value="<?= $result['EvacuationCentersID']; ?>"><?= $result['EvacName']; ?></option>
                                                            <?php } ?>
                                                        </select> 
                                                    </div>
                                                    <div id = "home_based_div">
                                                        <div class="form-group col-md-6">
                                                            <label for="province">Province<span class="required">* for home-based</span></label>
                                                            <select name='province' id='province' class="form-control" required>
                                                                <?php
                                                                $results = $db_handle->runFetch("SELECT * FROM province");

                                                                foreach ($results as $result) {
                                                                ?>
                                                                <option value="<?= $result['ProvinceID']; ?>"><?= $result['ProvinceName']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>District<span class="required">* for home-based</span></label>
                                                            <select name='district' id='district' class="form-control" required>
                                                                <?php
                                                                $results = $db_handle->runFetch("SELECT * FROM district");

                                                                foreach ($results as $result) {
                                                                ?>
                                                                <option value="<?= $result['DistrictID']; ?>"><?= $result['DistrictName']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>City/Municipality<span class="required">* for home-based</span></label>
                                                            <select name="city_mun" id="city_mun" class="form-control" required>
                                                                <?php


                                                                $results = $db_handle->runFetch("SELECT * FROM city_mun, province WHERE city_mun.PROVINCE_ProvinceID=province.ProvinceID");

                                                                foreach ($results as $result) {

                                                                ?>
                                                                <option value="<?= $result['City_Mun_ID']; ?>"><?= $result['City_Mun_Name']; ?></option>
                                                                <?php } ?>
                                                            </select>  
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Barangay<span class="required">* for home-based</span></label>
                                                            <select name="barangay2" id="barangay2" class="form-control" required>
                                                                <?php

                                                                $results = $db_handle->runFetch("SELECT * FROM barangay, city_mun WHERE barangay.City_CityID=city_mun.City_Mun_ID");

                                                                foreach ($results as $result) {
                                                                ?>
                                                                <option value="<?= $result['BarangayID']; ?>"><?= $result['BarangayName']; ?></option>
                                                                <?php } ?>
                                                            </select> 
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Street/Purok<span class="required">*for home-based</span></label>
                                                            <input class="form-control" name="SpecificAddress1" placeholder="144 Purok Sampaguita" type="textbox"/>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id = "home_address_div">
                                        <div class="col-lg-6">
                                            <div class="panel panel-info" id="accordion">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                                    <div class="panel-heading"><h6><b>Home Address</b></h6></div>
                                                </a>
                                                <div class="panel-body panel-collapse collapse in" id="collapseTwo"> 
                                                    <div class="form-group col-md-6">
                                                        <label for="province">Province<span class="required">*</span></label>
                                                        <select name='province' id='province' class="form-control">
                                                            <?php

                                                            $results = $db_handle->runFetch("SELECT * FROM province");

                                                            foreach ($results as $result) {

                                                            ?>
                                                            <option value="<?= $result['ProvinceID']; ?>"><?= $result['ProvinceName']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>District<span class="required">*</span></label>
                                                        <select name='district' id='district' class="form-control">
                                                            <?php

                                                            $results = $db_handle->runFetch("SELECT * FROM district");
                                                            foreach ($results as $result) {
                                                            ?>
                                                            <option value="<?= $result['DistrictID']; ?>"><?= $result['DistrictName']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>City/Municipality<span class="required">*</span></label>
                                                        <select name="city_mun" id="city_mun" class="form-control">
                                                            <?php

                                                            $results = $db_handle->runFetch("SELECT * FROM city_mun, province WHERE city_mun.PROVINCE_ProvinceID=province.ProvinceID");

                                                            foreach ($results as $result) {
                                                            ?>
                                                            <option value="<?= $result['City_Mun_ID']; ?>"><?= $result['City_Mun_Name']; ?></option>
                                                            <?php } ?>
                                                        </select>  
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Barangay<span class="required">*</span></label>
                                                        <select name="barangay1" id="barangay1" class="form-control" required>
                                                            <?php


                                                            $results = $db_handle->runFetch("SELECT * FROM barangay, city_mun WHERE barangay.City_CityID=city_mun.City_Mun_ID");

                                                            foreach ($results as $result) {

                                                            ?>
                                                            <option value="<?= $result['BarangayID']; ?>"><?= $result['BarangayName']; ?></option>
                                                            <?php } ?>
                                                        </select> 
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Street/Purok<span class="required">*</span></label>
                                                        <input class="form-control" name="SpecificAddress" placeholder="144 Purok Sampaguita" type="textbox"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id = "sector_div">
                                        <div class="col-lg-6">
                                            <div class="panel panel-info" id="accordion">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                                                    <div class="panel-heading"><h6><b>Sectors</b></h6></div>
                                                </a>
                                                <div class="panel-body panel-collapse collapse in" id="collapseFive">                           
                                                    <?php

                                                    $results = $db_handle->runFetch("SELECT * FROM sector");

                                                    foreach ($results as $result) {

                                                    ?>
                                                    <div class="checkbox col-md-4">
                                                        <label class="checkbox-inline"  style ="display: visible !important;"><input value="<?= $result['SectorID']; ?>"  data-toggle="checkbox" type="checkbox" name='sector'><?= $result['Name']; ?></label>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                    <input type="submit" class="btn btn-info btn-fill" value="Submit" style="margin-left: 20px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- javascripts -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- nice scroll -->
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.nicescroll.js" type="text/javascript"></script><!--custome script for all page-->
<script src="js/scripts.js"></script>