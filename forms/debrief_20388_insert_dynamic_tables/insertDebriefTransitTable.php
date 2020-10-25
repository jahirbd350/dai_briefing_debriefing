<?php
session_start();

include_once('../../config.php');

if (isset($_POST["transit_ser_no"])) {
    $transit_ser_no = $_POST["transit_ser_no"];
    $transit_country = $_POST["transit_country"];
    $transit_stay = $_POST["transit_stay"];
    $transit_purpose = $_POST["transit_purpose"];
    $query = '';
    for ($count = 0; $count < count($transit_ser_no); $count++) {
        $transit_ser_no_clean = mysqli_real_escape_string($link, $transit_ser_no[$count]);
        $transit_country_clean = mysqli_real_escape_string($link, $transit_country[$count]);
        $transit_stay_clean = mysqli_real_escape_string($link, $transit_stay[$count]);
        $transit_purpose_clean = mysqli_real_escape_string($link, $transit_purpose[$count]);
        if ($transit_ser_no_clean != '') {
            $query .= '
       INSERT INTO debrief_20388_transit_info(bd_no,visit_info_id,ser_no, country, duration, purpose) 
       VALUES("' . $_SESSION['bd_no'] . '","' . $_SESSION['visitId'] . '","' . $transit_ser_no_clean . '", "' . $transit_country_clean . '", "' . $transit_stay_clean . '", "' . $transit_purpose_clean . '"); 
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