<?php
//include connection file
include_once("../config.php");
include_once('libs/fpdfphp');
$bd_no = $_GET['bd_no'];
$visit_id = $_GET['visit_info_id'];

class PDF extends FPDF
{
// Page header
    function Header()
    {
        // Logo
        //$this->Image('logo.png',10,-1,70);

        $this->SetY(15);

        $this->SetFont('Arial', '', 12);
        // Title
        $this->Ln(1);
        $this->Cell(0, 0, 'CONFIDENTIAL', 0, 0, 'C');
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-25);
        // Arial italic 8
        $this->SetFont('Arial', '', 12);
        // Page number
        $this->Cell(0, 10, $this->PageNo(), 0, 0, 'C');
        $this->Ln(0);
        $this->Cell(0, 20, 'CONFIDENTIAL', 0, 0, 'C');
    }

    function FancyTable($header, $transitInfo)
    {
        // Colors, line width and bold font
        $this->SetFillColor(240, 240, 240);
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0);
        $this->SetFont('Arial', 'B');
        // Table Header

        for ($i = 0; $i < count($header); $i++) {
            $this->Cell(30, 7, $header[$i], 1, 0, 'C', true);
        }
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('Arial');
        // Data

        foreach ($transitInfo as $row) {
            $this->Ln();
            $this->Cell(12, 0, '   ');

            foreach ($row as $column) {
                $this->Cell(30, 8, $column, 1, 0, 'C');
            }
        }
    }

    function ServiceItemTable($header, $transitInfo)
    {
        // Colors, line width and bold font
        $this->SetFillColor(240, 240, 240);
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0);
        $this->SetFont('Arial', 'B');
        // Table Header

        for ($i = 0; $i < count($header); $i++) {
            $this->Cell(50, 7, $header[$i], 1, 0, 'C', true);
        }
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('Arial');
        // Data
        foreach ($transitInfo as $row) {
            $this->Ln();
            $this->Cell(12, 0, '   ');
            foreach ($row as $column) {
                $this->Cell(50, 8, $column, 1, 0, 'C');
            }
        }
    }
}

$personelInfo = mysqli_query($link, "SELECT * FROM new_users WHERE bd_no='$bd_no'") or die("database error:" . mysqli_error($link));
$personelInfo = mysqli_fetch_assoc($personelInfo);

