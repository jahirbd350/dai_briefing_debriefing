<?php
session_start();
$message = '';

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

if (isset($_POST['act_btn_briefing'])) {
    require_once('../Briefing.php');
    $briefing = new Briefing();

    if ($_POST['dai_approval']=='approved'){
        $message = $briefing->actionF20387Done($_POST);
        $message .= $briefing->makeUserInactive($_POST);
    }
    else{
        $message = $briefing->actionF20387Done($_POST);
        $message .= $briefing->actionUserTable($_POST);
    }
    header('Location: manage_briefing.php');
}

if (isset($_POST['act_btn_debrief_visit'])) {
    require_once('../Briefing.php');
    $briefing = new Briefing();

    if ($_POST['dai_approval']=='approved'){
        $message = $briefing->actionF20388Done($_POST);
        $message .= $briefing->makeUserInactive($_POST);
    }
    else{
        $message = $briefing->actionF20388Done($_POST);
        $message .= $briefing->actionUserTable($_POST);
    }
    header('Location: manage_briefing.php');
}
if (isset($_POST['act_btn_debrief_training'])) {
    require_once('../Briefing.php');
    $briefing = new Briefing();

    if ($_POST['dai_approval']=='approved'){
        $message = $briefing->actionF20389Done($_POST);
        $message .= $briefing->makeUserInactive($_POST);
    }
    else{
        $message = $briefing->actionF20389Done($_POST);
        $message .= $briefing->actionUserTable($_POST);
    }
    header('Location: manage_briefing.php');
}

if (isset($_POST['btn_delete'])) {
    require_once('../Briefing.php');
    $briefing = new Briefing();
    $message .= $briefing->makeUserInactive($_POST);
    header('Location: manage_briefing.php');
}
if (isset($_POST['btn_reset_password'])) {
    require_once('../Briefing.php');
    $briefing = new Briefing();
    $message .= $briefing->resetUserPassword($_POST);
    header('Location: manage_briefing.php');
}

require_once('../Briefing.php');
$briefing = new Briefing();
$briefingInfo = $briefing->viewBriefingList();
$deBriefVisit = $briefing->viewDeBriefVisitingList();
$deBriefTraining = $briefing->viewDeBriefTrainingList();
$viewPasswordRequest = $briefing->viewPasswordResetRequestList();

