<?php
session_start();

include_once('../../config.php');

if (isset($_POST["family_ser_no"])) {
    $family_ser_no = $_POST["family_ser_no"];
    $family_member_name = $_POST["family_member_name"];
    $family_relation = $_POST["family_relation"];
    $family_date_of_departure = $_POST["family_date_of_departure"];
    $query = '';
    for ($count = 0; $count < count($family_ser_no); $count++) {
        $family_ser_no_clean = mysqli_real_escape_string($link, $family_ser_no[$count]);
        $family_member_name_clean = mysqli_real_escape_string($link, $family_member_name[$count]);
        $family_relation_clean = mysqli_real_escape_string($link, $family_relation[$count]);
        $family_date_of_departure_clean = mysqli_real_escape_string($link, $family_date_of_departure[$count]);
        if ($family_ser_no_clean != '' && $family_member_name_clean != '' && $family_relation_clean != '' && $family_date_of_departure_clean != '') {
            $query .= '
       INSERT INTO briefing_20387_family_members_info(bd_no,visit_info_id,ser_no,family_name,relation,departure_date) 
       VALUES("' . $_SESSION['bd_no'] . '","' . $_SESSION['visitId'] . '","' . $family_ser_no_clean . '", "' . $family_member_name_clean . '", "' . $family_relation_clean . '", "' . $family_date_of_departure_clean . '"); 
       ';
        }
    }

    if ($query != '') {
        if (mysqli_multi_query($link, $query)) {
            echo 'Family Members Info Inserted Successfully';
        } else {
            echo 'Error' . mysqli_error($link);
        }
    } else {
        echo 'Family Members Info All Fields are Required';
    }
}

?>