$trainingInfo = mysqli_query($link, "SELECT * FROM debrief_20389_training_info WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));
$trainingInfo = mysqli_fetch_assoc($trainingInfo);

$transitInfo = mysqli_query($link, "SELECT ser_no,country,duration,purpose FROM debrief_20389_transit_info WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));
$students = mysqli_query($link, "SELECT ser_no,nationality,ranks_particulars,remarks FROM debrief_20389_summary_of_students WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));
$foreign_friends = mysqli_query($link, "SELECT ser_no,name_address,occupation,remarks FROM debrief_20389_friends_in_abroad WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));
$kind_foreigner = mysqli_query($link, "SELECT ser_no,name_address,occupation,remarks FROM debrief_20389_help_by_foreigner WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));
$lostSvcItem = mysqli_query($link, "SELECT ser_no,type_of_docu,place_of_lost,remarks FROM debrief_20389_lose_service_property WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));
$institution = mysqli_query($link, "SELECT ser_no,name_of_institution,remarks FROM debrief_20389_institution WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));
$milSiteInfo = mysqli_query($link, "SELECT ser_no,place,importance FROM debrief_20389_military_site_visited WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));
$milMeetInfo = mysqli_query($link, "SELECT ser_no,particulars,appointment,purpose_of_meeting FROM debrief_20389_meeting WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));
$clubMemberInfo = mysqli_query($link, "SELECT ser_no,name_of_club,remarks FROM debrief_20389_club_membership WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));
$giftInfo = mysqli_query($link, "SELECT ser_no,details_of_gift_received,gift_date,approx_value,dignitary_name,remarks FROM debrief_20389_gift WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));
$armsInfo = mysqli_query($link, "SELECT ser_no,type_of_arm,price,permission_taken_from,remarks FROM debrief_20389_fire_arms WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:" . mysqli_error($link));

$pdf = new PDF('P', 'mm', 'A4');
//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 12);
$pdf->SetMargins(20, 0, 20);

$pdf->Ln(1);
$pdf->Cell(0, 10, '(When filled in)', 0, 0, 'C');
$pdf->Ln(0);
$pdf->Cell(180, 10, 'F-20388', 0, 0, 'R');
$pdf->Ln(0);
$pdf->SetFont('Arial', 'BU', 12);
$pdf->Cell(0, 25, 'DIRECTORATE OF AIR INTELLIGENCE', 0, 0, 'C');
$pdf->Ln(1);
$pdf->Cell(0, 32, 'INTELLIGENCE DE-BRIEFING ON RETURN FROM COURSE ABROAD', 0, 0, 'C');
$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 45, '(This form is prepared in accordance with AFO 200-2 dated 22 April 1990.  Following info', 0, 0, '');
$pdf->Ln(1);
$pdf->Cell(0, 55, 'are to be furnished by all  BAF  personnel  returning  from  abroad.  You  may  add  extra', 0, 0, '');
$pdf->Ln(1);
$pdf->Cell(0, 65, 'papers,documents,photos and maps to furnish your report.)', 0, 0, '');

$pdf->Ln(1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(25, 80, '1.    Name:', '', '');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 80, $personelInfo['name'].'                                                                                                     ');
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 80, '                  ___________________________________________________________________');
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 80, '2.    Rank:');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(75, 80, $personelInfo['rank'].'                                                                    ');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(25, 80, '3.    BD No:');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 80, $personelInfo['bd_no'].'                ');
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 80, '                 _______________________________________                       _________________');

$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 95, '4.    Branch/Trade:');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(75, 95, $personelInfo['br_trade'].'                                                   ');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(25, 95, '5.    Unit:');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 95, $trainingInfo['unit'].'                  ');
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 95, '                              _________________________________                  ___________________');

$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(80, 110, '6.    Total duration of stay abroad : From ');
$pdf->SetFont('Arial', 'B', 12);
$fromDate = date('d M y',strtotime($trainingInfo['duration_of_stay_from']));
$pdf->Cell(30, 110, $fromDate);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(20, 110, '    To ');
$pdf->SetFont('Arial', 'B', 12);
$toDate = date('d M y',strtotime($trainingInfo['duration_of_stay_to']));
$pdf->Cell(20, 110, $toDate);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 110, '                                                                 _______________         ________________________');

$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(100, 125, '7.    Country at which the course was conducted ');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 125, $trainingInfo['course_which_country']);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 125, '                                                                              _____________________________________');

//Transit Table Data
$pdf->Ln(70);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(120, 0, '8.    Transit country/countries(other than ser no 7):');

//Transit Table Data Start
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(5);
$pdf->SetFillColor(240, 240, 240);
$pdf->Cell(10, 5, '', 0, 0);
$pdf->Cell(15, 5, 'Ser', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Country', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Duration', 1, 0, 'C', 'true');//end of line
$pdf->Cell(55, 5, 'Purpose', 1, 1, 'C', 'true');//end of line

while ($item = mysqli_fetch_assoc($transitInfo)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(10, 5, '', 0, 0);
    $pdf->Cell(15, 5, $item['ser_no'], 1, 0, 'C');
    $pdf->Cell(50, 5, $item['country'], 1, 0, 'C');
    $pdf->Cell(50, 5, $item['duration'], 1, 0, 'C');//end of line
    $pdf->Cell(55, 5, $item['purpose'], 1, 1, 'C');//end of line
}
// Transit Table Data End

//$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, '9.    Details of Training:');
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(55, 20, '         a.    Name of course ');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(70, 20, $trainingInfo['name_of_course']);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 20, '                                          _______________________________________________________');

$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(85, 35, '         b.    Duration of the course: From ');
$pdf->SetFont('Arial', 'B', 12);
$fromDate = date('d M y',strtotime($trainingInfo['course_from']));
$pdf->Cell(20, 35, $fromDate);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(20, 35, '         To ');
$pdf->SetFont('Arial', 'B', 12);
$toDate = date('d M y',strtotime($trainingInfo['course_to']));
$pdf->Cell(20, 35, $toDate);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 35, '                                                                 _______________         ________________________');

