<?php
session_start();

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

require_once('../Briefing.php');
$briefing = new Briefing();
$briefingInfo = $briefing->viewIndividualBriefingList();
$briefingRejectedInfo = $briefing->viewIndividualBriefingRejectedList();

$deBriefVisit = $briefing->viewIndividualDeBriefVisitingList();
$deBriefRejectedVisit = $briefing->viewIndividualDeBriefRejectedVisitingList();

$deBriefTraining = $briefing->viewIndividualDeBriefTrainingList();
$deBriefRejectedTraining = $briefing->viewIndividualDeBriefRejectedTrainingList();

$individualBriefingHistory = $briefing->viewIndividualBriefingHistory();
$individualDeBriefVisitHistory = $briefing->viewIndividualDeBriefVisitingHistory();
$individualDeBriefTrainingHistory = $briefing->viewIndividualDeBriefTrainingHistory();
include('f_header.php');
?>
    <div class="row">
        <div class="col-md-10 col-md-offset-1 well">
            <h4 class="text-center text-success bg-info">
                <?php if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                };
                unset($_SESSION['message']);
                ?>
            </h4>
            <h3 class="text-center text-default"><b>Welcome to Directorate of Air Intelligence <br> Briefing &
                    Debriefing</b></h3>
            <hr>

            <div class="row col-md-12">
                <table class="table table-bordered" >
                    <tr>
                        <th><h4 class="text-info text-center">Briefing Form</h4></th>
                        <th><h4 class="text-info text-center">De-Briefing Visit/ UN Mission Form</h4></th>
                        <th><h4 class="text-info text-center">De-Briefing Training Form</h4></th>
                    </tr>
                    <tr>
                        <td class="text-center"><a class="btn btn-primary" href="f_20387.php" style="font-size: 20px">F-20387</a></td>
                        <td class="text-center"><a class="btn btn-primary" href="f_20388.php" style="font-size: 20px">F-20388</a></td>
                        <td class="text-center"><a class="btn btn-primary" href="f_20389.php" style="font-size: 20px">F-20389</a></td>
                    </tr>
                </table>


                <!--<div class="col-md-3">
                    <a class="btn btn-primary" href="f_20387.php" style="font-size: 20px">Briefing form<br>F-20387</a>
                </div>
                <div class="col-md-5">
                    <a class="btn btn-primary" href="f_20388.php" style="font-size: 20px">De-Briefing Form<br>for<br>Visit/UN Mission<br>F-20388</a>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-primary" href="f_20389.php" style="font-size: 20px">De-Briefing Form<br>for<br>Training<br>F-20389</a>
                </div>-->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <?php if (mysqli_num_rows($briefingInfo)>0 OR mysqli_num_rows($briefingRejectedInfo)>0 OR mysqli_num_rows($deBriefVisit)>0 OR mysqli_num_rows($deBriefRejectedVisit)>0 OR mysqli_num_rows($deBriefTraining)>0 OR mysqli_num_rows($deBriefRejectedTraining)>0) {?>
                <div class="well">
                    <h3 class="text-center text-primary">Pending Briefing/De-Briefing Request</h3>
                    <table class="table table-hover table-striped table-bordered">
                        <tr>
                            <th class="text-center">Ser No</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Rank</th>
                            <th class="text-center">BD No</th>
                            <th class="text-center">Br/Trade</th>
                            <th class="text-center">Submit date</th>
                            <th class="text-center">Forms</th>
                            <th class="text-center">Remarks</th>
                            <th class="text-center">Action</th>
                        </tr>
                        <?php $serial_number = 1;
                        while ($briefingList = mysqli_fetch_assoc($briefingInfo)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $serial_number++; ?></td>
                                <td class="text-center"><?php echo $_SESSION['name']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['rank']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['bd_no']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['br_trade']; ?></td>
                                <td class="text-center"><?php echo $date = date('d-M-Y', strtotime($briefingList['submit_date'])); ?></td>
                                <td class="text-center">
                                    <a href="../pdf_generator_files/generate_f_20387_pdf.php?bd_no=<?php echo $briefingList['bd_no']; ?>&&visit_info_id=<?php echo $briefingList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20387 </a>
                                    <a href="../pdf_generator_files/generate_f_20385_pdf.php?bd_no=<?php echo $briefingList['bd_no']; ?>&&visit_info_id=<?php echo $briefingList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20385 </a>
                                    <!--<a href="?id=<?php /*echo $briefingInfo['user_id'];*/ ?>&deletestatus=delete" class="btn btn-danger">Delete </a>-->
                                </td>
                                <td class="text-center"></td>
                                <td></td>
                            </tr>
                        <?php } ?>
                        <?php $serial_number = 1;
                        while ($deBriefVisitList = mysqli_fetch_assoc($deBriefVisit)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $serial_number++; ?></td>
                                <td class="text-center"><?php echo $_SESSION['name']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['rank']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['bd_no']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['br_trade']; ?></td>
                                <td class="text-center"><?php $date = date('d-M-Y', strtotime($deBriefVisitList['submit_date']));
                                    echo $date; ?></td>
                                <td class="text-center">
                                    <a href="../pdf_generator_files/generate_f_20388_pdf.php?bd_no=<?php echo $deBriefVisitList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefVisitList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20388 </a>
                                    <a href="../pdf_generator_files/generate_f_20386_pdf.php?bd_no=<?php echo $deBriefVisitList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefVisitList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20386 </a>
                                </td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                            </tr>
                        <?php } ?>

                        <?php $serial_number = 1;
                        while ($deBriefTrainingList = mysqli_fetch_assoc($deBriefTraining)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $serial_number++; ?></td>
                                <td class="text-center"><?php echo $_SESSION['name']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['rank']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['bd_no']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['br_trade']; ?></td>
                                <td class="text-center"><?php $date = date('d-M-Y', strtotime($deBriefTrainingList['submit_date']));
                                    echo $date; ?></td>
                                <td class="text-center">
                                    <a href="../pdf_generator_files/generate_f_20389_pdf.php?bd_no=<?php echo $deBriefTrainingList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefTrainingList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20389 </a>
                                    <a href="../pdf_generator_files/generate_f_20386_pdf_with_20389.php?bd_no=<?php echo $deBriefTrainingList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefTrainingList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20386 </a>
                                </td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                            </tr>
                        <?php } ?>

                        <?php $serial_number = 1;
                        while ($briefingRejectedList = mysqli_fetch_assoc($briefingRejectedInfo)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $serial_number++; ?></td>
                                <td class="text-center"><?php echo $_SESSION['name']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['rank']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['bd_no']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['br_trade']; ?></td>
                                <td class="text-center"><?php echo $date = date('d-M-Y', strtotime($briefingRejectedList['submit_date'])); ?></td>
                                <td class="text-center">
                                    <a href="../pdf_generator_files/generate_f_20387_pdf.php?bd_no=<?php echo $briefingRejectedList['bd_no']; ?>&&visit_info_id=<?php echo $briefingRejectedList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20387 </a>
                                    <a href="../pdf_generator_files/generate_f_20385_pdf.php?bd_no=<?php echo $briefingRejectedList['bd_no']; ?>&&visit_info_id=<?php echo $briefingRejectedList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20385 </a>
                                    <!--<a href="?id=<?php /*echo $briefingInfo['user_id'];*/ ?>&deletestatus=delete" class="btn btn-danger">Delete </a>-->
                                </td>
                                <td class="text-center">
                                    <h4 class="text-danger"><?php echo $briefingRejectedList['dai_remarks']; ?></h4>
                                </td>
                                <td><a href="f_20387_update.php?bd_no=<?php echo $briefingRejectedList['bd_no']; ?>&&visit_info_id=<?php echo $briefingRejectedList['visit_info_id']; ?>"><button class="btn btn-default">Update</button></a></td>
                            </tr>
                        <?php } ?>

                        <?php $serial_number = 1;
                        while ($deBriefRejectedVisitList = mysqli_fetch_assoc($deBriefRejectedVisit)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $serial_number++; ?></td>
                                <td class="text-center"><?php echo $_SESSION['name']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['rank']; ?></td>
                                <td class="text-center"><?php echo $deBriefRejectedVisitList['bd_no']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['br_trade']; ?></td>
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
                                <td><a href="f_20388_update.php?bd_no=<?php echo $deBriefRejectedVisitList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefRejectedVisitList['visit_info_id']; ?>"><button class="btn btn-default">Update</button></a></td>
                            </tr>
                        <?php } ?>

                        <?php $serial_number = 1;
                        while ($deBriefRejectedTrainingList = mysqli_fetch_assoc($deBriefRejectedTraining)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $serial_number++; ?></td>
                                <td class="text-center"><?php echo $_SESSION['name']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['rank']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['bd_no']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['br_trade']; ?></td>
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
                                <td><a href="f_20389_update.php?bd_no=<?php echo $deBriefRejectedTrainingList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefRejectedTrainingList['visit_info_id']; ?>"><button class="btn btn-default">Update</button></a></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php if (mysqli_num_rows($individualBriefingHistory)>0) {?>
                <div class="well">
                    <h3 class="text-center text-primary">Briefing History</h3>
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
                        </tr>

                        <?php $serial_number = 1;
                        while ($briefingList = mysqli_fetch_assoc($individualBriefingHistory)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $serial_number++; ?></td>
                                <td class="text-center"><?php echo $_SESSION['name']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['rank']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['bd_no']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['br_trade']; ?></td>
                                <td class="text-center"><?php echo $date = date('d-M-Y', strtotime($briefingList['submit_date'])); ?></td>
                                <td class="text-center">
                                    <a href="../pdf_generator_files/generate_f_20387_pdf.php?bd_no=<?php echo $briefingList['bd_no']; ?>&&visit_info_id=<?php echo $briefingList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20387 </a>
                                    <a href="../pdf_generator_files/generate_f_20385_pdf.php?bd_no=<?php echo $briefingList['bd_no']; ?>&&visit_info_id=<?php echo $briefingList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20385 </a>
                                    <!--<a href="?id=<?php /*echo $briefingInfo['user_id'];*/ ?>&deletestatus=delete" class="btn btn-danger">Delete </a>-->
                                </td>
                                <td class="text-center"><h5>Pl come to Dte AI for<br> further nec corr.</h5></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>

            <?php if (mysqli_num_rows($individualDeBriefVisitHistory)>0) {?>
                <div class="well">
                    <h3 class="text-center text-primary">De-Briefing(Visit/UN Mission) History</h3>
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
                        </tr>
                        <?php $serial_number = 1;
                        while ($deBriefVisitList = mysqli_fetch_assoc($individualDeBriefVisitHistory)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $serial_number++; ?></td>
                                <td class="text-center"><?php echo $_SESSION['name']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['rank']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['bd_no']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['br_trade']; ?></td>
                                <td class="text-center"><?php $date = date('d-M-Y', strtotime($deBriefVisitList['submit_date']));
                                    echo $date; ?></td>
                                <td class="text-center">
                                    <a href="../pdf_generator_files/generate_f_20388_pdf.php?bd_no=<?php echo $deBriefVisitList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefVisitList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20388 </a>
                                    <a href="../pdf_generator_files/generate_f_20386_pdf.php?bd_no=<?php echo $deBriefVisitList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefVisitList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20386 </a>
                                </td>
                                <td class="text-center"><h5>Pl come to Dte AI for<br> further nec corr.</h5></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>

            <?php if (mysqli_num_rows($individualDeBriefTrainingHistory)>0) {?>
                <div class="well">
                    <h3 class="text-center text-primary">De-Briefing(Training) History</h3>
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
                        </tr>
                        <?php $serial_number = 1;
                        while ($deBriefTrainingList = mysqli_fetch_assoc($individualDeBriefTrainingHistory)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $serial_number++; ?></td>
                                <td class="text-center"><?php echo $_SESSION['name']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['rank']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['bd_no']; ?></td>
                                <td class="text-center"><?php echo $_SESSION['br_trade']; ?></td>
                                <td class="text-center"><?php $date = date('d-M-Y', strtotime($deBriefTrainingList['submit_date']));
                                    echo $date; ?></td>
                                <td class="text-center">
                                    <a href="../pdf_generator_files/generate_f_20389_pdf.php?bd_no=<?php echo $deBriefTrainingList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefTrainingList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20389 </a>
                                    <a href="../pdf_generator_files/generate_f_20386_pdf_with_20389.php?bd_no=<?php echo $deBriefTrainingList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefTrainingList['visit_info_id']; ?>"
                                       target="_blank" class="btn btn-primary">View F-20386 </a>
                                    <!--<a href="?id=<?php /*echo $briefingInfo['user_id'];*/ ?>&deletestatus=delete" class="btn btn-danger">Delete </a>-->
                                </td>
                                <td class="text-center">
                                    <h5>Pl come to Dte AI for<br> further nec corr.</h5>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script src="../js/jquery-1.12.4.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/validator.js"></script>
</body>
</html>