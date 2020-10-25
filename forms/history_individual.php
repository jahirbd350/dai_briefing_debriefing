<?php
session_start();
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
require_once('Briefing.php');
$briefing = new Briefing();
$briefingInfo = $briefing->viewIndividualBriefingList();
$briefing = new Briefing();
$deBriefVisit = $briefing->viewIndividualBriefingHistory();
$briefing = new Briefing();
$deBriefTraining = $briefing->viewIndividualDeBriefVisitingList();

$briefing = new Briefing();
$individualBriefingHistory = $briefing->viewIndividualBriefingHistory();
$briefing = new Briefing();
$individualDeBriefVisitHistory = $briefing->viewIndividualDeBriefVisitingHistory();
$briefing = new Briefing();
$individualDeBriefTrainingHistory = $briefing->viewIndividualDeBriefTrainingHistory();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Briefing</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script>
        $('#header .navbar-nav a').on('click', function () {
            $('#header .navbar-nav').find('li.active').removeClass('active');
            $(this).parent('li').addClass('active');
        });
    </script>
</head>
<body>
<div class="container-fluid">
    <nav class="navbar navbar-default">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="history_individual.php">Homepage</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"
                           style="text-transform: uppercase;"><?php echo "Welcome " . $_SESSION['name']; ?> <span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="?status=logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <h4 class="text-center text-success bg-info">
                    <?php if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    };
                    unset($_SESSION['message']);
                    ?>
                </h4>
                <h3 class="text-center text-primary">Pending Briefing/De-Briefing List</h3>
                <table class="table table-hover table-striped table-bordered">
                    <tr>
                        <th class="text-center">Ser No</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Rank</th>
                        <th class="text-center">BD No</th>
                        <th class="text-center">Br/Trade</th>
                        <th class="text-center">Passport No</th>
                        <th class="text-center">Submit date</th>
                        <th class="text-center">Forms</th>
                        <th class="text-center">Remarks</th>
                    </tr>

                    <?php $serial_number = 1;
                    while ($briefingList = mysqli_fetch_assoc($briefingInfo)) { ?>
                        <tr>
                            <td class="text-center"><?php echo $serial_number++; ?></td>
                            <td class="text-center"><?php echo $briefingList['full_name']; ?></td>
                            <td class="text-center"><?php echo $briefingList['rank']; ?></td>
                            <td class="text-center"><?php echo $briefingList['bd_no']; ?></td>
                            <td class="text-center"><?php echo $briefingList['br_trade']; ?></td>
                            <td class="text-center"><?php echo $briefingList['passport_no']; ?></td>
                            <td class="text-center"><?php $date=date('d-M-Y',strtotime($briefingList['submit_date'])); echo $date;?></td>
                            <td class="text-center">
                                <a href="../pdf_generator_files/generate_f_20387_pdf.php?bd_no=<?php echo $briefingList['bd_no']; ?>&&visit_info_id=<?php echo $briefingList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View F-20387 </a>
                                <a href="../pdf_generator_files/generate_f_20385_pdf.php?bd_no=<?php echo $briefingList['bd_no']; ?>&&visit_info_id=<?php echo $briefingList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View F-20385 </a>
                            </td>
                            <td class="text-center">
                                <form action="" method="POST">
                                    <input type="hidden" value="<?php echo $briefingList['id']; ?>" name="id">
                                    <input type="hidden" value="1" name="action">
                                    <!--<input class="btn btn-info" type="submit" value="Done" name="act_btn_briefing">-->
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php $serial_number = 1;
                    while ($deBriefVisitList = mysqli_fetch_assoc($deBriefVisit)) { ?>
                        <tr>
                            <td class="text-center"><?php echo $serial_number++; ?></td>
                            <td class="text-center"><?php echo $deBriefVisitList['full_name']; ?></td>
                            <td class="text-center"><?php echo $deBriefVisitList['rank']; ?></td>
                            <td class="text-center"><?php echo $deBriefVisitList['bd_no']; ?></td>
                            <td class="text-center"><?php echo $deBriefVisitList['br_trade']; ?></td>
                            <td class="text-center"></td>
                            <td class="text-center"><?php $date=date('d-M-Y',strtotime($deBriefVisitList['submit_date'])); echo $date;?></td>
                            <td class="text-center">
                                <a href="../pdf_generator_files/generate_f_20388_pdf.php?bd_no=<?php echo $deBriefVisitList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefVisitList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View F-20388 </a>
                                <a href="../pdf_generator_files/generate_f_20386_pdf.php?bd_no=<?php echo $deBriefVisitList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefVisitList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View F-20386 </a>
                                <!--<a href="?id=<?php /*echo $briefingInfo['user_id'];*/ ?>&deletestatus=delete" class="btn btn-danger">Delete </a>-->
                            </td>
                            <td class="text-center">
                                <form action="" method="POST">
                                    <input type="hidden" value="<?php echo $deBriefVisitList['id']; ?>" name="id">
                                    <input type="hidden" value="1" name="action">
                                    <!--<input class="btn btn-info" type="submit" value="Done" name="act_btn_debrief_visit">-->
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php $serial_number = 1;
                    while ($deBriefTrainingList = mysqli_fetch_assoc($deBriefTraining)) { ?>
                        <tr>
                            <td class="text-center"><?php echo $serial_number++; ?></td>
                            <td class="text-center"><?php echo $deBriefTrainingList['full_name']; ?></td>
                            <td class="text-center"><?php echo $deBriefTrainingList['rank']; ?></td>
                            <td class="text-center"><?php echo $deBriefTrainingList['bd_no']; ?></td>
                            <td class="text-center"><?php echo $deBriefTrainingList['br_trade']; ?></td>
                            <td class="text-center"></td>
                            <td class="text-center"><?php $date=date('d-M-Y',strtotime($deBriefTrainingList['submit_date'])); echo $date;?></td>
                            <td class="text-center">
                                <a href="../pdf_generator_files/generate_f_20389_pdf.php?bd_no=<?php echo $deBriefTrainingList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefTrainingList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View F-20389 </a>
                                <a href="../pdf_generator_files/generate_f_20386_pdf.php?bd_no=<?php echo $deBriefTrainingList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefTrainingList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View F-20386 </a>
                                <!--<a href="?id=<?php /*echo $briefingInfo['user_id'];*/ ?>&deletestatus=delete" class="btn btn-danger">Delete </a>-->
                            </td>
                            <td class="text-center">
                                <form action="" method="POST">
                                    <input type="hidden" value="<?php echo $deBriefTrainingList['id']; ?>" name="id">
                                    <input type="hidden" value="1" name="action">
                                    <!--<input class="btn btn-info" type="submit" value="Done" name="act_btn_debrief_training">-->
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <h3 class="text-center text-primary">Briefing History</h3>
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
                    </tr>

                    <?php $serial_number = 1;
                    while ($briefingList = mysqli_fetch_assoc($individualBriefingHistory)) { ?>
                        <tr>
                            <td class="text-center"><?php echo $serial_number++; ?></td>
                            <td class="text-center"><?php echo $briefingList['full_name']; ?></td>
                            <td class="text-center"><?php echo $briefingList['rank']; ?></td>
                            <td class="text-center"><?php echo $briefingList['bd_no']; ?></td>
                            <td class="text-center"><?php echo $briefingList['br_trade']; ?></td>
                            <td class="text-center"><?php echo $briefingList['passport_no']; ?></td>
                            <td class="text-center"><?php $date=date('d-M-Y',strtotime($briefingList['submit_date'])); echo $date;?></td>
                            <td class="text-center">
                                <a href="../pdf_generator_files/generate_f_20387_pdf.php?bd_no=<?php echo $briefingList['bd_no']; ?>&&visit_info_id=<?php echo $briefingList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View F-20387 </a>
                                <a href="pdf_generator_files/generate_instruction_pdf.php?bd_no=<?php echo $briefingList['bd_no']; ?>&&visit_info_id=<?php echo $briefingList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View Gen Instruction </a>
                                <a href="../pdf_generator_files/generate_f_20385_pdf.php?bd_no=<?php echo $briefingList['bd_no']; ?>&&visit_info_id=<?php echo $briefingList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View F-20385 </a>
                                <!--<a href="?id=<?php /*echo $briefingInfo['user_id'];*/ ?>&deletestatus=delete" class="btn btn-danger">Delete </a>-->
                            </td>
                            <td class="text-center">
                                <form action="" method="POST">
                                    <input type="hidden" value="<?php echo $briefingList['id']; ?>" name="id">
                                    <input type="hidden" value="1" name="action">
                                    <!--<input class="btn btn-info" type="submit" value="Done" name="act_btn_briefing">-->
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

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
                            <td class="text-center"><?php echo $deBriefVisitList['full_name']; ?></td>
                            <td class="text-center"><?php echo $deBriefVisitList['rank']; ?></td>
                            <td class="text-center"><?php echo $deBriefVisitList['bd_no']; ?></td>
                            <td class="text-center"><?php echo $deBriefVisitList['br_trade']; ?></td>
                            <td class="text-center"><?php $date=date('d-M-Y',strtotime($deBriefVisitList['submit_date'])); echo $date;?></td>
                            <td class="text-center">
                                <a href="../pdf_generator_files/generate_f_20388_pdf.php?bd_no=<?php echo $deBriefVisitList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefVisitList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View F-20388 </a>
                                <a href="../pdf_generator_files/generate_f_20386_pdf.php?bd_no=<?php echo $deBriefVisitList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefVisitList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View F-20386 </a>
                                <!--<a href="?id=<?php /*echo $briefingInfo['user_id'];*/ ?>&deletestatus=delete" class="btn btn-danger">Delete </a>-->
                            </td>
                            <td class="text-center">
                                <form action="" method="POST">
                                    <input type="hidden" value="<?php echo $deBriefVisitList['id']; ?>" name="id">
                                    <input type="hidden" value="1" name="action">
                                    <!--<input class="btn btn-info" type="submit" value="Done" name="act_btn_debrief_visit">-->
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

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
                            <td class="text-center"><?php echo $deBriefTrainingList['full_name']; ?></td>
                            <td class="text-center"><?php echo $deBriefTrainingList['rank']; ?></td>
                            <td class="text-center"><?php echo $deBriefTrainingList['bd_no']; ?></td>
                            <td class="text-center"><?php echo $deBriefTrainingList['br_trade']; ?></td>
                            <td class="text-center"><?php $date=date('d-M-Y',strtotime($deBriefTrainingList['submit_date'])); echo $date;?></td>
                            <td class="text-center">
                                <a href="../pdf_generator_files/generate_f_20389_pdf.php?bd_no=<?php echo $deBriefTrainingList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefTrainingList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View F-20389 </a>
                                <a href="../pdf_generator_files/generate_f_20386_pdf.php?bd_no=<?php echo $deBriefTrainingList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefTrainingList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View F-20386 </a>
                                <!--<a href="?id=<?php /*echo $briefingInfo['user_id'];*/ ?>&deletestatus=delete" class="btn btn-danger">Delete </a>-->
                            </td>
                            <td class="text-center">
                                <form action="" method="POST">
                                    <input type="hidden" value="<?php echo $deBriefTrainingList['id']; ?>" name="id">
                                    <input type="hidden" value="1" name="action">
                                    <!--<input class="btn btn-info" type="submit" value="Done" name="act_btn_debrief_training">-->
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="../js/jquery-1.12.4.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/validator.js"></script>
</body>
</html>
