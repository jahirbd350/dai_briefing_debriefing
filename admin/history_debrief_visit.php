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

require_once('../Briefing.php');
$briefing = new Briefing();
$deBriefVisit = $briefing->viewDeBriefVisitingHistory();

//Pagination code start here
$limit = isset($_POST["limit-records"]) ? $_POST["limit-records"] : 50;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;
$briefing = new Briefing();
$deBriefVisitPagination = $briefing->deBriefVisitPagination($limit,$start);

$totalRecord = mysqli_num_rows($deBriefVisit);
$pages = ceil( $totalRecord / $limit );

$Previous = $page - 1;
$Next = $page + 1;
//Pagination code end here
include 'header.php';
?>

    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <h3 class="text-center text-primary">De-Briefing Visit History</h3>
                <table class="table table-hover table-striped table-bordered">
                    <tr>
                        <th class="text-center">Ser No</th>
                        <th class="text-center">BD No</th>
                        <th class="text-center">Rank</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Br/Trade</th>
                        <th class="text-center">Forms</th>
                        <th class="text-center">Action</th>
                    </tr>
                    <?php $serial_number = $start+1;
                    while ($deBriefVisitList = mysqli_fetch_assoc($deBriefVisitPagination)) { ?>
                        <tr>
                            <td class="text-center"><?php echo $serial_number++; ?></td>
                            <td class="text-center"><?php echo $deBriefVisitList['bd_no']; ?></td>
                            <?php
                                $data = $briefing->viewPersonalData($deBriefVisitList['bd_no']);
                                $personalData = mysqli_fetch_assoc($data);
                            ?>
                            <td class="text-center"><?php echo $personalData['rank']; ?></td>
                            <td class="text-center"><?php echo $personalData['name']; ?></td>
                            <td class="text-center"><?php echo $personalData['br_trade']; ?></td>
                            <td class="text-center">
                                <a href="../pdf_generator_files/generate_f_20388_pdf.php?bd_no=<?php echo $deBriefVisitList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefVisitList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View F-20388 </a>
                                <a href="../pdf_generator_files/generate_f_20386_pdf.php?bd_no=<?php echo $deBriefVisitList['bd_no']; ?>&&visit_info_id=<?php echo $deBriefVisitList['visit_info_id']; ?>"
                                   target="_blank" class="btn btn-primary">View F-20386 </a>
                                <!--<a href="?id=<?php /*echo $briefingInfo['user_id'];*/ ?>&deletestatus=delete" class="btn btn-danger">Delete </a>-->
                            </td>
                            <td class="text-center">
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination Code Start here -->
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8 col-md-offset-2">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li>
                            <?php if ($page > 1) { ?>
                                <a href="history_debrief_visit.php?page=<?php echo $Previous; ?>">&laquo; Previous</a>
                            <?php } ?>
                        </li>
                        <li>
                            <a href="history_debrief_visit.php?page=1">First page</a>
                        </li>
                        <li>
                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                <a href="history_debrief_visit.php?page=<?php echo $i; ?>"><?php echo '<b>' . $i . '</b>'; ?></a>
                            <?php } ?>
                        </li>
                        <li>
                            <a href="history_debrief_visit.php?page=<?php echo $pages; ?>">Last page</a>
                        </li>
                        <li>
                            <?php if ($page < $pages) { ?>
                                <a href="history_debrief_visit.php?page=<?php echo $Next; ?>">Next &raquo;</a>
                            <?php } ?>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!--<div class="col-md-2 text-center" style="margin-top: 20px; " >
            <form id="recordLimit" method="post" action="#">
                <select name="limit-records" id="limit-records">
                    <option disabled="disabled" selected="selected">---Limit Records---</option>
                    <?php /*foreach([10,50,100] as $limit): */?>
                        <option <?php /*if( isset($_POST["limit-records"]) && $_POST["limit-records"] == $limit) echo "selected" */?> value="<?/*= $limit; */?>"><?/*= $limit; */?></option>
                    <?php /*endforeach; */?>
                </select>
            </form>
        </div>-->
    </div>
    <!-- Pagination Code End here -->
</div>


<script src="../js/jquery-1.12.4.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/validator.js"></script>
</body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        $("#limit-records").change(function(){
            $('#recordLimit').submit();
        })
    })
</script>
