<?php
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
    require_once '../Briefing.php';
    $briefing = new Briefing();
    $message = $briefing->updateF20388DeBriefVisitData($_POST);
    $message .= $briefing->updateUserTable();
    $_SESSION['message']=$message;
    header('Location: homepage.php');
}

require_once '../Briefing.php';
$briefing = new Briefing();
$personelInfo = $briefing->view20388PersonalDataForUpdatePage($bd_no,$visitId);
$personelInfo = mysqli_fetch_assoc($personelInfo);

$briefing = new Briefing();
$visitInfo = $briefing->view20388VisitDataForUpdatePage($bd_no,$visitId);
$visitInfo = mysqli_fetch_assoc($visitInfo);

$transitSql = "SELECT ser_no,country,duration,purpose FROM debrief_20388_transit_info WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
$transitInfo = $briefing->getDynamicTableData($transitSql);

$svcItemSql= "SELECT ser_no,type_of_docu,place_of_lost,remarks FROM debrief_20388_lose_service_property WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
$svcItemInfo = $briefing->getDynamicTableData($svcItemSql);

$milSiteSql= "SELECT ser_no,place,importance FROM debrief_20388_military_site_visited WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
$milSiteInfo = $briefing->getDynamicTableData($milSiteSql);

$milMeetSql= "SELECT ser_no,particulars,appointment,purpose_of_meeting FROM debrief_20388_meeting WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
$milMeetInfo = $briefing->getDynamicTableData($milMeetSql);

$clubMemberSql= "SELECT ser_no,name_of_club,remarks FROM debrief_20388_club_membership WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
$clubMemberInfo = $briefing->getDynamicTableData($clubMemberSql);

$giftSql= "SELECT ser_no,details_of_gift_received,gift_date,approx_value,dignitary_name,remarks FROM debrief_20388_gift WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
$giftInfo = $briefing->getDynamicTableData($giftSql);

