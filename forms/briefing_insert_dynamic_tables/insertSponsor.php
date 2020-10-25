<?php
session_start();

include_once('../../config.php');

if (isset($_POST["sponsor_ser_no"])) {
    $sponsor_ser_no = $_POST["sponsor_ser_no"];
    $sponsor_name = $_POST["sponsor_name"];
    $sponsor_occupation = $_POST["sponsor_occupation"];
    $sponsor_relation = $_POST["sponsor_relation"];
    $sponsor_address = $_POST["sponsor_address"];
    $query = '';
    for ($count = 0; $count < count($sponsor_ser_no); $count++) {
        $sponsor_ser_no_clean = mysqli_real_escape_string($link, $sponsor_ser_no[$count]);
        $sponsor_name_clean = mysqli_real_escape_string($link, $sponsor_name[$count]);
        $sponsor_occupation_clean = mysqli_real_escape_string($link, $sponsor_occupation[$count]);
        $sponsor_relation_clean = mysqli_real_escape_string($link, $sponsor_relation[$count]);
        $sponsor_address_clean = mysqli_real_escape_string($link, $sponsor_address[$count]);
        if ($sponsor_ser_no_clean != '' && $sponsor_name_clean != '' && $sponsor_occupation_clean != '' && $sponsor_relation_clean != '' && $sponsor_address_clean != '') {
            $query .= '
       INSERT INTO briefing_20387_sponsor_relative_info(bd_no,visit_info_id,ser_no,sponsor_name,occupation,relation,address) 
       VALUES("' . $_SESSION['bd_no'] . '","' . $_SESSION['visitId'] . '","' . $sponsor_ser_no_clean . '", "' . $sponsor_name_clean . '", "' . $sponsor_occupation_clean . '", "' . $sponsor_relation_clean . '", "' . $sponsor_address_clean . '"); 
       ';
        }
    }

    if ($query != '') {
        if (mysqli_multi_query($link, $query)) {
            echo 'Sponsor Info Inserted Successfully';
        } else {
            echo 'Error' . mysqli_error($link);
        }
    } else {
        echo 'Sponsor Info All Fields are Required';
    }
}

?>