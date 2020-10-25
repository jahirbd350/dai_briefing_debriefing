<?php
session_start();

$user_id = $_SESSION['user_id'];
$bd_no = $_GET['bd_no'];
$visitId = $_GET['visit_info_id'];

if (!isset($_SESSION['user_id'])) {
    header('location: index.php');
}

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'logout') {
        require_once('Login.php');
        $logout = new Login();
        $message = $logout->adminLogout();
        $_SESSION['message'] = $message;
    }
}

$message = '';
if (isset($_POST['btn_update'])) {
    require_once '../Briefing.php';
    $briefing = new Briefing();
    $message = $briefing->updateF20389DeBriefTrainingData($_POST);
    $message .= $briefing->updateUserTable($_POST);
    $_SESSION['message']=$message;
    header('Location: homepage.php');
}

require_once '../Briefing.php';
$briefing = new Briefing();
$personelInfo = $briefing->viewPersonalData($bd_no);
$personelInfo = mysqli_fetch_assoc($personelInfo);

$briefing = new Briefing();
$TrainingInfo = $briefing->view20389TrainingDataForUpdatePage($bd_no,$visitId);
$TrainingInfo = mysqli_fetch_assoc($TrainingInfo);

$transitSql = "SELECT ser_no,country,duration,purpose FROM debrief_20389_transit_info WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
$transitInfo = $briefing->getDynamicTableData($transitSql);

$studentsSql = "SELECT ser_no,nationality,ranks_particulars,remarks FROM debrief_20389_summary_of_students WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
$studentsInfo = $briefing->getDynamicTableData($studentsSql);

$foreign_friendsSql = "SELECT ser_no,name_address,occupation,remarks FROM debrief_20389_friends_in_abroad WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
$foreign_friendsInfo = $briefing->getDynamicTableData($foreign_friendsSql);

$kind_foreignerSql = "SELECT ser_no,name_address,occupation,remarks FROM debrief_20389_help_by_foreigner WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
$kind_foreignerInfo = $briefing->getDynamicTableData($kind_foreignerSql);

$SvcItemSql = "SELECT ser_no,type_of_docu,place_of_lost,remarks FROM debrief_20389_lose_service_property WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
$svcItemInfo = $briefing->getDynamicTableData($SvcItemSql);

$institutionSql = "SELECT ser_no,name_of_institution,remarks FROM debrief_20389_institution WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
$institutionInfo = $briefing->getDynamicTableData($institutionSql);

$milSiteSql = "SELECT ser_no,place,importance FROM debrief_20389_military_site_visited WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
$milSiteInfo = $briefing->getDynamicTableData($milSiteSql);

$milMeetSql = "SELECT ser_no,particulars,appointment,purpose_of_meeting FROM debrief_20389_meeting WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
$milMeetInfo = $briefing->getDynamicTableData($milMeetSql);

$clubMemberSql= "SELECT ser_no,name_of_club,remarks FROM debrief_20389_club_membership WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
$clubMemberInfo = $briefing->getDynamicTableData($clubMemberSql);

$giftSql= "SELECT ser_no,details_of_gift_received,gift_date,approx_value,dignitary_name,remarks FROM debrief_20389_gift WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
$giftInfo = $briefing->getDynamicTableData($giftSql);