include 'header.php';
?>

    <?php if (mysqli_num_rows($briefingInfo)>0 OR mysqli_num_rows($deBriefVisit)>0 OR mysqli_num_rows($deBriefTraining)>0) {?>
    <div class="row">
        <div class="col-md-12">
            <?php if (mysqli_num_rows($briefingInfo)>0) {?>
                <div class="well">
                    <h3 class="text-center text-primary">Pending Briefing Requests</h3>
                    <table class="table table-hover table-striped table-bordered">
                        <tr>
                            <th class="text-center">Ser No</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Rank</th>
                            <th class="text-center">BD No</th>
                            <th class="text-center">Br/Trade</th>
                            <th class="text-center">Visit Country</th>
                            <th class="text-center">BD of Group members</th>
                            <th class="text-center">Forms</th>
                            <th class="text-center">Ex-BD Lv</th>
                            <th class="text-center">Remarks</th>
                            <th class="text-center">Action</th>
                        </tr>

                        <?php $serial_number = 1;
                        while ($briefingList = mysqli_fetch_assoc($briefingInfo)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $serial_number++; ?></td>
                                <td class="text-center"><?php echo $briefingList['name']; ?></td>
                                <td class="text-center"><?php echo $briefingList['rank']; ?></td>
                                <td class="text-center"><?php echo $briefingList['bd_no']; ?></td>
                                <td class="text-center"><?php echo $briefingList['br_trade']; ?></td>
                                <td class="text-center"><?php echo $briefingList['visit_country']; ?></td>

                                <td class="text-center">
                                    <?php
                                    $groupMembers='';
                                    $group = $briefing->viewBriefingGroupData($briefingList['visit_country'],$briefingList['group_id']);
                                    while ($groupData = mysqli_fetch_assoc($group)){
                                        $groupMembers .= "BD/ ".$groupData['bd_no']."<br>";
                                    }
                                    echo $groupMembers;
                                    ?>
                                </td>

                                <?php $briefingData = $briefing->viewBriefingData($briefingList['bd_no']);
                                if (mysqli_num_rows($briefingData)>0) { $briefingData2=mysqli_fetch_assoc($briefingData)?>
                                    <td class="text-center">
                                        <a href="../pdf_generator_files/generate_f_20387_pdf.php?bd_no=<?php echo $briefingData2['bd_no']; ?>&&visit_info_id=<?php echo $briefingData2['visit_info_id']; ?>"
                                           target="_blank" class="btn btn-primary">View F-20387 </a><br>
                                        <a href="../pdf_generator_files/generate_f_20385_pdf.php?bd_no=<?php echo $briefingData2['bd_no']; ?>&&visit_info_id=<?php echo $briefingData2['visit_info_id']; ?>"
                                           target="_blank" class="btn btn-primary">View F-20385 </a>
                                    </td>
                                    <form action='' method='post'>
                                        <td class="text-center">
                                            <?php
                                            $lv_start_dt = $briefingData2['ex_bd_lv_start'];
                                            $lv_finish_dt = $briefingData2['ex_bd_lv_finish'];

                                            if($lv_start_dt != '1970-01-01' OR $lv_finish_dt != '1970-01-01'){
                                                $lv_start_dt = date('d-M-y', strtotime($briefingData2['ex_bd_lv_start']));
                                                $lv_finish_dt = date('d-M-y', strtotime($briefingData2['ex_bd_lv_finish']));
                                            }else{
                                                $lv_start_dt='';
                                                $lv_finish_dt='';
                                            }
                                            echo 'Start : '.'<br>'.$lv_start_dt.'<br>';
                                            echo 'Finish : '.'<br>'.$lv_finish_dt.'<br>';
                                            if($briefingData2['ex_bd_lv_doc'] != '') { ?>
                                                <label for="">Uploaded Doc : </label>
                                                <a href="../forms/ex_bd_lv_docs/<?php echo $briefingData2['ex_bd_lv_doc'] ?>" target="_blank">Download</a>
                                            <?php } else { ?>
                                                <label for="">No Doc Uploaded!</label>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center">
                                            <input type="hidden" value="<?php echo $briefingData2['id']; ?>" name="id">
                                            <input type="hidden" value="<?php echo $briefingList['bd_no']; ?>" name="bd_no">
                                            <label class='radio-inline'><input type='radio' required name='dai_approval' value='approved'>Accepted </label>
                                            <label class='radio-inline'><input type='radio' required name='dai_approval' value='rejected'>Not Accepted</label>
                                            <input style="margin-top: 10px;" type='text' name='dai_remarks' class='form-control' placeholder='Remarks' value="<?php echo $briefingData2['dai_remarks']; ?>" >
                                            <input style="margin-top: 10px;" type='text' name='special_instruction' class='form-control' placeholder='Special Instruction (If Any).'" >
                                        </td>

                                        <td class="text-center">
                                            <button style="margin-top: 30px;" class='btn btn-success' type='submit' name='act_btn_briefing'> Submit </button>
                                        </td>
                                    </form>
                                <?php }
                                    else { ?>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <form action="" method="post">
                                            <td class="text-center">
                                                <input type="hidden" value="<?php echo $briefingData2['id']; ?>" name="id">
                                                <input type="hidden" value="<?php echo $briefingList['bd_no']; ?>" name="bd_no">
                                                <button class='btn btn-success' type='submit' name='btn_delete'> Delete </button>
                                            </td>
                                        </form>
                                    <?php } ?>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>

            <?php if (mysqli_num_rows($deBriefVisit)>0) {?>
                <div class="well">
                    <h3 class="text-center text-primary">Pending De-Briefing Visit/UN Mission</h3>
                    <table class="table table-hover table-striped table-bordered">
                        <tr>
                            <th class="text-center">Ser No</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Rank</th>
                            <th class="text-center">BD No</th>
                            <th class="text-center">Br/Trade</th>
                            <th class="text-center">Visited Country</th>
                            <th class="text-center">BD of Group members</th>
                            <th class="text-center">Forms</th>
                            <th class="text-center">Remarks</th>
                            <th class="text-center">Action</th>
                        </tr>
                        <?php $serial_number = 1;
                        while ($deBriefVisitList = mysqli_fetch_assoc($deBriefVisit)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $serial_number++; ?></td>
                                <td class="text-center"><?php echo $deBriefVisitList['name']; ?></td>
                                <td class="text-center"><?php echo $deBriefVisitList['rank']; ?></td>
                                <td class="text-center"><?php echo $deBriefVisitList['bd_no']; ?></td>
                                <td class="text-center"><?php echo $deBriefVisitList['br_trade']; ?></td>
                                <td class="text-center"><?php echo $deBriefVisitList['visit_country']; ?></td>
                                <td class="text-center">
                                    <?php
                                    $groupMembers='';
                                    $group = $briefing->viewDeBriefVisitGroupData($deBriefVisitList['visit_country'],$deBriefVisitList['group_id']);
                                    while ($groupData = mysqli_fetch_assoc($group)){
                                        $groupMembers .= "BD/ ".$groupData['bd_no']."<br>";
                                    }
                                    echo $groupMembers;
                                    ?>
                                </td>

                                <?php $deBriefingForms = $briefing->viewDeBriefingForms($deBriefVisitList['bd_no']);
                                if (mysqli_num_rows($deBriefingForms)>0) { $deBriefingFormsInfo=mysqli_fetch_assoc($deBriefingForms)?>
                                    <td class="text-center">
                                        <a href="../pdf_generator_files/generate_f_20388_pdf.php?bd_no=<?php echo $deBriefingFormsInfo['bd_no']; ?>&&visit_info_id=<?php echo $deBriefingFormsInfo['visit_info_id']; ?>"
                                           target="_blank" class="btn btn-primary">View F-20388 </a><br>
                                        <a style="margin-top: 2px;" href="../pdf_generator_files/generate_f_20386_pdf.php?bd_no=<?php echo $deBriefingFormsInfo['bd_no']; ?>&&visit_info_id=<?php echo $deBriefingFormsInfo['visit_info_id']; ?>"
                                           target="_blank" class="btn btn-primary">View F-20386 </a>
                                    </td>
                                    <form action='' method='post'>
                                        <td class="text-center">
                                            <input type="hidden" value="<?php echo $deBriefingFormsInfo['id']; ?>" name="id">
                                            <input type="hidden" value="<?php echo $deBriefingFormsInfo['bd_no']; ?>" name="bd_no">
                                            <label class='radio-inline'><input type='radio' required name='dai_approval' value='approved'>Accepted </label>
                                            <label class='radio-inline'><input type='radio' required name='dai_approval' value='rejected'>Not Accepted</label>
                                            <input style="margin-top: 10px" type='text' name='dai_remarks' class='form-control' placeholder='Remarks'>
                                        </td>
                                        <td class="text-center">
                                            <button style="margin-top: 30px;" class='btn btn-success' type='submit' name='act_btn_debrief_visit'> Submit </button>
                                        </td>
                                    </form>
                                <?php }
                                else { ?>
                                    <td></td>
                                    <td></td>
                                    <form action="" method="post">
                                        <td class="text-center">
                                            <input type="hidden" value="<?php echo $deBriefVisitList['id']; ?>" name="id">
                                            <input type="hidden" value="<?php echo $deBriefVisitList['bd_no']; ?>" name="bd_no">
                                            <button class='btn btn-success' type='submit' name='btn_delete'> Delete </button>
                                        </td>
                                    </form>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>

            <?php if (mysqli_num_rows($deBriefTraining)>0) {?>
                <div class="well">
                    <h3 class="text-center text-primary">Pending De-Briefing Training</h3>
                    <table class="table table-hover table-striped table-bordered">
                        <tr>
                            <th class="text-center">Ser No</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Rank</th>
                            <th class="text-center">BD No</th>
                            <th class="text-center">Br/Trade</th>
                            <th class="text-center">Visited Country</th>
                            <th class="text-center">BD of Group Members</th>
                            <th class="text-center">Forms</th>
                            <th class="text-center">Remarks</th>
                            <th class="text-center">Action</th>
                        </tr>
                        <?php $serial_number = 1;
                        while ($deBriefTrainingList = mysqli_fetch_assoc($deBriefTraining)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $serial_number++; ?></td>
                                <td class="text-center"><?php echo $deBriefTrainingList['name']; ?></td>
                                <td class="text-center"><?php echo $deBriefTrainingList['rank']; ?></td>
                                <td class="text-center"><?php echo $deBriefTrainingList['bd_no']; ?></td>
                                <td class="text-center"><?php echo $deBriefTrainingList['br_trade']; ?></td>
                                <td class="text-center"><?php echo $deBriefTrainingList['visit_country']; ?></td>
                                <td class="text-center">
                                    <?php
                                    $groupMembers='';
                                    $group = $briefing->viewDeBriefTrainingGroupData($deBriefTrainingList['visit_country'],$deBriefTrainingList['group_id']);
                                    while ($groupData = mysqli_fetch_assoc($group)){
                                        $groupMembers .= "BD/ ".$groupData['bd_no']."<br>";
                                    }
                                    echo $groupMembers;
                                    ?>
                                </td>

                                <?php $deBriefingTrainingForms = $briefing->viewDeBriefingTrainingForms($deBriefTrainingList['bd_no']);
                                if (mysqli_num_rows($deBriefingTrainingForms)>0) { $deBriefingTrainingFormsInfo=mysqli_fetch_assoc($deBriefingTrainingForms)?>
                                    <td class="text-center">
                                        <a href="../pdf_generator_files/generate_f_20389_pdf.php?bd_no=<?php echo $deBriefingTrainingFormsInfo['bd_no']; ?>&&visit_info_id=<?php echo $deBriefingTrainingFormsInfo['visit_info_id']; ?>"
                                           target="_blank" class="btn btn-primary">View F-20389 </a><br>
                                        <a style="margin-top: 2px;" href="../pdf_generator_files/generate_f_20386_pdf_with_20389.php?bd_no=<?php echo $deBriefingTrainingFormsInfo['bd_no']; ?>&&visit_info_id=<?php echo $deBriefingTrainingFormsInfo['visit_info_id']; ?>"
                                           target="_blank" class="btn btn-primary">View F-20386 </a>
                                    </td>
                                    <form action='' method='post'>
                                        <td class="text-center">
                                            <input type="hidden" value="<?php echo $deBriefingTrainingFormsInfo['id']; ?>" name="id">
                                            <input type="hidden" value="<?php echo $deBriefingTrainingFormsInfo['bd_no']; ?>" name="bd_no">
                                            <label class='radio-inline'><input type='radio' required name='dai_approval' value='approved'>Accepted </label>
                                            <label class='radio-inline'><input type='radio' required name='dai_approval' value='rejected'>Not Accepted</label>
                                            <input style="margin-top: 10px" type='text' name='dai_remarks' class='form-control' placeholder='Remarks'>
                                        </td>
                                        <td class="text-center">
                                            <button style="margin-top: 30px;" class='btn btn-success' type='submit' name='act_btn_debrief_training'> Submit </button>
                                        </td>
                                    </form>
                                <?php }
                                else { ?>
                                    <td></td>
                                    <td></td>
                                    <form action="" method="post">
                                        <td class="text-center">
                                            <input type="hidden" value="<?php echo $deBriefTrainingList['id']; ?>" name="id">
                                            <input type="hidden" value="<?php echo $deBriefTrainingList['bd_no']; ?>" name="bd_no">
                                            <button class='btn btn-success' type='submit' name='btn_delete'> Delete </button>
                                        </td>
                                    </form>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } else { ?>
        <h2 class="text-center text-info">| No Pending Briefing/De-briefing Requests |</h2>
<?php } ?>

<!-- Display Password Reset Request -->
<?php if (mysqli_num_rows($viewPasswordRequest)>0) {?>
    <div class="well">
        <h3 class="text-center text-primary">Password Reset Requests</h3>
        <table class="table table-hover table-striped table-bordered">
            <tr>
                <th class="text-center">Ser No</th>
                <th class="text-center">Name</th>
                <th class="text-center">Rank</th>
                <th class="text-center">BD No</th>
                <th class="text-center">Br/Trade</th>
                <th class="text-center">Remarks</th>
                <th class="text-center">Action</th>
            </tr>
            <?php $serial_number = 1;
            while ($viewPasswordRequestList = mysqli_fetch_assoc($viewPasswordRequest)) { ?>
                <tr>
                    <td class="text-center"><?php echo $serial_number++; ?></td>
                    <td class="text-center"><?php echo $viewPasswordRequestList['name']; ?></td>
                    <td class="text-center"><?php echo $viewPasswordRequestList['rank']; ?></td>
                    <td class="text-center"><?php echo $viewPasswordRequestList['bd_no']; ?></td>
                    <td class="text-center"><?php echo $viewPasswordRequestList['br_trade']; ?></td>
                    <td></td>
                    <form action="" method="post">
                        <td class="text-center">
                            <input type="hidden" value="<?php echo $viewPasswordRequestList['id']; ?>" name="id">
                            <input type="hidden" value="<?php echo $viewPasswordRequestList['bd_no']; ?>" name="bd_no">
                            <button class='btn btn-danger' type='submit' name='btn_reset_password'> Reset Password </button>
                        </td>
                    </form>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php } ?>

</div>

<script src="../js/jquery-1.12.4.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/validator.js"></script>
</body>
</html>