$armsSql= "SELECT ser_no,type_of_arm,price,permission_taken_from,remarks FROM debrief_20388_fire_arms WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
$armsInfo = $briefing->getDynamicTableData($armsSql);
include('f_header.php');
?>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="well">
                <h3 class="text-center text-default"><b><u>DIRECTORATE OF AIR INTELLIGENCE <br> INTELLIGENCE DE-BRIEFING
                            ON RETURN FROM VISIT/UN MISSION ABROAD</u></b></h3>
                <h4 class="text-center text-default">(This form is prepared in accordance with AFO 200-2 dated 22 Apr
                    1990. Following info are to be furnished by all
                    BAF personnel returning from abroad. You may add extra papers, documents, photos and maps to furnish
                    your report.) </h4>
                <form class="form" method="POST" action="" data-toggle="validator">

                    <input type="hidden" name="id" value="<?php echo $visitInfo['id']; ?>">
                    <input type="hidden" name="id2" value="<?php echo $personelInfo['id']; ?>">

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>1. Name</label>
                            <input class="form-control" type="text" value="<?php echo $personelInfo['name']; ?>" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 has-feedback">
                            <label>2. Rank</label>
                            <input name="rank" type="text" value="<?php echo $personelInfo['rank']; ?>" class="form-control">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6 has-feedback">
                            <label>3. BD/No</label>
                            <input type="number" class="form-control" value="<?php echo $_SESSION['bd_no'] ?>" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 has-feedback">
                            <label>4. Branch/Trade</label>
                            <input type="text" value="<?php echo $personelInfo['br_trade']; ?>" class="form-control" disabled>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6 has-feedback">
                            <label>5. Unit </label>
                            <input type="text" value="<?php echo $visitInfo['unit']; ?>" data-pattern-error="Special Character (&,$,# etc) not allowed"
                                   pattern="^[_A-z0-9-., ]{1,}$" class="form-control" id="unit" name="unit"
                                   placeholder="Unit">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>6. Purpose of visit </label>
                            <input type="text" value="<?php echo $visitInfo['visit_purpose']; ?>" data-pattern-error="Special Character (&,$,# etc) not allowed"
                                   pattern="^[_A-z0-9-., ]{1,}$" class="form-control" name="visit_purpose"
                                   placeholder="Purpose">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>7. Total duration of stay abroad: From </label>
                            <input type="date" value="<?php echo $visitInfo['duration_of_stay_from']; ?>" class="form-control" name="duration_of_stay_from" placeholder="From">
                        </div>
                        <div class="col-md-6">
                            <label>To </label>
                            <input type="date" value="<?php echo $visitInfo['duration_of_stay_to']; ?>" class="form-control" name="duration_of_stay_to" placeholder="To">
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>8. Destination country: </label>
                            <input type="text" value="<?php echo $visitInfo['destination_country']; ?>" pattern="^[_A-z0-9-.,Å ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   name="destination_country" placeholder="Destination country">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <?php if(mysqli_num_rows($transitInfo)>0) { ?>
                        <div style="border: 1px solid forestgreen;" class="table-responsive">
                            <label>9. Transit country/countries visited(other than ser no 8): </label>
                            <table class="table table-bordered" id="transit_table">
                                <tr>
                                    <th width="10%" class="text-center">Ser No</th>
                                    <th width="30%" class="text-center">Country</th>
                                    <th width="30%" class="text-center">Duration of Stay</th>
                                    <th width="30%" class="text-center">Purpose</th>
                                </tr>
                                <?php while ($transit = mysqli_fetch_assoc($transitInfo)) { ?>
                                    <tr>
                                        <td style="background-color: white"><?php echo $transit['ser_no']; ?></td>
                                        <td style="background-color: white"><?php echo $transit['country']; ?></td>
                                        <td style="background-color: white"><?php echo $transit['duration']; ?></td>
                                        <td style="background-color: white"><?php echo $transit['purpose']; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    <?php } ?>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>10. Details of visit : </label>
                        </div>
                        <div class="col-md-12">
                            <label>a. Name of the local agency/company/institute sponsoring the visit (if
                                applicable) </label>
                            <input type="text" value="<?php echo $visitInfo['name_of_sponsor']; ?>" data-pattern-error="Special Character (&,$,# etc) not allowed"
                                   pattern="^[_A-z0-9-.,/ ]{1,}$" class="form-control" name="name_of_sponsor">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>b. Name and address of the foreign company/institution/agency sponsoring the
                                visit</label>
                            <input type="text" value="<?php echo $visitInfo['name_address_of_foreign_company']; ?>" data-pattern-error="Special Character (&,$,# etc) not allowed"
                                   pattern="^[_A-z0-9-.,/ ]{1,}$" class="form-control"
                                   name="name_address_of_foreign_company">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>c. Your observation and comments about the visit for future implications: </label>
                            <input type="text" value="<?php echo $visitInfo['observation_for_future']; ?>" data-pattern-error="Special Character (&,$,# etc) not allowed"
                                   pattern="^[_A-z0-9-.,/ ]{1,}$" class="form-control" name="observation_for_future">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label>11. Amount of money received from Bangladesh Govt. in foreign currency : </label>
                        </div>
                        <div class="form-group col-md-6 has-feedback">
                            <label>a. Daily rate</label>
                            <input type="text" value="<?php echo $visitInfo['daily_rate']; ?>" data-pattern-error="Special Characer (&,$,# etc) not allowed"
                                   pattern="^[_A-z0-9-.,/ ]{1,}$" class="form-control" name="daily_rate"
                                   placeholder="Rate">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-6 has-feedback">
                            <label>b. Total</label>
                            <input type="text" value="<?php echo $visitInfo['total_amount']; ?>" data-pattern-error="Special Character (&,$,# etc) not allowed"
                                   pattern="^[_A-z0-9-., ]{1,}$" class="form-control" name="total_amount"
                                   placeholder="Total">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label>12. Facilities provided by the visiting country/agency/company/institution: </label>
                        </div>
                        <div class="form-group col-md-12 has-feedback">
                            <label>a. Where you given any cash by the host? If yes, state reasons and amount </label>
                            <input type="text" value="<?php echo $visitInfo['cash_by_host']; ?>" data-pattern-error="Special Character (&,$,# etc) not allowed"
                                   pattern="^[_A-z0-9-/., ]{1,}$" class="form-control" name="cash_by_host">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-12 has-feedback">
                            <label>b. Was food and accommodation free?</label>
                            <input type="text" value="<?php echo $visitInfo['food_accommodation']; ?>" pattern="^[_A-z0-9-/., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   name="food_accommodation">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-12 has-feedback">
                            <label>c. Was transportation free? </label>
                            <input type="text" value="<?php echo $visitInfo['transportation']; ?>" pattern="^[_A-z0-9-/., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   name="transportation">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>13. Foreign currency carried at your own arrangement </label>
                            <input type="text" value="<?php echo $visitInfo['own_currency']; ?>" class="form-control" name="own_currency"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed"
                                   pattern="^[_A-z0-9-/., ]{1,}$">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>14. Did you lose any of your personal items or money during your stay or on the
                                way? </label>
                            <input type="text" value="<?php echo $visitInfo['lose_personnel_item']; ?>" data-pattern-error="Special Character (&,$,# etc) not allowed"
                                   pattern="^[_A-z0-9-/., ]{1,}$" class="form-control" name="lose_personnel_item">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>15. Have you cleared all bills from all concerned against you? </label>
                            <input type="text" value="<?php echo $visitInfo['bill_cleared']; ?>" pattern="^[_A-z0-9-/., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   name="bill_cleared">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12 has-feedback">
                            <label>16. Have you made any financial transaction with any foreigner or Bangladeshi
                                national residing there? If yes, give details</label>
                            <input type="text" value="<?php echo $visitInfo['financial_transaction']; ?>" pattern="^[_A-z0-9-/., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   name="financial_transaction">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>17. Total amount of foreign currency brought back to Bangladesh: </label>
                            <input type="text" value="<?php echo $visitInfo['currency_back']; ?>" data-pattern-error="Special Character (&,$,# etc) not allowed"
                                   pattern="^[_A-z0-9-./, ]{1,}$" class="form-control" name="currency_back">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>18. Do you know if any of your fellow members made friendship or any agreement with
                                any foreigner? If yes, furnish details: </label>
                            <input type="text" value="<?php echo $visitInfo['fellow_member']; ?>" data-pattern-error="Special Character (&,$,# etc) not allowed"
                                   pattern="^[_A-z0-9-/., ]{1,}$" class="form-control" name="fellow_member">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>19. Have you discussed any classified information with any foreigners? If yes, give
                                details </label>
                            <input type="text" value="<?php echo $visitInfo['classified_info']; ?>" pattern="^[_A-z0-9-/., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   name="classified_info">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <?php if(mysqli_num_rows($svcItemInfo)>0) { ?>
                        <div style="border: 1px solid forestgreen;" class="table-responsive">
                            <label>20. During your stay abroad did you lose any service property or documents? If yes, list
                                them: </label>
                            <table class="table table-bordered" id="lose_service_property">
                                <tr>
                                    <th width="10%" class="text-center">Ser No</th>
                                    <th width="30%" class="text-center">Type of docu</th>
                                    <th width="30%" class="text-center">Place at which lost</th>
                                    <th width="30%" class="text-center">Remarks</th>
                                </tr>
                                <?php while ($svcItem = mysqli_fetch_assoc($svcItemInfo)) { ?>
                                    <tr>
                                        <td style="background-color: white"><?php echo $svcItem['ser_no']; ?></td>
                                        <td style="background-color: white"><?php echo $svcItem['type_of_docu']; ?></td>
                                        <td style="background-color: white"><?php echo $svcItem['place_of_lost']; ?></td>
                                        <td style="background-color: white"><?php echo $svcItem['remarks']; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    <?php } ?>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>21. Have you or any member of your team encountered any difficulty or got involved in
                                any problem/trouble? Give details </label>
                            <input type="text" value="<?php echo $visitInfo['difficulty']; ?>" pattern="^[_A-z0-9-/., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   name="difficulty">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>22. Have you ever suspected any member of your team of having secret understanding
                                with any foreigner? Write in details </label>
                            <input type="text" value="<?php echo $visitInfo['secret_understanding']; ?>" pattern="^[_A-z0-9-/., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   name="secret_understanding">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>23. Details of the foreign intelligence network or spy if you could observe
                                them </label>
                            <input type="text" value="<?php echo $visitInfo['foreign_spy']; ?>" pattern="^[_A-z0-9-/., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   name="foreign_spy">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>24. General impression of the foreigner and their Govt. about Bangladesh (to include
                                views, opinions, expressed by high officials/published in their media) </label>
                            <input type="text" value="<?php echo $visitInfo['gen_impression']; ?>" pattern="^[_A-z0-9-/., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   name="gen_impression">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <?php if(mysqli_num_rows($milSiteInfo)>0) { ?>
                        <div style="border: 1px solid forestgreen;" class="table-responsive">
                            <label>25. Details of the military/industrial sites visited/stayed: (you may add map/photo to
                                furnish this column) </label>
                            <table class="table table-bordered" id="military_site_visited">
                                <tr>
                                    <th width="15%" class="text-center">Ser No</th>
                                    <th width="25%" class="text-center">Place</th>
                                    <th width="60%" class="text-center">Importance (give details in case of mil installations)</th>
                                </tr>
                                <?php while ($milSite = mysqli_fetch_assoc($milSiteInfo)) { ?>
                                    <tr>
                                        <td style="background-color: white"><?php echo $milSite['ser_no']; ?></td>
                                        <td style="background-color: white"><?php echo $milSite['place']; ?></td>
                                        <td style="background-color: white"><?php echo $milSite['importance']; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    <?php } ?>

                    <?php if(mysqli_num_rows($milMeetInfo)>0) { ?>
                    <div style="border: 1px solid forestgreen;" class="table-responsive">
                        <label>26. Details of the meeting with military and civil high officials: </label>
                        <table class="table table-bordered" id="meeting_table">
                            <tr>
                                <th width="10%" class="text-center">Ser No</th>
                                <th width="40%" class="text-center">particulars</th>
                                <th width="30%" class="text-center">Appointment</th>
                                <th width="30%" class="text-center">Purpose of Meeting</th>
                            </tr>
                            <?php while ($milMeet = mysqli_fetch_assoc($milMeetInfo)) { ?>
                                <tr>
                                    <td style="background-color: white"><?php echo $milMeet['ser_no']; ?></td>
                                    <td style="background-color: white"><?php echo $milMeet['particulars']; ?></td>
                                    <td style="background-color: white"><?php echo $milMeet['appointment']; ?></td>
                                    <td style="background-color: white"><?php echo $milMeet['purpose_of_meeting']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <?php } ?>

                    <?php if(mysqli_num_rows($clubMemberInfo)>0) { ?>
                        <div style="border: 1px solid forestgreen;" class="table-responsive">
                            <label>27. Did you become a member of any foreign organization/club/association? Give
                                details: </label>
                            <table class="table table-bordered" id="club_member">
                                <tr>
                                    <th width="10%" class="text-center">Ser No</th>
                                    <th width="40%" class="text-center">Name of the Club/Org</th>
                                    <th width="40%" class="text-center">Remarks</th>
                                </tr>
                                <?php while ($clubMember = mysqli_fetch_assoc($clubMemberInfo)) { ?>
                                    <tr>
                                        <td style="background-color: white"><?php echo $clubMember['ser_no']; ?></td>
                                        <td style="background-color: white"><?php echo $clubMember['name_of_club']; ?></td>
                                        <td style="background-color: white"><?php echo $clubMember['remarks']; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    <?php } ?>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>28. Any other info/suggestion/opinion that you feel will be valuable for future
                                visits of such kind: </label>
                            <input type="text" value="<?php echo $visitInfo['valuable_info']; ?>" pattern="^[_A-z0-9-/., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   name="valuable_info">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <?php if(mysqli_num_rows($giftInfo)>0) { ?>
                    <div style="border: 1px solid forestgreen;" class="table-responsive">
                        <label>29. Particulars of gift received from foreign nationals : (you may incl the gift itims
                            for nec clearance as per AFO 113-13 dated 12 March 1996). </label>
                        <table class="table table-bordered" id="giftItemTable">
                            <tr>
                                <th width="10%" class="text-center">Ser No</th>
                                <th width="20%" class="text-center">Details of Gift Received</th>
                                <th width="15%" class="text-center">Date of Receipt</th>
                                <th width="10%" class="text-center">Approx Value</th>
                                <th width="20%" class="text-center">Name of Dignitary/Institution from whom received</th>
                                <th width="15%" class="text-center">Remarks (Mention if Enclosed)</th>
                            </tr>
                            <?php while ($gift = mysqli_fetch_assoc($giftInfo)) { ?>
                                <tr>
                                    <td style="background-color: white"><?php echo $gift['ser_no']; ?></td>
                                    <td style="background-color: white"><?php echo $gift['details_of_gift_received']; ?></td>
                                    <td style="background-color: white"><?php echo $gift['gift_date']; ?></td>
                                    <td style="background-color: white"><?php echo $gift['approx_value']; ?></td>
                                    <td style="background-color: white"><?php echo $gift['dignitary_name']; ?></td>
                                    <td style="background-color: white"><?php echo $gift['remarks']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <?php } ?>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>30. a. Have you purchased any fire arms ? </label>
                            <input type="text" value="<?php echo $visitInfo['fire_arm']; ?>" pattern="^[_A-z0-9-./, ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   name="fire_arm">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <?php if(mysqli_num_rows($armsInfo)>0) { ?>
                        <div style="border: 1px solid forestgreen;" class="table-responsive">
                            <label>b. If yes, fill up the fol boxes:</label>
                            <table class="table table-bordered" id="fire_arms_table">
                                <tr>
                                    <th width="10%" class="text-center">Ser No</th>
                                    <th width="30%" class="text-center">Type of Fire Arms</th>
                                    <th width="20%" class="text-center">Price</th>
                                    <th width="20%" class="text-center">Permission Taken From</th>
                                    <th width="10%" class="text-center">Remarks</th>
                                </tr>
                                <?php while ($arms = mysqli_fetch_assoc($armsInfo)) { ?>
                                    <tr>
                                        <td style="background-color: white"><?php echo $arms['ser_no']; ?></td>
                                        <td style="background-color: white"><?php echo $arms['type_of_arm']; ?></td>
                                        <td style="background-color: white"><?php echo $arms['price']; ?></td>
                                        <td style="background-color: white"><?php echo $arms['permission_taken_from']; ?></td>
                                        <td style="background-color: white"><?php echo $arms['remarks']; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    <?php } ?>

                    <h4 class="text-center text-default"><input type="checkbox" name="agreement" value="1" required> * I
                        hereby certified that the information given above are correct to the vest of my knowledge
                        belief and I shall be liable of diciplinary action for giving any wrong statement. </h4>
                    <div class="form-group row">
                        <div class="col-md-offset-5 col-md-7">
                            <button type="submit" class="btn btn-success" id="save" name="btn_update">Update Data</button>
                        </div>
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