$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(90, 50, '         c.    Name and address of the institution ');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 50, $trainingInfo['name_address_of_institution']);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 50, '                                                                          _______________________________________');

$pdf->Ln(3);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, 60, '         d.    General description about the course content, composition of student officers ');
$pdf->Ln(0);
$pdf->Cell(150, 70, '                and observations about its utility and benefit to BAF');
$pdf->Ln(37);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(19, 0, '');
$pdf->MultiCell(162, 5, $trainingInfo['course_content']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '                ____________________________________________________________________','','1');
$pdf->Cell(150, 12, '                ____________________________________________________________________');

$pdf->Ln(12);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, 0, '         e.    Was the course conducted only for Bangladesh  student?  If  no  then  details  of  the');
$pdf->Ln(0);
$pdf->Cell(150, 10, '         other foreign students: (you may attach a course photograph). If the numbers of students');
$pdf->Ln(10);
$pdf->Cell(150, 0, '         are more, may give a summary of total number of students with rank as per following:');

//Transit Table Data Start
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(5);
$pdf->SetFillColor(240, 240, 240);
$pdf->Cell(20, 5, '', 0, 0);
$pdf->Cell(15, 5, 'Ser', 1, 0, 'C', 'true');
$pdf->Cell(45, 5, 'Nationality', 1, 0, 'C', 'true');
$pdf->Cell(60, 5, 'Rank/Particulars', 1, 0, 'C', 'true');//end of line
$pdf->Cell(40, 5, 'Remarks', 1, 1, 'C', 'true');//end of line

while ($item = mysqli_fetch_assoc($students)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20, 5, '', 0, 0);
    $pdf->Cell(15, 5, $item['ser_no'], 1, 0, 'C');
    $pdf->Cell(45, 5, $item['nationality'], 1, 0, 'C');
    $pdf->Cell(60, 5, $item['ranks_particulars'], 1, 0, 'C');//end of line
    $pdf->Cell(40, 5, $item['remarks'], 1, 1, 'C');//end of line
}
// Transit Table Data End

$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, 10, '         f.    Your observation and guidance to BAF personnel attending the same course in future:');
$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(18, 0, '');
$pdf->MultiCell(162, 5, $trainingInfo['observation_for_future']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '               ____________________________________________________________________','','1');
$pdf->Cell(150, 12, '               ____________________________________________________________________');

$pdf->Ln(7);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, 10, '         g.   Which appointment in BAF would allow you to excercise the most from the course?');
$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(18, 0, '');
$pdf->MultiCell(162, 5, $trainingInfo['appointment_in_baf']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '               ____________________________________________________________________','','1');
$pdf->Cell(150, 12, '               ____________________________________________________________________');

$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 12);

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '10.    Amount of money received from bangladesh Govt. in foreign currency:');
$pdf->Ln(0);
$pdf->Cell(50, 12, '         a.    Daily Rate:');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 12, $trainingInfo['money_daily_rate']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 12, 'b.    Total:');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 12, $trainingInfo['money_total']);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 12, '                                  ________________                   _________________________________');

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(80, 5, '11.    Facilities provided by the visiting country:');
$pdf->Ln(0);
$pdf->Cell(80, 15, '         a.    Were you given any cash by the host? If yes, state reasons and amount:');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(10);
$pdf->Cell(19, 10, '');
$pdf->MultiCell(162, 5, $trainingInfo['cash_by_host']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '                ____________________________________________________________________','','1');
$pdf->Cell(150, 12, '                ____________________________________________________________________');

$pdf->Ln(12);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(90, 0, '         b.    Was food & accommodation free?');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 0, $trainingInfo['food_accommodation']);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 0, '                                                                      _________________________________________');

$pdf->Ln(2);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(70, 10, '         c.    Was transportation free?');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 10, $trainingInfo['transportation']);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, '                                                        ________________________________________________');

$pdf->Ln(-2);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(110, 30, '12.    Foreign currency carried at your own arrangement :');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 30, $trainingInfo['own_currency']);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 30, '                                                                                            ______________________________');

$pdf->Ln(5);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(125, 37, '13.    Personal expenditure incurred during stay abroad (monthly)');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 37, $trainingInfo['monthly_expenditure']);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 37, '                                                                                                        ________________________');

