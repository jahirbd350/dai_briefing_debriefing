<?php
session_start();
$visiting_country = $_SESSION['visiting_country'];
$group_id = $_SESSION['groupId'];

include_once('../../config.php');

if (isset($_POST["svc_no"])) {
    $svc_no = $_POST["svc_no"];
    $query = '';
    for ($count = 0; $count < count($svc_no); $count++) {
        $svc_no_clean = mysqli_real_escape_string($link, $svc_no[$count]);
        if ($svc_no_clean != '') {
            $query .= 'INSERT INTO new_users(bd_no) VALUES("' . $svc_no_clean . '") ON DUPLICATE KEY UPDATE type_of_visit="briefing",visit_country="' . $visiting_country . '",user_active="active",group_id="'.$group_id.'";';
        }
    }

    if ($query != '') {
        if (mysqli_multi_query($link, $query)) {
            echo 'Traveling with Info Inserted Successfully';
        } else {
            echo 'Traveling with Info' . mysqli_error($link);
        }
    } else {
        echo 'Traveling with Info All Fields are Required';
    }
}

?>