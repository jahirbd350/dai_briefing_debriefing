<?php

class Briefing
{
    protected $link;

    public function __construct()
    {
        $this->link = mysqli_connect('localhost', 'root', '', 'dai_briefing');
    }

    public function insertUserData()
    {
        $sql = "SELECT * FROM new_users WHERE bd_no='$_POST[svc_no]'";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            $userInfo = mysqli_fetch_assoc($queryResult);
            if ($userInfo['bd_no'] == $_POST['svc_no']) {
                return "User Svc No already Exists!";
            } else {
                $sql = "INSERT INTO new_users(bd_no,rank,name,br_trade,date_of_birth,password)
                VALUES ('$_POST[svc_no]','$_POST[rank]','$_POST[full_name]','$_POST[br_trade]','$_POST[dob]','$_POST[svc_no]')";
                if (mysqli_query($this->link, $sql)) {
                    $message = "New User Inserted Successfully!";
                    return $message;
                } else {
                    die("insert User Data Query Problem : " . mysqli_error($this->link));
                }
            }
        } else {
            die('User Check Error : ' . mysqli_error($this->link));
        }

    }

    public function selectAllUsers(){
        $sql = "SELECT * FROM new_users";
        if (mysqli_query($this->link, $sql)) {
            $result = mysqli_query($this->link,$sql);
            return $result;
        } else {
            die("briefing_20387_visit_info Insert Query Problem : " . mysqli_error($this->link));
        }
    }

    public function selectIndividualUsers(){
        $sql = "SELECT * FROM new_users WHERE bd_no = '$_POST[svc_no]'";
        if (mysqli_query($this->link, $sql)) {
            $result = mysqli_query($this->link,$sql);
            return $result;
        } else {
            die("briefing_20387_visit_info Insert Query Problem : " . mysqli_error($this->link));
        }
    }

    public function updateUserData()
    {
        $sql = "UPDATE new_users
              SET 
              rank = '$_POST[rank]',
              name = '$_POST[full_name]',
              br_trade = '$_POST[br_trade]',
              date_of_birth = '$_POST[dob]',
              password = '$_POST[password]'
              WHERE bd_no='$_POST[svc_no]'";

        if (mysqli_query($this->link, $sql)) {
            return "User Information Updated Successfully!";
        } else {
            die('updateUserData Update Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function saveVisitData()
    {
        if ($_POST['ex_bd_lv_start']==''){
            $exBdLvStart="1970-01-01";
        }else{
            $exBdLvStart=$_POST['ex_bd_lv_start'];
        }
        if ($_POST['ex_bd_lv_finish']==''){
            $exBdLvFinish="1970-01-01";
        }else{
            $exBdLvFinish=$_POST['ex_bd_lv_finish'];
        }

        $filename = $_FILES['myfile']['name'];

        // destination of the file on the server
        $destination = 'ex_bd_lv_docs/' . $filename;

        // get the file extension
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // the physical file on a temporary uploads directory on the server
        $file = $_FILES['myfile']['tmp_name'];
        $size = $_FILES['myfile']['size'];

        if (!in_array($extension, ['zip', 'pdf', 'docx', 'jpg', 'png'])) {
            echo "Your file extension must be .zip, .pdf or .docx";
        } elseif ($_FILES['myfile']['size'] > 5000000) { // file shouldn't be larger than 1Megabyte
            echo "File too large!";
        } else {
            // move the uploaded (temporary) file to the specified destination
            if (move_uploaded_file($file, $destination)) {
                /*$sql = "INSERT INTO files (name, size, downloads) VALUES ('$filename', $size, 0)";
                if (mysqli_query($conn, $sql)) {
                    echo "File uploaded successfully";
                }*/
            } else {
                echo "Failed to upload file.";
            }
        }

        $sql = "INSERT INTO briefing_20387_visit_info(bd_no,visit_info_id,group_id,unit,passport_no,purpose_of_visit,destination_airport,destination_country,departure_date,departure_place,name_of_airlines,date_of_reaching_destination,date_of_leaving_destination,ex_bd_lv_start,ex_bd_lv_finish,ex_bd_lv_doc,duration_of_stay_abroad,total_money,personal_money)
                VALUES ('$_SESSION[bd_no]','$_SESSION[visitId]','$_SESSION[groupId]','$_POST[unit]','$_POST[passport_no]','$_POST[purpose_of_visit]','$_POST[destination_airport]','$_POST[destination_country]','$_POST[departure_date]','$_POST[departure_place]','$_POST[name_of_airlines]','$_POST[date_of_reaching_destination]','$_POST[date_of_leaving_destination]','$exBdLvStart','$exBdLvFinish','$filename','$_POST[duration_of_stay_abroad]','$_POST[total_money]','$_POST[personal_money]')";
        if (mysqli_query($this->link, $sql)) {
            $message = "Visit Data Inserted Successfully";
            return $message;
        } else {
            die("briefing_20387_visit_info Insert Query Problem : " . mysqli_error($this->link));
        }
    }

    public function viewBriefingList()
    {
        $sql = "SELECT * FROM new_users WHERE type_of_visit='briefing' && user_active='active' ORDER BY bd_no";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('viewBriefingList Query Problem' . mysqli_error($this->link));
        }
    }

    public function viewBriefingData($data)
    {
        $sql = "SELECT * FROM briefing_20387_visit_info WHERE dai_approval='not_approved' && bd_no='$data' ORDER BY id DESC";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('viewBriefingData Query Problem' . mysqli_error($this->link));
        }
    }

    public function viewBriefingGroupData($visitCountry,$groupId)
    {
        $sql = "SELECT bd_no FROM new_users WHERE type_of_visit='briefing' && visit_country='$visitCountry' && group_id='$groupId' ORDER BY bd_no";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('viewGroupData Query Problem' . mysqli_error($this->link));
        }
    }

    public function viewDeBriefVisitGroupData($visitCountry,$groupId)
    {
        $sql = "SELECT bd_no FROM new_users WHERE type_of_visit='de_brief_visit' && visit_country='$visitCountry' && group_id='$groupId' ORDER BY bd_no";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('viewGroupData Query Problem' . mysqli_error($this->link));
        }
    }

    public function viewDeBriefTrainingGroupData($visitCountry,$groupId)
    {
        $sql = "SELECT bd_no FROM new_users WHERE type_of_visit='de_brief_training' && visit_country='$visitCountry' && group_id='$groupId' ORDER BY bd_no";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('viewGroupData Query Problem' . mysqli_error($this->link));
        }
    }

    public function viewDeBriefingForms($data)
    {
        $sql = "SELECT * FROM debrief_20388_visit_info WHERE dai_approval='not_approved' && bd_no='$data' ORDER BY id DESC LIMIT 1";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('F-20387 Query Problem' . mysqli_error($this->link));
        }
    }

    public function viewDeBriefingTrainingForms($data)
    {
        $sql = "SELECT * FROM debrief_20389_training_info WHERE dai_approval='not_approved' && bd_no='$data' ORDER BY id DESC LIMIT 1";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('F-20389 Query Problem' . mysqli_error($this->link));
        }
    }

    public function viewIndividualBriefingList()
    {
        $sql = "SELECT * FROM briefing_20387_visit_info WHERE dai_approval='not_approved' && bd_no='$_SESSION[bd_no]' ORDER BY id DESC";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('F-20387 Query Problem' . mysqli_error($this->link));
        }
    }

    public function viewIndividualBriefingRejectedList()
    {
        $sql = "SELECT * FROM briefing_20387_visit_info WHERE dai_approval = 'rejected' && bd_no='$_SESSION[bd_no]' ORDER BY id DESC";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('F-20387 Individual Rejected List Query Problem: ' . mysqli_error($this->link));
        }
    }

    public function viewAllBriefingRejectedList()
    {
        $sql = "SELECT * FROM briefing_20387_visit_info WHERE dai_approval = 'rejected' ORDER BY id DESC";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('F-20387 Individual Rejected List Query Problem: ' . mysqli_error($this->link));
        }
    }

    public function viewIndividualDeBriefRejectedVisitingList()
    {
        $sql = "SELECT * FROM debrief_20388_visit_info WHERE dai_approval='rejected' && bd_no='$_SESSION[bd_no]' ORDER BY id DESC";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('viewIndividualDeBriefRejectedVisitingList Query Problem' . mysqli_error($this->link));
        }
    }

    public function viewAllDeBriefRejectedVisitingList()
    {
        $sql = "SELECT * FROM debrief_20388_visit_info WHERE dai_approval='rejected' ORDER BY id DESC";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('F-20387 Query Problem' . mysqli_error($this->link));
        }
    }

    public function viewIndividualDeBriefRejectedTrainingList()
    {
        $sql = "SELECT * FROM debrief_20389_training_info WHERE dai_approval='rejected' && bd_no='$_SESSION[bd_no]' ORDER BY id DESC";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('viewIndividualDeBriefRejectedTrainingList Query Problem' . mysqli_error($this->link));
        }
    }

    public function viewAllDeBriefRejectedTrainingList()
    {
        $sql = "SELECT * FROM debrief_20389_training_info WHERE dai_approval='rejected' ORDER BY id DESC";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('F-20387 Query Problem' . mysqli_error($this->link));
        }
    }

    public function viewBriefingHistory()
    {
        $sql = "SELECT * FROM briefing_20387_visit_info WHERE dai_approval='approved' ORDER BY bd_no DESC";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('View Briefing History Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function viewIndividualBriefingHistory()
    {
        $sql = "SELECT * FROM briefing_20387_visit_info WHERE dai_approval='approved'&&bd_no='$_SESSION[bd_no]' ORDER BY bd_no DESC";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('View Briefing History Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function viewDeBriefVisitingList()
    {
        $sql = "SELECT * FROM new_users WHERE type_of_visit='de_brief_visit' && user_active='active' ORDER BY bd_no";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('viewDeBriefVisitingList Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function viewIndividualDeBriefVisitingList()
    {
        $sql = "SELECT * FROM debrief_20388_visit_info WHERE dai_approval='not_approved' && bd_no='$_SESSION[bd_no]' ORDER BY id DESC";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('F-20388 Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function viewDeBriefVisitingHistory()
    {
        $sql = "SELECT * FROM debrief_20388_visit_info WHERE dai_approval='approved' ORDER BY bd_no DESC";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('F-20388 Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function viewIndividualDeBriefVisitingHistory()
    {
        $sql = "SELECT * FROM debrief_20388_visit_info WHERE dai_approval='approved'&& bd_no='$_SESSION[bd_no]' ORDER BY bd_no DESC";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('viewIndividualDeBriefVisitingHistory Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function viewDeBriefTrainingList()
    {
        $sql = "SELECT * FROM new_users WHERE user_active='active' && type_of_visit='de_brief_training' ORDER BY bd_no";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('viewDeBriefTrainingList Query Problem : ' . mysqli_error($this->link));
        }
    }
    public function viewPasswordResetRequestList()
    {
        $sql = "SELECT * FROM new_users WHERE pass_reset_request='requested' ORDER BY bd_no";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('viewPasswordResetRequestList Query Problem : ' . mysqli_error($this->link));
        }
    }
    public function viewIndividualDeBriefTrainingList()
    {
        $sql = "SELECT * FROM debrief_20389_training_info WHERE dai_approval='not_approved' && bd_no='$_SESSION[bd_no]' ORDER BY id DESC ";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('F-20388 Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function viewDeBriefTrainingHistory()
    {
        $sql = "SELECT * FROM debrief_20389_training_info WHERE dai_approval='approved' ORDER BY bd_no DESC ";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('viewDeBriefTrainingHistory Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function viewIndividualDeBriefTrainingHistory()
    {
        $sql = "SELECT * FROM debrief_20389_training_info WHERE dai_approval='approved' && bd_no='$_SESSION[bd_no]' ORDER BY bd_no DESC ";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('F-20388 Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function saveDebriefTrainingData()
    {
        $sql = "INSERT INTO debrief_20389_training_info(bd_no,visit_info_id,group_id,unit,duration_of_stay_from,duration_of_stay_to,course_which_country,name_of_course,course_from,course_to,name_address_of_institution,course_content,observation_for_future,appointment_in_baf,money_daily_rate,money_total,cash_by_host,food_accommodation,transportation,own_currency,monthly_expenditure,lose_personal_item,bill_clear,financial_transaction,currency_back,promise,friendship,classified_info,difficulty,secret_understanding,foreign_spy,interest_of_foreigner,impression_about_bd,pen_picture,security_problem,progress_in_military,fire_arm) 
                VALUES ('$_SESSION[bd_no]','$_SESSION[visitId]','$_SESSION[groupId]','$_POST[unit]','$_POST[duration_of_stay_from]','$_POST[duration_of_stay_to]','$_POST[destination_country]','$_POST[name_of_course]','$_POST[course_from]','$_POST[course_to]','$_POST[name_address_of_institution]','$_POST[course_content]','$_POST[observation_for_future]','$_POST[appointment_in_baf]','$_POST[money_daily_rate]','$_POST[money_total]','$_POST[cash_by_host]','$_POST[food_accommodation]','$_POST[transportation]','$_POST[own_currency]','$_POST[monthly_expenditure]','$_POST[lose_personal_item]','$_POST[bill_clear]','$_POST[financial_transaction]','$_POST[currency_back]','$_POST[promise]','$_POST[friendship]','$_POST[classified_info]','$_POST[difficulty]','$_POST[secret_understanding]','$_POST[foreign_spy]','$_POST[interest_of_foreigner]','$_POST[impression_about_bd]','$_POST[pen_picture]','$_POST[security_problem]','$_POST[progress_in_military]','$_POST[fire_arm]')";
        if (mysqli_query($this->link, $sql)) {
            $message = "Your De-Briefing data Submitted Successfully" . '<br>' . "Please Wait with patience" . '<br>' . "Thank You";
            $_SESSION['message'] = $message;
        } else {
            die("F-20389 Training Data Query Problem" . mysqli_error($this->link));
        }
    }

    public function saveDebriefVisitData()
    {
        $sql = "INSERT INTO debrief_20388_visit_info(bd_no,visit_info_id,group_id,unit,visit_purpose,duration_of_stay_from,duration_of_stay_to,destination_country,name_of_sponsor,name_address_of_foreign_company,observation_for_future,daily_rate,total_amount,cash_by_host,food_accommodation,transportation,own_currency,lose_personnel_item,bill_cleared,financial_transaction,currency_back,fellow_member,classified_info,difficulty,secret_understanding,foreign_spy,gen_impression,valuable_info,fire_arm) 
                VALUES ('$_SESSION[bd_no]','$_SESSION[visitId]','$_SESSION[groupId]','$_POST[unit]','$_POST[visit_purpose]','$_POST[duration_of_stay_from]','$_POST[duration_of_stay_to]','$_POST[destination_country]','$_POST[name_of_sponsor]','$_POST[name_address_of_foreign_company]','$_POST[observation_for_future]','$_POST[daily_rate]','$_POST[total_amount]','$_POST[cash_by_host]','$_POST[food_accommodation]','$_POST[transportation]','$_POST[own_currency]','$_POST[lose_personnel_item]','$_POST[bill_cleared]','$_POST[financial_transaction]','$_POST[currency_back]','$_POST[fellow_member]','$_POST[classified_info]','$_POST[difficulty]','$_POST[secret_understanding]','$_POST[foreign_spy]','$_POST[gen_impression]','$_POST[valuable_info]','$_POST[fire_arm]')";
        if (mysqli_query($this->link, $sql)) {
            $message = "Your De-Briefing data Submitted Successfully" . '<br>' . "Please Wait with patience";
            $_SESSION['message'] = $message;

        } else {
            die("F-20388 Visit Info Table Query Problem : " . mysqli_error($this->link));
        }
    }

    public function view20387PersonalDataForUpdatePage($bd_no,$visitId)
    {
        $sql = "SELECT * FROM briefing_20387_visit_info WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('view20387PersonalDataForUpdatePage : ' . mysqli_error($this->link));
        }
    }

    public function view20387VisitDataForUpdatePage($bd_no,$visitId)
    {
        $sql = "SELECT * FROM briefing_20387_visit_info WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('F-20388 Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function updateGenInst()
    {
        $sql = "SELECT * FROM briefing_gen_inst";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('updateGenInst Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function updateGenInstData()
    {
        $sql = "UPDATE briefing_gen_inst
              SET 
              gen_inst = '$_POST[gen_inst]'
              WHERE id=1";

        if (mysqli_query($this->link, $sql)) {
            $message = "General Instruction Updated Successfully!";
            return $message;
        } else {
            die('updateGenInstData Update Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function updateF20387VisitData($data)
    {
        //$filename = $_FILES['myfile']['name'];

        if($_FILES['myfile']['name'] != null){
            $filename = $_FILES['myfile']['name'];

            // destination of the file on the server
            $destination = 'ex_bd_lv_docs/'.$filename;

            // get the file extension
            $extension = pathinfo($filename, PATHINFO_EXTENSION);

            // the physical file on a temporary uploads directory on the server
            $file = $_FILES['myfile']['tmp_name'];
            $size = $_FILES['myfile']['size'];

            if (!in_array($extension, ['zip', 'pdf', 'docx', 'jpg', 'png'])) {
                echo "You file extension must be .zip, .pdf, .jpg or .docx";
            } elseif ($_FILES['myfile']['size'] > 5000000) { // file shouldn't be larger than 1Megabyte
                echo "File too large!";
            } else {
                // move the uploaded (temporary) file to the specified destination
                if (move_uploaded_file($file, $destination)) {
                    /*$sql = "INSERT INTO files (name, size, downloads) VALUES ('$filename', $size, 0)";
                    if (mysqli_query($conn, $sql)) {
                        echo "File uploaded successfully";
                    }*/
                } else {
                    echo "Failed to upload file.";
                }
            }
        } else {
            $filename = $data['ex_bd_lv_doc'];
        }
        $date_of_reaching=date('Y-m-d', strtotime($data['date_of_reaching_destination']));
        $date_of_leaving=date('Y-m-d', strtotime($data['date_of_leaving_destination']));
        $ex_bd_lv_start=date('Y-m-d', strtotime($data['ex_bd_lv_start']));
        $ex_bd_lv_finish=date('Y-m-d', strtotime($data['ex_bd_lv_finish']));

        $sql = "UPDATE briefing_20387_visit_info
              SET 
              unit='$data[unit]',
              passport_no='$data[passport_no]',
              purpose_of_visit='$data[purpose_of_visit]',
              destination_airport='$data[destination_airport]',
              destination_country='$data[destination_country]',
              departure_date='$data[departure_date]',
              departure_place='$data[departure_place]',
              name_of_airlines='$data[name_of_airlines]',
              date_of_reaching_destination='$date_of_reaching',
              date_of_leaving_destination='$date_of_leaving',
              ex_bd_lv_start='$ex_bd_lv_start',
              ex_bd_lv_finish='$ex_bd_lv_finish',
              ex_bd_lv_doc='$filename',
              duration_of_stay_abroad='$data[duration_of_stay_abroad]',
              total_money='$data[total_money]',
              personal_money='$data[personal_money]',
              dai_approval='not_approved',
              dai_remarks=''
              WHERE id='$data[id]'";

        if (mysqli_query($this->link, $sql)) {
            $message = "Your Briefing Data ";
            return $message;
        } else {
            die('F-20387 Update Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function updateUserTable()
    {
        $sql = "UPDATE new_users
              SET
              rank='$_POST[rank]', 
              dai_approval='not_approved'
              WHERE bd_no='$_SESSION[bd_no]'";

        if (mysqli_query($this->link, $sql)) {
            $message = "Data Updated Successfully!";
            return $message;
        } else {
            die('F-20387 Update Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function actionF20387Done($data)
    {
        $sql = "UPDATE briefing_20387_visit_info
                SET
                dai_approval='$data[dai_approval]',
                dai_remarks='$data[dai_remarks]',
                special_instruction='$data[special_instruction]'
                WHERE id = '$data[id]'";

        if (mysqli_query($this->link, $sql)) {
            $message = "Data Updated Successfully!";
            return $message;
        } else {
            die('F-20387 Action Query Problem : ' . mysqli_error($this->link));
        }
    }
    public function actionUserTable($data)
    {
        $sql = "UPDATE new_users
              SET 
              dai_approval='$data[dai_approval]'
              WHERE bd_no='$data[bd_no]'";

        if (mysqli_multi_query($this->link, $sql)) {
            $message = "Data Updated Successfully!";
            return $message;
        } else {
            die('F-20389 Action Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function makeUserActive()
    {
        $sql = "UPDATE new_users
              SET
              rank='$_POST[rank]',
              visit_country='$_POST[destination_country]',
              type_of_visit='$_POST[type_of_visit]',
              user_active='active',
              group_id='$_SESSION[groupId]'
              WHERE bd_no='$_SESSION[bd_no]'";

        if (mysqli_multi_query($this->link, $sql)) {
            $message = "Data Updated Successfully!";
            return $message;
        } else {
            die('F-20387 Action Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function makeUserInactive($data)
    {
        $sql = "UPDATE new_users
              SET 
              dai_approval=NULL,
              type_of_visit=NULL,
              user_active='in_active',
              visit_country=NULL,
              group_id=NULL
              WHERE bd_no='$data[bd_no]'";

        if (mysqli_multi_query($this->link, $sql)) {
            $message = "Data Updated Successfully!";
            return $message;
        } else {
            die('F-20387 Action Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function resetUserPassword($data)
    {
        $sql = "UPDATE new_users
              SET 
              password = $data[bd_no],
              pass_reset_request = NULL 
              WHERE bd_no='$data[bd_no]'";

        if (mysqli_multi_query($this->link, $sql)) {
            $message = "Data Updated Successfully!";
            return $message;
        } else {
            die('F-20387 Action Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function unRejectF20387($data)
    {
        $sql = "UPDATE briefing_20387_visit_info
              SET 
              dai_approval='not_approved',
              dai_remarks=''
              WHERE id='$data[id]'";

        if (mysqli_query($this->link, $sql)) {
            $message = "Data Updated Successfully!";
            return $message;
        } else {
            die('F-20387 Update Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function unRejectUserInfo($data)
    {
        $sql = "UPDATE new_users
              SET 
              dai_approval= 'not_approved'
              WHERE bd_no='$data[bd_no]'";

        if (mysqli_query($this->link, $sql)) {
            $message = "Data Updated Successfully!";
            return $message;
        } else {
            die('F-20389 Update Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function view20388PersonalDataForUpdatePage($bd_no,$visitId)
    {
        $sql = "SELECT * FROM new_users WHERE bd_no='$bd_no'";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('F-20388 Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function view20388VisitDataForUpdatePage($bd_no,$visitId)
    {
        $sql = "SELECT * FROM debrief_20388_visit_info WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('F-20388 Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function updateF20388DeBriefVisitData($data)
    {
        $sql = "UPDATE debrief_20388_visit_info
              SET
              unit='$data[unit]', 
              visit_purpose='$data[visit_purpose]',
              duration_of_stay_from='$data[duration_of_stay_from]',
              duration_of_stay_to='$data[duration_of_stay_to]',
              destination_country='$data[destination_country]',
              name_of_sponsor='$data[name_of_sponsor]',
              name_address_of_foreign_company='$data[name_address_of_foreign_company]',
              observation_for_future='$data[observation_for_future]',
              daily_rate='$data[daily_rate]',
              total_amount='$data[total_amount]',
              cash_by_host='$data[cash_by_host]',
              food_accommodation='$data[food_accommodation]',
              transportation='$data[transportation]',
              own_currency='$data[own_currency]',
              lose_personnel_item='$data[lose_personnel_item]',
              bill_cleared='$data[bill_cleared]',
              financial_transaction='$data[financial_transaction]',
              currency_back='$data[currency_back]',
              fellow_member='$data[fellow_member]',
              classified_info='$data[classified_info]',
              difficulty='$data[difficulty]',
              secret_understanding='$data[secret_understanding]',
              foreign_spy='$data[foreign_spy]',
              gen_impression='$data[gen_impression]',
              valuable_info='$data[valuable_info]',
              fire_arm='$data[fire_arm]',
              dai_approval='not_approved',
              dai_remarks=''
              WHERE id='$data[id]'";

        if (mysqli_query($this->link, $sql)) {
            $message = "Your De-Briefing Visit ";
            return $message;
        } else {
            die('F-20388 Update Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function actionF20388Done($data)
    {
        $sql = "UPDATE debrief_20388_visit_info
              SET 
              dai_approval='$data[dai_approval]',
              dai_remarks='$data[dai_remarks]'
              WHERE id='$data[id]'";

        if (mysqli_query($this->link, $sql)) {
            $message = "Data Updated Successfully!";
            return $message;
        } else {
            die('actionF20388Done Update Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function unRejectF20388($data)
    {
        $sql = "UPDATE debrief_20388_visit_info
              SET 
              dai_approval='not_approved',
              dai_remarks=''
              WHERE id='$data[id]'";

        if (mysqli_query($this->link, $sql)) {
            $message = "Data Updated Successfully!";
            return $message;
        } else {
            die('F-20389 Update Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function viewPersonalData($bd_no)
    {
        $sql = "SELECT * FROM new_users WHERE bd_no='$bd_no'";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('F-20388 Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function view20389TrainingDataForUpdatePage($bd_no,$visitId)
    {
        $sql = "SELECT * FROM debrief_20389_training_info WHERE bd_no='$bd_no'&&visit_info_id='$visitId'";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('F-20388 Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function updateF20389DeBriefTrainingData($data)
    {
        $sql = "UPDATE debrief_20389_training_info
              SET
              unit='$data[unit]', 
              duration_of_stay_from='$data[duration_of_stay_from]',
              duration_of_stay_to='$data[duration_of_stay_to]',
              course_which_country='$data[course_which_country]',
              name_of_course='$data[name_of_course]',
              course_from='$data[course_from]',
              course_to='$data[course_to]',
              name_address_of_institution='$data[name_address_of_institution]',
              course_content='$data[course_content]',
              observation_for_future='$data[observation_for_future]',
              appointment_in_baf='$data[appointment_in_baf]',
              money_daily_rate='$data[money_daily_rate]',
              money_total='$data[money_total]',
              cash_by_host='$data[cash_by_host]',
              food_accommodation='$data[food_accommodation]',
              transportation='$data[transportation]',
              own_currency='$data[own_currency]',
              monthly_expenditure='$data[monthly_expenditure]',
              lose_personal_item='$data[lose_personal_item]',
              bill_clear='$data[bill_clear]',
              financial_transaction='$data[financial_transaction]',
              currency_back='$data[currency_back]',
              promise='$data[promise]',
              friendship='$data[friendship]',
              classified_info='$data[classified_info]',
              difficulty='$data[difficulty]',
              secret_understanding='$data[secret_understanding]',
              foreign_spy='$data[foreign_spy]',
              interest_of_foreigner='$data[interest_of_foreigner]',
              impression_about_bd='$data[impression_about_bd]',
              pen_picture='$data[pen_picture]',
              security_problem='$data[security_problem]',
              progress_in_military='$data[progress_in_military]',
              fire_arm='$data[fire_arm]',
              dai_approval='not_approved'
              WHERE id='$data[id]'";

        if (mysqli_query($this->link, $sql)) {
            $message = "Your De-Briefing Training";
            return $message;
        } else {
            die('F-20389 Update Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function actionF20389Done($data)
    {
        $sql = "UPDATE debrief_20389_training_info
              SET 
              dai_approval='$data[dai_approval]',
              dai_remarks='$data[dai_remarks]'
              WHERE id='$data[id]'";

        if (mysqli_query($this->link, $sql)) {
            $message = "Data Updated Successfully!";
            return $message;
        } else {
            die('F-20389 Update Query Problem : ' . mysqli_error($this->link));
        }
    }
    public function unrejectF20389($data)
    {
        $sql = "UPDATE debrief_20389_training_info
              SET 
              dai_approval='not_approved',
              dai_remarks=''
              WHERE id='$data[id]'";

        if (mysqli_query($this->link, $sql)) {
            $message = "Data Updated Successfully!";
            return $message;
        } else {
            die('F-20389 Unreject Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function briefingPagination($limit,$start){
        $sql = "SELECT * FROM briefing_20387_visit_info WHERE dai_approval='approved' ORDER BY bd_no DESC LIMIT $start, $limit";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('View Briefing Pagination Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function deBriefVisitPagination($limit,$start){
        $sql = "SELECT * FROM debrief_20388_visit_info WHERE dai_approval='approved' ORDER BY bd_no DESC LIMIT $start, $limit";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('View De-brief Training Pagination Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function deBriefTrainingPagination($limit,$start){
        $sql = "SELECT * FROM debrief_20389_training_info WHERE dai_approval='approved' ORDER BY bd_no DESC LIMIT $start, $limit";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('View De-brief Training Pagination Query Problem : ' . mysqli_error($this->link));
        }
    }

    public function getDynamicTableData($sql)
    {
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            return $queryResult;
        } else {
            die('Get Dynamic Table Data Query Problem : ' . mysqli_error($this->link));
        }
    }
}