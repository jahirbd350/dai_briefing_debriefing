<?php
date_default_timezone_set('UTC');
session_start();
$user_id = $_SESSION['user_id'];
$bd_no = $_GET['bd_no'];
$visitId = $_GET['visit_info_id'];

if (!isset($_SESSION['user_id'])) {
    header('location: ../index.php');
}

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'logout') {
        require_once('../Login.php');
        $logout = new Login();
        $message = $logout->adminLogout();
        $_SESSION['message'] = $message;
    }
}

$message = '';
if (isset($_POST['btn_update'])) {
    /*echo '<pre>';
    print_r($_FILES);
    echo '</pre>';*/
    require_once '../Briefing.php';
    $briefing = new Briefing();
    $message = $briefing->updateF20387VisitData($_POST);
    $message .= $briefing->updateUserTable();
    $_SESSION['message']=$message;
    header('location: homepage.php');
}

require_once '../Briefing.php';
$briefing = new Briefing();
$personelInfo = $briefing->view20387PersonalDataForUpdatePage($bd_no,$visitId);
$personelInfo = mysqli_fetch_assoc($personelInfo);

$briefing = new Briefing();
$visitInfo = $briefing->view20387VisitDataForUpdatePage($bd_no,$visitId);
$visitInfo = mysqli_fetch_assoc($visitInfo);

$transitSql= "SELECT ser_no,country,duration,purpose FROM briefing_20387_transit_info WHERE bd_no='$bd_no'&&visit_info_id='$visitId' ORDER BY id";
$transitInfo = $briefing->getDynamicTableData($transitSql);

$pastVisitSql = "SELECT ser_no,country,purpose,duration,remarks FROM briefing_20387_past_visit_info WHERE bd_no='$bd_no'&&visit_info_id='$visitId' ORDER BY id";
$pastVisitInfo = $briefing->getDynamicTableData($pastVisitSql);

$familyMemberSql = "SELECT ser_no,family_name,relation,departure_date FROM briefing_20387_family_members_info WHERE bd_no='$bd_no'&&visit_info_id='$visitId' ORDER BY id";
$familyMemberInfo = $briefing->getDynamicTableData($familyMemberSql);

$sponsorSql = "SELECT ser_no,sponsor_name,occupation,relation,address FROM briefing_20387_sponsor_relative_info WHERE bd_no='$bd_no'&&visit_info_id='$visitId' ORDER BY id";
$sponsorInfo = $briefing->getDynamicTableData($sponsorSql);