$pdf->Ln(5);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(140, 42, '14.    Did you lose any of your personal items or money during your stay or on the way?');
$pdf->Ln(26);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(11, 0, '');
$pdf->MultiCell(160, 0, $trainingInfo['lose_personal_item']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, 0, '         _______________________________________________________________________','','1');

$pdf->Ln(5);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(120, 5, '15.    Have you cleared all bills from all concerned against you?');
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(11, 0, '');
$pdf->MultiCell(160, 0, $trainingInfo['bill_clear']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, 0, '         _______________________________________________________________________','','1');


$pdf->Ln(2);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '16.    Have you made any financial transaction with any foreigner or Bangladeshi national');
$pdf->Ln(0);
$pdf->Cell(0, 18, '         residing there? If yes, give details ');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 0, '');
$pdf->MultiCell(170, 5, $trainingInfo['financial_transaction']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '         _______________________________________________________________________','','1');

$pdf->SetFont('Arial', '', 12);
$pdf->Ln(5);
$pdf->Cell(130, 10, '17.    Total amount of foreign currency brought back to Bangladesh:');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, $trainingInfo['currency_back']);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, '                                                                                                             _____________________');

$pdf->Ln(7);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(160, 10, '18.    List a few names of your close friends in abroad who displayed keen interest  about  BAF');
$pdf->Ln(5);
$pdf->Cell(60, 10, '         or Bangladesh Armed Forces:');

//Foreign Friends Table Data Start
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(8);
$pdf->SetFillColor(240, 240, 240);
$pdf->Cell(10, 5, '', 0, 0);
$pdf->Cell(15, 5, 'Ser', 1, 0, 'C', 'true');
$pdf->Cell(75, 5, 'Name & Address', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Occupation', 1, 0, 'C', 'true');//end of line
$pdf->Cell(30, 5, 'Remark', 1, 1, 'C', 'true');//end of line

while ($item = mysqli_fetch_assoc($foreign_friends)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(10, 5, '', 0, 0);
    $pdf->Cell(15, 5, $item['ser_no'], 1, 0, 'C');
    $pdf->Cell(75, 5, $item['name_address'], 1, 0, 'C');
    $pdf->Cell(50, 5, $item['occupation'], 1, 0, 'C');//end of line
    $pdf->Cell(30, 5, $item['remarks'], 1, 1, 'C');//end of line
}
// Foreign Friends Table Data End

$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, 10, '19.    Was any foreigner exceptionally kind to you or came to help you out of difficulties.');
$pdf->Ln(0);
$pdf->Cell(40, 20, '         Give details:');

//Kind Foreigner Friends Table Data Start
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(12);
$pdf->SetFillColor(240, 240, 240);
$pdf->Cell(10, 5, '', 0, 0);
$pdf->Cell(15, 5, 'Ser', 1, 0, 'C', 'true');
$pdf->Cell(75, 5, 'Name & Address', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Occupation', 1, 0, 'C', 'true');//end of line
$pdf->Cell(30, 5, 'Remark', 1, 1, 'C', 'true');//end of line

while ($item = mysqli_fetch_assoc($kind_foreigner)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(10, 5, '', 0, 0);
    $pdf->Cell(15, 5, $item['ser_no'], 1, 0, 'C');
    $pdf->Cell(75, 5, $item['name_address'], 1, 0, 'C');
    $pdf->Cell(50, 5, $item['occupation'], 1, 0, 'C');//end of line
    $pdf->Cell(30, 5, $item['remarks'], 1, 1, 'C');//end of line
}
//Kind Foreigner Friends Table Data End

$pdf->Ln(5);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, 0, '20.    Did you contract/promise or were forced to marry any foreigner? If so, write in details');
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 0, '');
$pdf->MultiCell(170, 5, $trainingInfo['promise']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '         _______________________________________________________________________','','1');
$pdf->Cell(150, 12, '         _______________________________________________________________________');

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 5, '21.    Do you know if any of your fellow members made friendship or any agreement with any');
$pdf->Ln(0);
$pdf->Cell(0, 13, '         foreigner? If yes, furnish details: ');
$pdf->Ln(9);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 0, '');
$pdf->MultiCell(170, 5, $trainingInfo['friendship']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '         _______________________________________________________________________','','1');
$pdf->Cell(150, 12, '         _______________________________________________________________________');

