<?php
include 'header_super_admin.php';

if (isset($_POST['btnUnrejectBriefingVisit'])) {
    require_once('../Briefing.php');
    $briefing = new Briefing();
    $message = $briefing->unRejectF20387($_POST);
    $message .= $briefing->unRejectUserInfo($_POST);
    header('Location: rejected_list_super_admin.php');
}

if (isset($_POST['btnUnrejectDebriefVisit'])) {
    require_once('../Briefing.php');
    $briefing = new Briefing();
    $message = $briefing->unRejectF20388($_POST);
    $message .= $briefing->unRejectUserInfo($_POST);
    header('Location: rejected_list_super_admin.php');
}

if (isset($_POST['btnUnrejectTraining'])) {
    require_once('../Briefing.php');
    $briefing = new Briefing();
    $message = $briefing->unrejectF20389($_POST);
    $message .= $briefing->unRejectUserInfo($_POST);
    header('Location: rejected_list_super_admin.php');
}

require_once('../Briefing.php');
$briefing = new Briefing();
$briefingRejectedInfo = $briefing->viewAllBriefingRejectedList();
$deBriefRejectedVisit = $briefing->viewAllDeBriefRejectedVisitingList();
$deBriefRejectedTraining = $briefing->viewAllDeBriefRejectedTrainingList();

?>

