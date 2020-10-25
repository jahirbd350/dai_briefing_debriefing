<?php
session_start();

include_once('../../config.php');

if (isset($_POST["gift_ser_no"])) {
    $gift_ser_no = $_POST["gift_ser_no"];
    $gift_details = $_POST["gift_details"];
    $gift_date = $_POST["gift_date"];
    $gift_value = $_POST["gift_value"];
    $gift_dignitary = $_POST["gift_dignitary"];
    $gift_remarks = $_POST["gift_remarks"];
    $query = '';
    for ($count = 0; $count < count($gift_ser_no); $count++) {
        $gift_ser_no_clean = mysqli_real_escape_string($link, $gift_ser_no[$count]);
        $gift_details_clean = mysqli_real_escape_string($link, $gift_details[$count]);
        $gift_date_clean = mysqli_real_escape_string($link, $gift_date[$count]);
        $gift_value_clean = mysqli_real_escape_string($link, $gift_value[$count]);
        $gift_dignitary_clean = mysqli_real_escape_string($link, $gift_dignitary[$count]);
        $gift_remarks_clean = mysqli_real_escape_string($link, $gift_remarks[$count]);
        if ($gift_ser_no_clean != '') {
            $query .= '
       INSERT INTO debrief_20388_gift(bd_no,visit_info_id,ser_no, details_of_gift_received, gift_date, approx_value, dignitary_name, remarks) 
       VALUES("' . $_SESSION['bd_no'] . '","' . $_SESSION['visitId'] . '","' . $gift_ser_no_clean . '", "' . $gift_details_clean . '", "' . $gift_date_clean . '", "' . $gift_value_clean . '", "' . $gift_dignitary_clean . '", "' . $gift_remarks_clean . '"); 
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