$armsSql= "SELECT ser_no,type_of_arm,price,permission_taken_from,remarks FROM debrief_20389_fire_arms WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
$armsInfo = $briefing->getDynamicTableData($armsSql);
include('f_header.php');
?>


    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="well">
                <h3 class="text-center text-default"><b><u>DIRECTORATE OF AIR INTELLIGENCE <br> INTELLIGENCE DE-BRIEFING
                            ON RETURN FROM COURSE ABROAD</u></b></h3>
                <h4 class="text-center text-default">(This form is prepared in accordance with AFO 200-2 dated 22 Apr
                    1990. Following info are to be furnished by all
                    BAF personnel returning from abroad. You may be add extra papers, documents, photos and maps to
                    furnish your report). </h4>

                <form class="form" method="POST" action="" data-toggle="validator">

                    <input type="hidden" name="id" value="<?php echo $TrainingInfo['id']; ?>">
                    <input type="hidden" name="id2" value="<?php echo $personelInfo['id']; ?>">

                    <div class="form-group row has-feedback">
                        <div class="field col-md-12">
                            <label for="full_name">1. Name</label>
                            <input type="text" value="<?php echo $personelInfo['name']; ?>" pattern="^[_A-z0-9. ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
                                   name="full_name" placeholder="Enter your Full Name">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>2. Rank</label>
                            <input type="text" value="<?php echo $personelInfo['rank']; ?>" class="form-control" id="rank" name="rank" placeholder="Rank">

                        </div>
                        <div class="col-md-6">
                            <label>3. BD/No</label>
                            <input type="number" class="form-control" id="bd_no" name="bd_no"
                                   value="<?php echo $_SESSION['bd_no']; ?>" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>4. Branch/Trade</label>
                            <input type="text" value="<?php echo $personelInfo['br_trade']; ?>" class="form-control" id="br_trade" name="br_trade"
                                   placeholder="Branch/Trade">
                        </div>
                        <div class="col-md-6">
                            <label>5. Unit </label>
                            <input type="text" value="<?php echo $TrainingInfo['unit']; ?>" class="form-control" id="unit" name="unit" placeholder="Unit">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>6. Total duration of stay abroad: From </label>
                            <input type="date" value="<?php echo $TrainingInfo['duration_of_stay_from']; ?>" class="form-control" name="duration_of_stay_from" placeholder="From">
                        </div>
                        <div class="col-md-6">
                            <label>To </label>
                            <input type="date" value="<?php echo $TrainingInfo['duration_of_stay_to']; ?>" class="form-control" name="duration_of_stay_to" placeholder="To">
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>7. Country at which the course was conducted</label>
                            <input type="text" value="<?php echo $TrainingInfo['course_which_country']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="course_which_country" placeholder="Country Name">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <?php if(mysqli_num_rows($transitInfo)>0) { ?>
                        <div style="border: 1px solid forestgreen;" class="table-responsive">
                            <label>8. Transit country/countries visited(other than ser no 7): </label>
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

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>9. Details of Training: </label>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>a. Name of the course</label>
                            <input type="text" value="<?php echo $TrainingInfo['name_of_course']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="name_of_course" placeholder="Course Name">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-6">
                            <label>b. Duration of the course: From</label>
                            <input type="date" value="<?php echo $TrainingInfo['course_from']; ?>" class="form-control" name="course_from" placeholder="From">
                        </div>
                        <div class="col-md-6">
                            <label>To</label>
                            <input type="date" value="<?php echo $TrainingInfo['course_to']; ?>" class="form-control" name="course_to" placeholder="To">
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>c. Name and address of the institution</label>
                            <input type="text" value="<?php echo $TrainingInfo['name_address_of_institution']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="name_address_of_institution">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>d. General description about the course content, composition of student officers
                                and observations about its utility and benefit to BAF </label>
                            <input type="text" value="<?php echo $TrainingInfo['course_content']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="course_content">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <?php if(mysqli_num_rows($studentsInfo)>0) { ?>
                        <div style="border: 1px solid forestgreen;" class="table-responsive">
                            <label>
                                e. Was the course conducted only for Bangladesh student? If no then details of the other
                                foreign students: (you may attach a course photograph). If the numbers of students are
                                more, you may give a summary of total number of students with rank as per following:
                            </label>

                            <table class="table table-bordered" id="summary_of_students">
                                <tr>
                                    <th width="10%">Ser No</th>
                                    <th width="25%">Nationality</th>
                                    <th width="30%">Ranks/Particulars</th>
                                    <th width="25%">Remarks</th>
                                </tr>
                                <?php while ($students = mysqli_fetch_assoc($studentsInfo)) { ?>
                                    <tr>
                                        <td style="background-color: white"><?php echo $students['ser_no']; ?></td>
                                        <td style="background-color: white"><?php echo $students['nationality']; ?></td>
                                        <td style="background-color: white"><?php echo $students['ranks_particulars']; ?></td>
                                        <td style="background-color: white"><?php echo $students['remarks']; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    <?php } ?>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>f. Your observation and guidance to BAF personnel attending the same course in
                                future: </label>
                            <input type="text" value="<?php echo $TrainingInfo['observation_for_future']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="observation_for_future">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>g. Which appointment in BAF would allow you to exercise the most from the
                                course?</label>
                            <input type="text" value="<?php echo $TrainingInfo['appointment_in_baf']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="appointment_in_baf">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>10. Amount of money received from Bangladesh Govt. in foreign currency: </label>
                        </div>
                        <div class="col-md-6">
                            <label>a. Daily rate</label>
                            <input type="text" value="<?php echo $TrainingInfo['money_daily_rate']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="money_daily_rate">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="col-md-6">
                            <label>b. Total</label>
                            <input type="text" value="<?php echo $TrainingInfo['money_total']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="money_total">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>11.Facilities provided by the visiting country: </label>
                        </div>
                        <div class="col-md-12">
                            <label>a. Were you given any cash by the host? if yes, state reasons and amount</label>
                            <input type="text" value="<?php echo $TrainingInfo['cash_by_host']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="cash_by_host">
                            <div class="with-errors help-block"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>b. Was food and accommodation free?</label>
                            <input type="text" value="<?php echo $TrainingInfo['food_accommodation']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="food_accommodation">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>c. Was transportation free?</label>
                            <input type="text" value="<?php echo $TrainingInfo['transportation']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="transportation">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>12. Foreign currency carried at your own arrangement</label>
                            <input type="text" value="<?php echo $TrainingInfo['own_currency']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="own_currency">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>13. Personal expenditure incurred during stay abroad(monthly)</label>
                            <input type="text" value="<?php echo $TrainingInfo['monthly_expenditure']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="monthly_expenditure">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>14. Did you lost any of your personal items or money during your stay or on the
                                way?</label>
                            <input type="text" value="<?php echo $TrainingInfo['lose_personal_item']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="lose_personal_item">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>15. Have you cleared all bills from all concerned against you?</label>
                            <input type="text" value="<?php echo $TrainingInfo['bill_clear']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="bill_clear">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>16. Have you made any financial transaction with any foreigner or bangladeshi
                                national residing
                                there? If yes, give details</label>
                            <input type="text" value="<?php echo $TrainingInfo['financial_transaction']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="financial_transaction">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>17. total amount of foreign currency brought back to Bangladesh: </label>
                            <input type="text" value="<?php echo $TrainingInfo['currency_back']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="currency_back">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <?php if(mysqli_num_rows($foreign_friendsInfo)>0) { ?>
                        <div style="border: 1px solid forestgreen;" class="table-responsive">
                            <label>18. List a few names of your close friends in abroad who displayed keen interest about
                                BAF or
                                Bangladesh Armed Forces:</label>
                            <table class="table table-bordered" id="foreign_friends_table">
                                <tr>
                                    <th width="10%">Ser No</th>
                                    <th width="35%">Name & Address</th>
                                    <th width="35%">Occupation</th>
                                    <th width="20%">Remarks</th>
                                </tr>
                                <?php while ($foreign_friends = mysqli_fetch_assoc($foreign_friendsInfo)) { ?>
                                    <tr>
                                        <td style="background-color: white"><?php echo $foreign_friends['ser_no']; ?></td>
                                        <td style="background-color: white"><?php echo $foreign_friends['name_address']; ?></td>
                                        <td style="background-color: white"><?php echo $foreign_friends['occupation']; ?></td>
                                        <td style="background-color: white"><?php echo $foreign_friends['remarks']; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    <?php } ?>

                    <?php if(mysqli_num_rows($kind_foreignerInfo)>0) { ?>
                        <div style="border: 1px solid forestgreen;" class="table-responsive">
                            <label>19. Was any foreigner exceptionally kind to you or came to help you out of
                                dificulties.Give details :</label>
                            <table class="table table-bordered" id="foreign_friends_table">
                                <tr>
                                    <th width="10%">Ser No</th>
                                    <th width="25%">Name & Address</th>
                                    <th width="35%">Occupation</th>
                                    <th width="20%">Remarks</th>
                                </tr>
                                <?php while ($kind_foreigner = mysqli_fetch_assoc($kind_foreignerInfo)) { ?>
                                    <tr>
                                        <td style="background-color: white"><?php echo $kind_foreigner['ser_no']; ?></td>
                                        <td style="background-color: white"><?php echo $kind_foreigner['name_address']; ?></td>
                                        <td style="background-color: white"><?php echo $kind_foreigner['occupation']; ?></td>
                                        <td style="background-color: white"><?php echo $kind_foreigner['remarks']; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    <?php } ?>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>20. Did you contract/promise or were forced to marry any foreigner? If yes, write in
                                details</label>
                            <input type="text" value="<?php echo $TrainingInfo['promise']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="promise">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>21. Do you know if any of your fellow members made friendship or any agreemarnt with
                                any
                                foreigner/ If yes, furnish details </label>
                            <input type="text" value="<?php echo $TrainingInfo['friendship']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="friendship">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>22. Have you discussed any classified information with any foreigner? If yes, Give
                                details</label>
                            <input type="text" value="<?php echo $TrainingInfo['classified_info']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="classified_info">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <?php if(mysqli_num_rows($svcItemInfo)>0) { ?>
                        <div style="border: 1px solid forestgreen;" class="table-responsive">
                            <label>23. During your stay abroad did you lose any service property or documents? If yes, list
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
                            <label>24. Have you or any member of your team encountered any difficulty or got involved in
                                any problem/trouble? Give details</label>
                            <input type="text" value="<?php echo $TrainingInfo['difficulty']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="difficulty">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <?php if(mysqli_num_rows($institutionInfo)>0) { ?>
                        <div style="border: 1px solid forestgreen;" class="table-responsive">
                            <label>25. Give details of the places/institution where you submitted your bio-data:</label>
                            <table class="table table-bordered" id="military_site_visited">
                                <tr>
                                    <th width="10%">Ser No</th>
                                    <th width="50%">Place/Name of the Institution</th>
                                    <th width="30%">Reasons/Remarks</th>
                                </tr>
                                <?php while ($institution = mysqli_fetch_assoc($institutionInfo)) { ?>
                                    <tr>
                                        <td style="background-color: white"><?php echo $institution['ser_no']; ?></td>
                                        <td style="background-color: white"><?php echo $institution['name_of_institution']; ?></td>
                                        <td style="background-color: white"><?php echo $institution['remarks']; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    <?php } ?>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>26. Have you ever suspected any member of your team of having secret understanding
                                with any foreigner? Write in details </label>
                            <input type="text" value="<?php echo $TrainingInfo['secret_understanding']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="secret_understanding">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>27. Details of the foreign intelligence network or spy if you could observe
                                them</label>
                            <input type="text" value="<?php echo $TrainingInfo['foreign_spy']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="foreign_spy">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>28. Wtite in details about the interest of foreigner on military, political, social
                                and economic situation of Bangladesh </label>
                            <input type="text" value="<?php echo $TrainingInfo['interest_of_foreigner']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="interest_of_foreigner">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>29. General impression of the foreigner and their Govt about Bangladesh (to include
                                veiws,
                                opinions, expressed by high officials/published in their media) </label>
                            <input type="text" value="<?php echo $TrainingInfo['impression_about_bd']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="impression_about_bd">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <?php if(mysqli_num_rows($milSiteInfo)>0) { ?>
                        <div style="border: 1px solid forestgreen;" class="table-responsive">
                            <label>30. Details of the military/industrial sites visited/stayed: (you may add map/photo to
                                furnish this column) </label>
                            <table class="table table-bordered" id="meeting_table">
                                <tr>
                                    <th width="10%">Ser No</th>
                                    <th width="20%">Place</th>
                                    <th width="60%">Importance (give details in case of mil installations)</th>
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

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>31. Give a pen picture about the politiucal, social, mil and security system of the
                                country:</label>
                            <input type="text" value="<?php echo $TrainingInfo['pen_picture']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="pen_picture">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <?php if(mysqli_num_rows($milMeetInfo)>0) { ?>
                        <div style="border: 1px solid forestgreen;" class="table-responsive">
                            <label>32. Details of the meeting with military and civil high officials: </label>
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
                            <label>33. Did you become a member of any foreign organization/club/association? Give
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
                            <label>34. Write important social and security problem of the visited country</label>
                            <input type="text" value="<?php echo $TrainingInfo['security_problem']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="security_problem">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>35. Latest development and progress in the military field of the country
                                visited</label>
                            <input type="text" value="<?php echo $TrainingInfo['progress_in_military']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="progress_in_military">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <?php if(mysqli_num_rows($giftInfo)>0) { ?>
                        <div style="border: 1px solid forestgreen;" class="table-responsive">
                            <label>36. Particulars of gift received from foreign nationals : (you may incl the gift itims
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
                            <label>37. a. Have you purchased any fire arms?</label>
                            <input type="text" value="<?php echo $TrainingInfo['fire_arm']; ?>" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   id="fire_arm" name="fire_arm">
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

                    <h4 class="text-center text-default">
                        <input type="checkbox" name="agreement" value="1" required> * I hereby certified that the
                        information given above are correct to the best of my knowledge
                        belief and I shall be liable of diciplinary action for giving any wrong statement.
                    </h4>

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