$serviceItemSql = "SELECT ser_no,details FROM briefing_20387_service_item_info WHERE bd_no='$bd_no'&&visit_info_id='$visitId' ORDER BY id";
$serviceItemInfo = $briefing->getDynamicTableData($serviceItemSql);
include('f_header.php');
?>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="well">
                <h4 class="text-center text-info"><?php //echo $visitId; ?></h4>
                <h3 class="text-center text-default"><b><u>DIRECTORATE OF AIR INTELLIGENCE <br> INTELLIGENCE BRIEFING
                            WHILE PROCEEDING ABROAD</u></b></h3>
                <h4 class="text-center text-default">(All BAF personnel are to fill up this form prior to their
                    departure abroad. All are to go
                    through the instructions given in annex "A" and related AFO's and comply accordingly during their
                    stay abroad.) </h4>
                <form class="form" name="Form_20387" id="Form_20387" method="POST" action="" enctype="multipart/form-data" data-toggle="validator" role="form">

                    <input type="hidden" name="id" value="<?php echo $visitInfo['id']; ?>">
                    <input type="hidden" name="id2" value="<?php echo $personelInfo['id']; ?>">
                    <input type="hidden" name="ex_bd_lv_doc" value="<?php echo $visitInfo['ex_bd_lv_doc']; ?>">

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>1. Name</label>
                            <input type="text" value="<?php echo $_SESSION['name']; ?>" data-pattern-error="Special Character (&,$,# etc) not allowed ! "
                                   pattern="^[_A-z ]{1,}$" class="form-control" id="full_name" name="full_name"
                                   placeholder="Enter your Full Name">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 has-feedback">
                            <label>2. Rank</label>
                            <input type="text" value="<?php echo $_SESSION['rank']; ?>" data-pattern-error="Special Character not allowed ! "
                                   pattern="^[_A-z ]{1,}$" class="form-control" id="rank" name="rank"
                                   placeholder="Rank">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-4 has-feedback">
                            <label>3. BD/No</label>
                            <input type="text" class="form-control" id="bd_no" value="<?php echo $_SESSION['bd_no'] ?>"
                                   name="bd_no" placeholder="BD/No" disabled>
                        </div>
                        <div class="form-group col-md-4 has-feedback">
                            <label>4. Branch/Trade</label>
                            <input type="text" value="<?php echo $_SESSION['br_trade']; ?>" data-pattern-error="Special Character (&,$,# etc) not allowed"
                                   pattern="^[()_A-z/ ]{1,}$" class="form-control" id="br_trade" name="br_trade"
                                   placeholder="Branch/Trade">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 has-feedback">
                            <label>5. Unit </label>
                            <input type="text" value="<?php echo $visitInfo['unit']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="unit" name="unit" placeholder="Unit">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6 has-feedback">
                            <label>6. Passport No</label>
                            <input type="text" value="<?php echo $visitInfo['passport_no']; ?>" pattern="^[A-z0-9/  ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="passport_no" name="passport_no" placeholder="Passport">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>7. Purpose of visit </label>
                            <input type="text" value="<?php echo $visitInfo['purpose_of_visit']; ?>"  pattern="^[_A-z0-9-/., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="purpose" name="purpose_of_visit" placeholder="Purpose of Visit">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 has-feedback">
                            <label>8. Destination country: Airport </label>
                            <input type="text" value="<?php echo $visitInfo['destination_airport']; ?>" pattern="^[_A-z0-9-/., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="destination_airport" name="destination_airport" placeholder="Airport">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6 has-feedback">
                            <label>Country </label>
                            <input type="text" value="<?php echo $visitInfo['destination_country']; ?>" pattern="^[_A-z0-9-/., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="destination_country" name="destination_country" placeholder="Country">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <?php if (mysqli_num_rows($transitInfo)>0 ) { ?>
                    <div style="border: 1px solid forestgreen;" class="table-responsive">
                        <label>9. Transit country/countries (other than ser no 8): </label>
                        <table class="table table-bordered" id="transit_table">
                            <tr>
                                <th width="10%" class="text-center">Ser No</th>
                                <th width="30%" class="text-center">Country</th>
                                <th width="30%" class="text-center">Duration of Stay</th>
                                <th width="30%" class="text-center">Purpose</th>
                            </tr>
                            <?php while ($transit = mysqli_fetch_assoc($transitInfo)) { ?>
                            <tr>
                                <td style="background-color: white" ><?php echo $transit['ser_no']; ?></td>
                                <td style="background-color: white" ><?php echo $transit['country']; ?></td>
                                <td style="background-color: white" ><?php echo $transit['duration']; ?></td>
                                <td style="background-color: white" ><?php echo $transit['purpose']; ?></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <?php } ?>

                    <div class="row">
                        <div class="form-group col-md-6 has-feedback">
                            <label>10. Date of departure </label>
                            <input type="date" value="<?php echo $visitInfo['departure_date']; ?>" class="form-control" id="departure_date" name="departure_date"
                                   placeholder="date">
                        </div>
                        <div class="form-group col-md-6 has-feedback">
                            <label>11. Place of departure</label>
                            <input type="text" value="<?php echo $visitInfo['departure_place']; ?>" pattern="^[_A-z0-9-/., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="departure_place" name="departure_place" placeholder="Place of departure">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>12. Name of the carrier with flight no: </label>
                            <input type="text" value="<?php echo $visitInfo['name_of_airlines']; ?>" pattern="^[_A-z0-9-/., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="name_of_airlines" name="name_of_airlines"
                                   placeholder="Name of Airlines with Flight No">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 has-feedback">
                            <label>13. Date of reaching destination : </label>
                            <input type="date" required value="<?php echo$visitInfo['date_of_reaching_destination'];?>" class="form-control" name="date_of_reaching_destination">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6 has-feedback">
                            <label>Date of Return From destination : </label>
                            <input type="date" required value="<?php echo$visitInfo['date_of_leaving_destination'];?>" class="form-control" name="date_of_leaving_destination">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>Do you have Ex-BD lv with the tour? If yes, give date</label>
                            <input class="btn btn-info" type="button" value="Yes" name="btnExBdLv" required/>
                            <input class="btn btn-info" type="button" value="No" name="btnExBdLv" required/>
                            <div class="row"  id="ExBdLv" style="display: none">
                                <div class="form-group col-md-6 has-feedback">
                                    <label>Date of lv start : </label>
                                    <input type="date" value="<?php echo$visitInfo['ex_bd_lv_start'];?>" class="form-control" name="ex_bd_lv_start">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-md-6 has-feedback">
                                    <label>Date of lv finish : </label>
                                    <input type="date" value="<?php echo$visitInfo['ex_bd_lv_finish'];?>" class="form-control" name="ex_bd_lv_finish" >
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="col-md-12">
                                    <?php
                                    if($visitInfo['ex_bd_lv_doc'] != '') { ?>
                                        <label for="">Uploaded Doc : </label>
                                        <a href="ex_bd_lv_docs/<?php echo $visitInfo['ex_bd_lv_doc'] ?>" target="_blank">Download</a>
                                    <?php } else { ?>
                                        <label for="">No Doc Uploaded!</label>
                                    <?php } ?>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Upload your ex-bd leave Permission document</label>
                                    <input class="form-control" type="file" name="myfile">
                                    <h6>File Must be .jpg, .png, .pdf  and size not exceed 5MB !</h6>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>14. Duration of stay abroad : </label>
                            <input type="text" value="<?php echo $visitInfo['duration_of_stay_abroad']; ?>" pattern="^[_A-z0-9-/., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="duration_of_stay_abroad" name="duration_of_stay_abroad"
                                   placeholder="Duration of stay abroad">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <?php if(mysqli_num_rows($pastVisitInfo)>0) { ?>
                    <div style="border: 1px solid forestgreen;" class="table-responsive">
                        <label>15. Details visit abroad in the past (in the last 05 years): </label>
                        <table class="table table-bordered" id="past_table">
                            <tr>
                                <th width="5%" class="text-center">Ser</th>
                                <th width="25%" class="text-center">Country</th>
                                <th width="25%" class="text-center">Purpose</th>
                                <th width="25%" class="text-center">Duration of Stay</th>
                                <th width="20%" class="text-center">Remarks</th>
                            </tr>
                            <?php while ($pastVisit = mysqli_fetch_assoc($pastVisitInfo)) { ?>
                            <tr>
                                <td style="background-color: white" class="past_visit_ser_no"><?php echo $pastVisit['ser_no']; ?></td>
                                <td style="background-color: white" class="past_country"><?php echo $pastVisit['country']; ?></td>
                                <td style="background-color: white" class="past_purpose"><?php echo $pastVisit['purpose']; ?></td>
                                <td style="background-color: white" class="past_duration_of_stay"><?php echo $pastVisit['duration']; ?></td>
                                <td style="background-color: white" class="past_remarks"><?php echo $pastVisit['remarks']; ?></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <?php } ?>

                    <?php if(mysqli_num_rows($familyMemberInfo)>0) { ?>
                    <div style="border: 1px solid forestgreen;" class="table-responsive">
                        <label>16. Particulars of the family members traveling with you or likely to accompany
                            later: </label>
                        <table class="table table-bordered" id="family_table">
                            <tr>
                                <th width="10%" class="text-center">Ser</th>
                                <th width="30%" class="text-center">Name</th>
                                <th width="30%" class="text-center">Relation</th>
                                <th width="30%" class="text-center">Date of Departure</th>
                            </tr>
                            <?php while ($familyMember = mysqli_fetch_assoc($familyMemberInfo)) { ?>
                                <tr>
                                    <td style="background-color: white" class="past_visit_ser_no"><?php echo $familyMember['ser_no']; ?></td>
                                    <td style="background-color: white" class="past_country"><?php echo $familyMember['family_name']; ?></td>
                                    <td style="background-color: white" class="past_purpose"><?php echo $familyMember['relation']; ?></td>
                                    <td style="background-color: white" class="past_duration_of_stay"><?php echo $familyMember['departure_date']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <?php } ?>

                    <?php if(mysqli_num_rows($sponsorInfo)>0) { ?>
                    <div style="border: 1px solid forestgreen;" class="table-responsive">
                        <label>17. Particulars of the sponsor/relative friends in the visiting country who may help you
                            in an emergency: </label>
                        <table class="table table-bordered" id="sponsor_table">
                            <tr>
                                <th width="5%" class="text-center">Ser</th>
                                <th width="25%" class="text-center">Name</th>
                                <th width="20%" class="text-center">Occupation</th>
                                <th width="20%" class="text-center">Relation</th>
                                <th width="30%" class="text-center">Address</th>
                            </tr>
                            <?php while ($sponsor = mysqli_fetch_assoc($sponsorInfo)) { ?>
                                <tr>
                                    <td style="background-color: white"><?php echo $sponsor['ser_no']; ?></td>
                                    <td style="background-color: white"><?php echo $sponsor['sponsor_name']; ?></td>
                                    <td style="background-color: white"><?php echo $sponsor['occupation']; ?></td>
                                    <td style="background-color: white"><?php echo $sponsor['relation']; ?></td>
                                    <td style="background-color: white"><?php echo $sponsor['address']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <?php } ?>

                    <?php if(mysqli_num_rows($serviceItemInfo)>0) { ?>
                    <div style="border: 1px solid forestgreen;" class="table-responsive">
                        <label>18. List of the service items/documents(if any) being carried by you: </label>
                        <table class="table table-bordered" id="service_item_table">
                            <tr>
                                <th width="15%" class="text-center">Ser No</th>
                                <th width="85%" class="text-center">Item Details</th>
                            </tr>
                            <?php while ($serviceItem = mysqli_fetch_assoc($serviceItemInfo)) { ?>
                                <tr>
                                    <td style="background-color: white"><?php echo $serviceItem['ser_no']; ?></td>
                                    <td style="background-color: white"><?php echo $serviceItem['details']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <?php } ?>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>19. Total amount of money being credited to you for the course/visit: </label>
                            <input type="text" value="<?php echo $visitInfo['total_money']; ?>" pattern="^[_A-z0-9-/., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="total_money" name="total_money" placeholder="Money Credited">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>20. Are you taking any personal money with you? If yes, state the amount</label>
                            <input type="text" value="<?php echo $visitInfo['personal_money']; ?>" pattern="^[_A-z0-9-/., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   id="inputEmail4" name="personal_money" placeholder="Personal Money">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <h4 class="text-center text-default">
                        <input id="agreement" required type="checkbox" name="agreement" value="1"> * I hereby certified
                        that the information given above are correct to the vest of my knowledge
                        belief and I shall be liable of diciplinary action for giving any wrong statement.
                    </h4>
                    <div class="form-group row">
                        <div class="col-md-offset-5 col-md-7">
                            <button type="submit" class="btn btn-success" id="save" name="btn_update">Update Data</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <h5>Annex:</h5>
                        <h5>A. General instruction for BAF personal while proceeding abroad. </h5>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="../js/jquery-1.12.4.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/validator.js"></script>
</body>
</html>
<script type="text/javascript">
    $(function () {
        $("input[name=btnpersonTravelingWith]").click(function () {
            if ($(this).val() == "Yes") {
                $("#personTravelingWith").show();
            } else {
                $("#personTravelingWith").hide();
            }
        });
        $("input[name=btnExBdLv]").click(function () {
            if ($(this).val() == "Yes") {
                $("#ExBdLv").show();
            } else {
                $("#ExBdLv").hide();
            }
        });
    });
</script>