<?php
session_start();

include_once('../../config.php');

if (isset($_POST["past_visit_ser_no"])) {
    $past_visit_ser_no = $_POST["past_visit_ser_no"];
    $past_country = $_POST["past_country"];
    $past_purpose = $_POST["past_purpose"];
    $past_duration_of_stay = $_POST["past_duration_of_stay"];
    $past_remarks = $_POST["past_remarks"];
    $query = '';
    for ($count = 0; $count < count($past_visit_ser_no); $count++) {
        $past_visit_ser_no_clean = mysqli_real_escape_string($link, $past_visit_ser_no[$count]);
        $past_country_clean = mysqli_real_escape_string($link, $past_country[$count]);
        $past_purpose_clean = mysqli_real_escape_string($link, $past_purpose[$count]);
        $past_duration_of_stay_clean = mysqli_real_escape_string($link, $past_duration_of_stay[$count]);
        $past_remarks_clean = mysqli_real_escape_string($link, $past_remarks[$count]);
        if ($past_visit_ser_no_clean != '') {
            $query .= '
       INSERT INTO briefing_20387_past_visit_info(bd_no,visit_info_id,ser_no,country,purpose,duration,remarks) 
       VALUES("' . $_SESSION['bd_no'] . '","' . $_SESSION['visitId'] . '","' . $past_visit_ser_no_clean . '", "' . $past_country_clean . '", "' . $past_purpose_clean . '", "' . $past_duration_of_stay_clean . '", "' . $past_remarks_clean . '"); 
       ';
        }
    }
    if ($query != '') {
        if (mysqli_multi_query($link, $query)) {
            echo 'Past Visit Info Inserted Successfully';
        } else {
            echo 'Error' . mysqli_error($link);
        }
    } else {
        echo 'Past Visit Info All Fields are Required';
    }
}
?>