$pdf->Ln(12);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '22.    Have you ever suspected any member of your team of having secret understanding with');
$pdf->Ln(0);
$pdf->Cell(0, 8, '         any foreigner? Write details');
$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 0, '');
$pdf->MultiCell(170, 5, $trainingInfo['classified_info']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '         _______________________________________________________________________','','1');
$pdf->Cell(150, 12, '         _______________________________________________________________________');

$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 12);

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '23.     During your stay abroad did you lose any service property or document? If yes, list them:');

//Lost Svc Item Table Data Start
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(5);
$pdf->SetFillColor(240, 240, 240);
$pdf->Cell(13, 5, '', 0, 0);
$pdf->Cell(15, 5, 'Ser', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Type of docu', 1, 0, 'C', 'true');
$pdf->Cell(70, 5, 'Place at which lost', 1, 0, 'C', 'true');//end of line
$pdf->Cell(30, 5, 'Remark', 1, 1, 'C', 'true');//end of line

while ($item = mysqli_fetch_assoc($lostSvcItem)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(13, 5, '', 0, 0);
    $pdf->Cell(15, 5, $item['ser_no'], 1, 0, 'C');
    $pdf->Cell(50, 5, $item['type_of_docu'], 1, 0, 'C');
    $pdf->Cell(70, 5, $item['place_of_lost'], 1, 0, 'C');//end of line
    $pdf->Cell(30, 5, $item['remarks'], 1, 1, 'C');//end of line
}
//Lost Svc Item Table Data End

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '24.     Have you or any member of your team encountered any difficulty or got involved in any');
$pdf->Ln(0);
$pdf->Cell(0, 10, '          problem/trouble? Give details ');
$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(11, 0, '');
$pdf->MultiCell(168, 5, $trainingInfo['difficulty']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '          ______________________________________________________________________','','1');
$pdf->Cell(150, 15, '          ______________________________________________________________________');

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '25.     Give Details of the places/institution where you submitted your bio-data:');
$header = array('Ser No', 'Place', 'Reasons');

//Bio-data Table Data Start
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(5);
$pdf->SetFillColor(240, 240, 240);
$pdf->Cell(13, 5, '', 0, 0);
$pdf->Cell(15, 5, 'Ser', 1, 0, 'C', 'true');
$pdf->Cell(100, 5, 'Place/Name of the Institution', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Reasons/Remark', 1, 1, 'C', 'true');//end of line

while ($item = mysqli_fetch_assoc($institution)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(13, 5, '', 0, 0);
    $pdf->Cell(15, 5, $item['ser_no'], 1, 0, 'C');
    $pdf->Cell(100, 5, $item['name_of_institution'], 1, 0, 'C');
    $pdf->Cell(50, 5, $item['remarks'], 1, 1, 'C');//end of line
}
//Bio-Data Table Data End

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '26.     Have you ever suspected any member of your team of having secret understanding with');
$pdf->Ln(0);
$pdf->Cell(0, 10, '          any foreigner? Write in details ');
$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(11, 0, '');
$pdf->MultiCell(168, 5, $trainingInfo['secret_understanding']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '          ______________________________________________________________________','','1');
$pdf->Cell(150, 15, '          ______________________________________________________________________');

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '27.     Details of the foreign intelligence network or spy if you could observe them ');
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(11, 0, '');
$pdf->MultiCell(168, 5, $trainingInfo['foreign_spy']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '          ______________________________________________________________________','','1');
$pdf->Cell(150, 15, '          ______________________________________________________________________');

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '28.     Write in details about the interest of foreigner on military, political, social and economic');
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(11, 0, '');
$pdf->MultiCell(168, 5, $trainingInfo['interest_of_foreigner']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '          ______________________________________________________________________','','1');
$pdf->Cell(150, 15, '          ______________________________________________________________________');

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '29.     General impression of the foreigner and their Govt about Bangladesh (to include views,');
$pdf->Ln(5);
$pdf->Cell(0, 0, '          opinions, expressed by high officials/published in thier media) ');
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(11, 0, '');
$pdf->MultiCell(160, 5, $trainingInfo['impression_about_bd']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '          ______________________________________________________________________','','1');
$pdf->Cell(150, 15, '          ______________________________________________________________________');

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '30.     Details of the mil/industrial sites visited/stayed: (add map/photo to furnish this column)');

