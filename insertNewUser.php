<?php
session_start();

include_once ('config.php');

if (isset($_POST["svc_no"])) {
    $svc_no = $_POST["svc_no"];
    $rank = $_POST["rank"];
    $name = $_POST["name"];
    $br_trade = $_POST["br_trade"];
    $query = '';
    for ($count = 0; $count < count($svc_no); $count++) {
        $svc_no_clean = mysqli_real_escape_string($link, $svc_no[$count]);
        $rank_clean = mysqli_real_escape_string($link, $rank[$count]);
        $name_clean = mysqli_real_escape_string($link, $name[$count]);
        $br_trade_clean = mysqli_real_escape_string($link, $br_trade[$count]);
        if ($svc_no_clean != '') {
            $query .= 'INSERT INTO new_users(bd_no,rank,name,br_trade,password) VALUES("' . $svc_no_clean . '","' . $rank_clean . '","' . $name_clean . '","' . $br_trade_clean . '","' . $svc_no_clean . '") ON DUPLICATE KEY UPDATE user_role="user",user_active="in_active",dai_approval="not_approved";';
        }
    }

    if ($query != '') {
        if (mysqli_multi_query($link, $query)) {
            echo 'New User Info Inserted Successfully';
        } else {
            echo 'New User Info' . mysqli_error($link);
        }
    } else {
        echo 'New User Info All Fields are Required';
    }
}

?>