<?php if (mysqli_num_rows($briefingRejectedInfo)>0 OR mysqli_num_rows($deBriefRejectedVisit)>0 OR mysqli_num_rows($deBriefRejectedTraining)>0) {?>
    <div class="row">
        <div class="col-md-12">
            <?php if (mysqli_num_rows($briefingRejectedInfo)>0) { ?>
                <div class="well">
                    <h3 class="text-center text-primary">Rejected Briefing Requests</h3>
                    <table class="table table-hover table-striped table-bordered">
                        <tr>
                            <th class="text-center">Ser No</th>
                            <th class="text-center">BD No</th>
                            <th class="text-center">Rank</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Br/Trade</th>
                            <th class="text-center">Submit date</th>
                            <th class="text-center">Forms</th>
                            <th class="text-center">Remarks</th>
                            <th class="text-center">Action</th>
                        </tr>

                        <?php $serial_number = 1;
                        while ($briefingRejectedList = mysqli_fetch_assoc($briefingRejectedInfo)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $serial_number++; ?></td>
                                <td class="text-center"><?php echo $briefingRejectedList['bd_no']; ?></td>
                                <?php
                                $data = $briefing->viewPersonalData($briefingRejectedList['bd_no']);
                                $personalData = mysqli_fetch_assoc($data);
                                ?>
                                <td class="text-center"><?php echo $personalData['rank']; ?></td>
                                <td class="text-center"><?php echo $personalData['name']; ?></td>
                                <td class="text-center"><?php echo $personalData['br_trade']; ?></td>
                                <td class="text-center"><?php echo $date = date('d-M-Y', strtotime($briefingRejectedList['submit_date'])); ?></td>
                                <td class="text-center">
                                    <a href="../pdf_generator_files/generate_f_20387_pdf.php?bd_no=<?php echo $briefingRejectedList['bd_no']; ?>&&visit_info_id=<?php echo $briefingRejectedList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20387 </a>
                                    <a href="../pdf_generator_files/generate_f_20385_pdf.php?bd_no=<?php echo $briefingRejectedList['bd_no']; ?>&&visit_info_id=<?php echo $briefingRejectedList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20385 </a>
                                </td>
                                <td class="text-center">
                                    <h4 class="text-danger"><?php echo $briefingRejectedList['dai_remarks']; ?></h4>
                                </td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" value="<?php echo $briefingRejectedList['id']; ?>" name="id">
                                        <input type="hidden" value="<?php echo $briefingRejectedList['bd_no']; ?>" name="bd_no">
                                        <button class="btn btn-default" name="btnUnrejectBriefingVisit">Unreject</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php if (mysqli_num_rows($deBriefRejectedVisit)>0) { ?>
                <div class="well">
                    <h3 class="text-center text-primary">Rejected De-briefing(Visit/UN Mission) Requests</h3>
                    <table class="table table-hover table-striped table-bordered">
                        <tr>
                            <th class="text-center">Ser No</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Rank</th>
                            <th class="text-center">BD No</th>
                            <th class="text-center">Br/Trade</th>
                            <th class="text-center">Passport No</th>
                            <th class="text-center">Submit Date</th>
                            <th class="text-center">Forms</th>
                            <th class="text-center">Remarks</th>
                            <th class="text-center">Action</th>
                        </tr>
                        <?php $serial_number = 1;
                        while ($deBriefRejectedVisitList = mysqli_fetch_assoc($deBriefRejectedVisit)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $serial_number++; ?></td>
                                <td class="text-center"><?php //echo $deBriefRejectedVisitList['full_name']; ?></td>
                                <td class="text-center"><?php //echo $deBriefRejectedVisitList['rank']; ?></td>
                                <td class="text-center"><?php echo $deBriefRejectedVisitList['bd_no']; ?></td>
                                <td class="text-center"><?php //echo $deBriefRejectedVisitList['br_trade']; ?></td>
                                <td class="text-center"><?php //echo $date = date('d-M-Y', strtotime($deBriefRejectedVisitList['submit_date'])); ?></td>
                                <td class="text-center"><?php echo $date = date('d-M-Y', strtotime($deBriefRejectedVisitList['submit_date'])); ?></td>
                                <td class="text-center">
                                    <a href="../pdf_generator_files/generate_f_20388_pdf.php?bd_no=<?php echo $deBriefRejectedVisitList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefRejectedVisitList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20388 </a>
                                    <a href="../pdf_generator_files/generate_f_20386_pdf.php?bd_no=<?php echo $deBriefRejectedVisitList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefRejectedVisitList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20386 </a>
                                </td>
                                <td class="text-center">
                                    <h4 class="text-danger"><?php echo $deBriefRejectedVisitList['dai_remarks']; ?></h4>
                                </td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" value="<?php echo $deBriefRejectedVisitList['id']; ?>" name="id">
                                        <input type="hidden" value="<?php echo $deBriefRejectedVisitList['bd_no']; ?>" name="bd_no">
                                        <button class="btn btn-default" name="btnUnrejectDebriefVisit">Unreject</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php if (mysqli_num_rows($deBriefRejectedTraining)>0) { ?>
                <div class="well">
                    <h3 class="text-center text-primary">Rejected De-briefing(Training) Requests</h3>
                    <table class="table table-hover table-striped table-bordered">
                        <tr>
                            <th class="text-center">Ser No</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Rank</th>
                            <th class="text-center">BD No</th>
                            <th class="text-center">Br/Trade</th>
                            <th class="text-center">Submit Date</th>
                            <th class="text-center">Forms</th>
                            <th class="text-center">Remarks</th>
                            <th class="text-center">Action</th>
                        </tr>
                        <?php $serial_number = 1;
                        while ($deBriefRejectedTrainingList = mysqli_fetch_assoc($deBriefRejectedTraining)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $serial_number++; ?></td>
                                <td class="text-center"><?php //echo $deBriefRejectedTrainingList['full_name']; ?></td>
                                <td class="text-center"><?php //echo $deBriefRejectedTrainingList['rank']; ?></td>
                                <td class="text-center"><?php echo $deBriefRejectedTrainingList['bd_no']; ?></td>
                                <td class="text-center"><?php //echo $deBriefRejectedTrainingList['br_trade']; ?></td>
                                <td class="text-center"><?php echo $date = date('d-M-Y', strtotime($deBriefRejectedTrainingList['submit_date'])); ?></td>
                                <td class="text-center">
                                    <a href="../pdf_generator_files/generate_f_20389_pdf.php?bd_no=<?php echo $deBriefRejectedTrainingList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefRejectedTrainingList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20389 </a>
                                    <a href="../pdf_generator_files/generate_f_20386_pdf_with_20389.php?bd_no=<?php echo $deBriefRejectedTrainingList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefRejectedTrainingList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20386 </a>
                                </td>
                                <td class="text-center">
                                    <h4 class="text-danger"><?php echo $deBriefRejectedTrainingList['dai_remarks']; ?></h4>
                                </td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" value="<?php echo $deBriefRejectedTrainingList['id']; ?>" name="id">
                                        <input type="hidden" value="<?php echo $deBriefRejectedTrainingList['bd_no']; ?>" name="bd_no">
                                        <button class="btn btn-default" name="btnUnrejectTraining">Unreject</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>

                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } else { ?>
    <h2 class="text-center text-info">| No Rejected Requests |</h2>
<?php } ?>
</div>
<script src="../js/jquery-1.12.4.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/validator.js"></script>
</body>
</html>