//Mil Site Visit Table Data Start
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(5);
$pdf->Cell(13, 5, '', 0, 0);
$pdf->Cell(15, 5, 'Ser', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Place', 1, 0, 'C', 'true');
$pdf->Cell(100, 5, 'Importance', 1, 1, 'C', 'true');//end of line

while ($item = mysqli_fetch_assoc($milSiteInfo)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(13, 5, '', 0, 0);
    $pdf->Cell(15, 5, $item['ser_no'], 1, 0, 'C');
    $pdf->Cell(50, 5, $item['place'], 1, 0, 'C');
    $pdf->Cell(100, 5, $item['importance'], 1, 1, 'C');//end of line
}
// Mil Site visit Table Data End

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '31.     Give a pen picture about the political, social, mil and security system of the country:');
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(11, 0, '');
$pdf->MultiCell(168, 5, $trainingInfo['pen_picture']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '          ______________________________________________________________________','','1');
$pdf->Cell(150, 15, '          ______________________________________________________________________');


$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 12);

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '32.     Details of the meeting with military and civil high officials:');

//Mil Meeting Table Data Start
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(5);
$pdf->Cell(13, 5, '', 0, 0);
$pdf->Cell(15, 5, 'Ser', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Particulars', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Appointment', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Purpose of Meeting', 1, 1, 'C', 'true');//end of line

while ($item = mysqli_fetch_assoc($milMeetInfo)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(13, 5, '', 0, 0);
    $pdf->Cell(15, 5, $item['ser_no'], 1, 0, 'C');
    $pdf->Cell(50, 5, $item['particulars'], 1, 0, 'C');
    $pdf->Cell(50, 5, $item['appointment'], 1, 0, 'C');
    $pdf->Cell(50, 5, $item['purpose_of_meeting'], 1, 1, 'C');//end of line
}
// Mil Meeting Table Data End

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '33.     Did you become a member of any foreign organization/club/association? Give details:');

//Club Table Data Start
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(5);
$pdf->Cell(13, 5, '', 0, 0);
$pdf->Cell(15, 5, 'Ser', 1, 0, 'C', 'true');
$pdf->Cell(100, 5, 'Name of Club/Org', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Remarks', 1, 1, 'C', 'true');//end of line

while ($item = mysqli_fetch_assoc($clubMemberInfo)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(13, 5, '', 0, 0);
    $pdf->Cell(15, 5, $item['ser_no'], 1, 0, 'C');
    $pdf->Cell(100, 5, $item['name_of_club'], 1, 0, 'C');
    $pdf->Cell(50, 5, $item['remarks'], 1, 1, 'C');//end of line
}
//Club Table Data End

$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(80, 20, '34.    Write important social and security problem of the visited country ');
$pdf->Ln(12);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(11, 0, '');
$pdf->MultiCell(168, 5, $trainingInfo['security_problem']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '          ______________________________________________________________________','','1');
$pdf->Cell(150, 15, '          ______________________________________________________________________');

$pdf->Ln(5);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(80, 20, '35.    Latest Development and progress in the military field of the country visited ');
$pdf->Ln(12);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(11, 0, '');
$pdf->MultiCell(168, 5, $trainingInfo['progress_in_military']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, -3, '          ______________________________________________________________________','','1');
$pdf->Cell(150, 15, '          ______________________________________________________________________');

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, '36.    Particulars of gift received from foreign nationals: (you may incl the gift items for nec');
$pdf->Ln(0);
$pdf->Cell(0, 10, '         clearance as per AFO 113-13 dated 12 March 1996)');

