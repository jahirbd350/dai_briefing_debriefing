<?php
session_start();

include_once('../../config.php');

if (isset($_POST["club_ser_no"])) {
    $club_ser_no = $_POST["club_ser_no"];
    $club_name = $_POST["club_name"];
    $club_remarks = $_POST["club_remarks"];
    $query = '';
    for ($count = 0; $count < count($club_ser_no); $count++) {
        $club_ser_no_clean = mysqli_real_escape_string($link, $club_ser_no[$count]);
        $club_name_clean = mysqli_real_escape_string($link, $club_name[$count]);
        $club_remarks_clean = mysqli_real_escape_string($link, $club_remarks[$count]);
        if ($club_ser_no_clean != '') {
            $query .= '
       INSERT INTO debrief_20389_club_membership(bd_no,visit_info_id,ser_no, name_of_club, remarks) 
       VALUES("' . $_SESSION['bd_no'] . '","' . $_SESSION['visitId'] . '","' . $club_ser_no_clean . '", "' . $club_name_clean . '", "' . $club_remarks_clean . '"); 
       ';
        }
    }

    if ($query != '') {
        if (mysqli_multi_query($link, $query)) {
            //echo 'Transit Info Inserted Successfully';
        } else {
            echo 'Error';
        }
    } else {
        echo 'Transit Info All Fields are Required';
    }
}

?>