//Gift Table Data Start
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(10);
$pdf->Cell(12, 5, 'Ser', 1, 0, 'C', 'true');
$pdf->Cell(37, 5, 'Gift Details', 1, 0, 'C', 'true');
$pdf->Cell(20, 5, 'Date', 1, 0, 'C', 'true');
$pdf->Cell(30, 5, 'Gift Value', 1, 0, 'C', 'true');
$pdf->Cell(60, 5, 'Name of Dignitary/Institute', 1, 0, 'C', 'true');
$pdf->Cell(20, 5, 'Remarks', 1, 1, 'C', 'true');//end of line

while ($item = mysqli_fetch_assoc($giftInfo)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(12, 5, $item['ser_no'], 1, 0, 'C');
    $pdf->Cell(37, 5, $item['details_of_gift_received'], 1, 0, 'C');
    $pdf->Cell(20, 5, $item['gift_date'], 1, 0, 'C');
    $pdf->Cell(30, 5, $item['approx_value'], 1, 0, 'C');
    $pdf->Cell(60, 5, $item['dignitary_name'], 1, 0, 'C');
    $pdf->Cell(20, 5, $item['remarks'], 1, 1, 'C');//end of line
}
//Gift Table Data End

$pdf->Ln(5);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(90, 20, '37.    a.     Have you purchased any fire arms?');
$pdf->SetFont('Arial', 'BU', 12);
$pdf->Cell(40, 20, $trainingInfo['fire_arm']);

$pdf->Ln(5);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(80, 20, '         b.     If yes, fill up the boxes:');

//Arms Table Data Start
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(15);
$pdf->Cell(12, 5, '', 0, 0);
$pdf->Cell(15, 5, 'Ser', 1, 0, 'C', 'true');
$pdf->Cell(40, 5, 'Arms Type', 1, 0, 'C', 'true');
$pdf->Cell(30, 5, 'Price', 1, 0, 'C', 'true');
$pdf->Cell(50, 5, 'Permission', 1, 0, 'C', 'true');
$pdf->Cell(30, 5, 'Remarks', 1, 1, 'C', 'true');//end of line

while ($item = mysqli_fetch_assoc($armsInfo)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(12, 5, '', 0, 0);
    $pdf->Cell(15, 5, $item['ser_no'], 1, 0, 'C');
    $pdf->Cell(40, 5, $item['type_of_arm'], 1, 0, 'C');
    $pdf->Cell(30, 5, $item['price'], 1, 0, 'C');
    $pdf->Cell(50, 5, $item['permission_taken_from'], 1, 0, 'C');
    $pdf->Cell(30, 5, $item['remarks'], 1, 1, 'C');//end of line
}
//Arms Table Data End

$pdf->Ln(10);
$pdf->SetFont('Arial', 'BI', 12);
$pdf->Cell(150, 0, ' *  I  hereby  certified  that  the  information  given  above  are  correct  to  the  best  of  my');
$pdf->Ln(5);
$pdf->Cell(150, 0, ' knowledge belief and I shall be liable of disciplinary action for giving any wrong statement.');

$pdf->Ln(20);
$pdf->SetFont('Arial','',12);
$pdf->Cell(100,0,'    ');
$pdf->SetFont('Arial','B'.'U',12);
$pdf->Cell(0,0,'Submitted By');
$pdf->Ln(10);
$pdf->SetFont('Arial','',12);
$pdf->Cell(100,0,'    ');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(17,0,'Name  : ');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0,$personelInfo['name']);
$pdf->Ln(0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(116,0,'    ');
$pdf->Cell(0,0,'___________________________');
$pdf->Ln(5);
$pdf->SetFont('Arial','',12);
$pdf->Cell(100,0,'    ');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(17,0,'Rank   : ');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0,$personelInfo['rank']);
$pdf->Ln(0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(116,0,'    ');
$pdf->Cell(0,0,'___________________________');

$date = date('d M y',strtotime($trainingInfo['submit_date']));
$pdf->Ln(5);
$pdf->SetFont('Arial','',12);
$pdf->Cell(13,0,'Date : ');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,0,$date);
$pdf->SetFont('Arial','',12);
$pdf->Cell(67,0,'    ');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(17,0,'BD No :');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,0,$personelInfo['bd_no']);
$pdf->Ln(0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(116,0,'    ');
$pdf->Cell(0,0,'___________________________');
ob_clean();
$pdf->Output('I', $personelInfo['bd_no'] . '_f_20389' . '.pdf');
?>
