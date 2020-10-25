<?php
session_start();
//include connection file
include_once("../config.php");
include_once('libs/fpdf.php');
$bd_no=$_GET['bd_no'];
$visit_id=$_GET['visit_info_id'];

class PDF extends FPDF
{
// Page header
    function Header()
    {
        // Logo
        //$this->Image('logo.png',10,-1,70);

        $this->SetY(15);

        $this->SetFont('Arial','',12);
        // Title
        $this->Ln(0);
        $this->Cell(0,0,'CONFIDENTIAL',0,0,'C');
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-25);
        // Arial italic 8
        $this->SetFont('Arial','',12);
        // Page number
        $this->Cell(0,10,$this->PageNo(),0,0,'C');
        $this->Ln(0);
        $this->Cell(0,20,'CONFIDENTIAL',0,0,'C');
    }
    function FancyTable($header, $tableData)
    {
        // Colors, line width and bold font
        $this->SetFillColor(240,240,240);
        $this->SetTextColor(0,0,0);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(0);
        $this->SetFont('Arial','B');
        // Table Header

        for($i=0;$i<count($header);$i++){
            $this->Cell(32,7,$header[$i],1,0,'C',true);
        }
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('Arial');
        // Data

        foreach($tableData as $row)
        {
            $this->Ln();
            $this->Cell(12,0,'   ');

            foreach($row as $column){
                $this->Cell(32,8,$column,1,0,'C');
            }
        }
    }
    function ServiceItemTable($header, $transitInfo)
    {
        // Colors, line width and bold font
        $this->SetFillColor(240,240,240);
        $this->SetTextColor(0,0,0);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(0);
        $this->SetFont('Arial','B');
        // Table Header

        for($i=0;$i<count($header);$i++){
            $this->Cell(50,7,$header[$i],1,0,'C',true);
        }
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('Arial');
        // Data

        foreach($transitInfo as $row)
        {
            $this->Ln();
            $this->Cell(12,0,'   ');

            foreach($row as $column){
                $this->Cell(50,8,$column,1,0,'C');
            }
        }
    }
}

    $personelInfo = mysqli_query($link, "SELECT * FROM new_users WHERE bd_no='$bd_no'") or die("database error:". mysqli_error($link));
    $personelInfo = mysqli_fetch_assoc($personelInfo);

    $visitInfo = mysqli_query($link, "SELECT * FROM briefing_20387_visit_info WHERE bd_no='$bd_no'&&visit_info_id='$visit_id'") or die("database error:". mysqli_error($link));
    $visitInfo = mysqli_fetch_assoc($visitInfo);

    $genInst = mysqli_query($link, "SELECT * FROM briefing_gen_inst") or die("database error:". mysqli_error($link));
    $genInstInfo = mysqli_fetch_assoc($genInst);

    $transitInfo = mysqli_query($link, "SELECT ser_no,country,duration,purpose FROM briefing_20387_transit_info WHERE bd_no='$bd_no'&&visit_info_id='$visit_id' ORDER BY id") or die("database error:". mysqli_error($link));

    $pastVisitInfo = mysqli_query($link, "SELECT ser_no,country,purpose,duration,remarks FROM briefing_20387_past_visit_info WHERE bd_no='$bd_no'&&visit_info_id='$visit_id' ORDER BY id") or die("database error:". mysqli_error($link));

    $familyMembersInfo = mysqli_query($link, "SELECT ser_no,family_name,relation,departure_date FROM briefing_20387_family_members_info WHERE bd_no='$bd_no'&&visit_info_id='$visit_id' ORDER BY id") or die("database error:". mysqli_error($link));

    $sponsorInfo = mysqli_query($link, "SELECT ser_no,sponsor_name,occupation,relation,address FROM briefing_20387_sponsor_relative_info WHERE bd_no='$bd_no'&&visit_info_id='$visit_id' ORDER BY id") or die("database error:". mysqli_error($link));

    $serviceItemInfo = mysqli_query($link, "SELECT ser_no,details FROM briefing_20387_service_item_info WHERE bd_no='$bd_no'&&visit_info_id='$visit_id' ORDER BY id") or die("database error:". mysqli_error($link));

    $pdf = new PDF('P','mm','A4');
    //header
    $pdf->AddPage();
    //foter page
    $pdf->AliasNbPages();
    $pdf->SetFont('Arial','',12);
    $pdf->SetMargins(20,0,20);

    $pdf->Ln(1);
    $pdf->Cell(0,10,'(When filled in)',0,0,'C');
$pdf->Ln(0);
$pdf->Cell(180,10,'F-20387',0,0,'R');
    $pdf->Ln(1);
$pdf->SetFont('Arial','BU',12);
$pdf->Cell(0,25,'DIRECTORATE OF AIR INTELLIGENCE',0,0,'C');
    $pdf->Ln(1);
    $pdf->Cell(0,32,'INTELLIGENCE BRIEFING WHILE PROCEEDING ABROAD',0,0,'C');
    $pdf->Ln(1);
$pdf->SetFont('Arial','BI',12);

$pdf->Cell(0,45,'(All BAF personnel are to fill up this form prior to their  departure  abroad.  All  are  to  go',0,0,'');
    $pdf->Ln(1);
    $pdf->Cell(0,55,'through the instructions given in annex "A" and related AFO\'s and  comply  accordingly)',0,0,'');
    $pdf->Ln(1);
    $pdf->Cell(0,65,'during their stay abroad.)',0,0,'');
    // Line break
    $pdf->Ln(1);

    $pdf->SetFont('Arial','',12);

    $pdf->Cell(25,80,'1.    Name:','','');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(70,80,$personelInfo['name']);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(25,80,'2.    Rank:');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20,80,'             '.$personelInfo['rank']);
    $pdf->Ln(0);
$pdf->SetFont('Arial','',12);

$pdf->Cell(35,80,'                   ______________________________                     __________________________');

    $pdf->Ln(0);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(25,95,'3.    BD No:');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(70,95,$personelInfo['bd_no']);

    $pdf->SetFont('Arial','',12);
    $pdf->Cell(40,95,'4.    Branch/Trade:');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(35,95,$personelInfo['br_trade']);
    $pdf->Ln(0);
$pdf->SetFont('Arial','',12);

$pdf->Cell(35,95,'                   ______________________________                                 ____________________');

    $pdf->Ln(0);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(25,110,'5.    Unit:');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(70,110,$visitInfo['unit']);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(35,110,'6.    Passport No:');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(40,110,'    '.$visitInfo['passport_no']);
$pdf->Ln(0);
$pdf->SetFont('Arial','',12);

$pdf->Cell(35,110,'                   ______________________________                               _____________________');

$pdf->Ln(0);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(45,125,'7.    Purpose of visit:');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20,125,$visitInfo['purpose_of_visit']);
$pdf->Ln(0);
$pdf->SetFont('Arial','',12);

$pdf->Cell(35,125,'                                  ___________________________________________________________');

$pdf->Ln(0);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(70,140,'8.    Destination Country: Airport:');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(40,140,$visitInfo['destination_airport']);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(25,140,'    Country:');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20,140,$visitInfo['destination_country']);
    $pdf->Ln(0);
$pdf->SetFont('Arial','',12);

$pdf->Cell(35,140,'                                                    ___________________                      ____________________');

    //Transit Table Data
    $pdf->Ln(80);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(120,0,'9.    Transit country/countries(other than ser no 8):');

   //Transit Table Data Start
$pdf->SetFont('Arial','B',12);
$pdf->Ln(5);
$pdf->SetFillColor(240,240,240);
$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(15	,5,'Ser',1,0,'C','true');
$pdf->Cell(50	,5,'Country',1,0,'C','true');
$pdf->Cell(50,5,'Duration',1,0,'C','true');
$pdf->Cell(55,5,'Purpose',1,1,'C','true');//end of line

while($item = mysqli_fetch_assoc($transitInfo)){
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(15	,5,$item['ser_no'],1,0,'C');
    $pdf->Cell(50	,5,$item['country'],1,0,'');
    $pdf->Cell(50,5,$item['duration'],1,0,'');
    $pdf->Cell(55,5,$item['purpose'],1,1,'');//end of line
}
// Transit Table Data End

    $pdf->Ln(0);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(50,40,'10.    Date of Departure:');
    $pdf->SetFont('Arial','B',12);
    $date = date('d M Y',strtotime($visitInfo['date_of_reaching_destination']));
    $pdf->Cell(40,40,$date);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(50,40,'11.    Place of Departure:');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(40,40,$visitInfo['departure_place']);
    $pdf->Ln(0);
$pdf->SetFont('Arial','',12);

$pdf->Cell(35,40,'                                       __________________                                           _________________');

$pdf->Ln(0);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(80,55,'12.    Name of the carrier with flight no:');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(40,55,$visitInfo['name_of_airlines']);
    $pdf->Ln(0);
$pdf->SetFont('Arial','',12);

$pdf->Cell(35,55,'                                                                ____________________________________________');

    $pdf->Ln(0);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(80,70,'13.    Date of reaching destination:');
    $pdf->SetFont('Arial','B',12);
    $date = date('d M Y',strtotime($visitInfo['date_of_reaching_destination']));
    $pdf->Cell(40,70,$date);
    $pdf->Ln(0);
$pdf->SetFont('Arial','',12);

$pdf->Cell(35,70,'                                                        ________________________________________________');

$pdf->Ln(8);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(80,70,'14.    Duration of stay abroad:');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(40,70,$visitInfo['duration_of_stay_abroad']);
$pdf->Ln(0);
$pdf->SetFont('Arial','',12);

$pdf->Cell(35,70,'                                                    __________________________________________________');

    //Past visit table data
    $pdf->Ln(45);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(120,0,'15.    Details visit abroad in the past (in the last 05 years):');

//Past visit Table Data Start
$pdf->SetFont('Arial','B',12);
$pdf->Ln(5);
$pdf->SetFillColor(240,240,240);
$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(15	,5,'Ser',1,0,'C','true');
$pdf->Cell(30	,5,'Country',1,0,'C','true');
$pdf->Cell(40,5,'Purpose',1,0,'C','true');//end of line
$pdf->Cell(50,5,'Duration',1,0,'C','true');//end of line
$pdf->Cell(35,5,'Remarks',1,1,'C','true');//end of line

while($item = mysqli_fetch_assoc($pastVisitInfo)){
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(15	,5,$item['ser_no'],1,0,'C');
    $pdf->Cell(30	,5,$item['country'],1,0,'');
    $pdf->Cell(40,5,$item['purpose'],1,0,'');
    $pdf->Cell(50,5,$item['duration'],1,0,'');
    $pdf->Cell(35,5,$item['remarks'],1,1,'');//end of line
}
//Past visit Table Data End

    //Family members table data
    $pdf->Ln(20);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(200,0,'16.    Particulars of the family members traveling with you or likely to accompany later:');

//Family members Table Data Start
$pdf->SetFont('Arial','B',12);
$pdf->Ln(5);
$pdf->SetFillColor(240,240,240);
$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(15	,5,'Ser',1,0,'C','true');
$pdf->Cell(60	,5,'Name',1,0,'C','true');
$pdf->Cell(50,5,'Relation',1,0,'C','true');//end of line
$pdf->Cell(45,5,'Departure Date',1,1,'C','true');//end of line

while($item = mysqli_fetch_assoc($familyMembersInfo)){
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(15	,5,$item['ser_no'],1,0,'C');
    $pdf->Cell(60	,5,$item['family_name'],1,0,'');
    $pdf->Cell(50,5,$item['relation'],1,0,'');
    $pdf->Cell(45,5,$item['departure_date'],1,1,'');//end of line
}
//Family members Table Data End

    $pdf->AddPage();
    //foter page
    $pdf->AliasNbPages();
    $pdf->SetFont('Arial','',12);

    //Sponsor/relative/friends table data
    $pdf->Ln(10);
    $pdf->Cell(200,0,'17.    Particulars  of  the  sponsor/ relative/ friends in the visiting country who may help you in an');
    $pdf->Ln(5);
    $pdf->Cell(20,0,'         emergency:');

//Family members Table Data Start
$pdf->SetFont('Arial','B',12);
$pdf->Ln(5);
$pdf->SetFillColor(240,240,240);
$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(15	,5,'Ser',1,0,'C','true');
$pdf->Cell(40	,5,'Name',1,0,'C','true');
$pdf->Cell(35	,5,'Occupation',1,0,'C','true');
$pdf->Cell(40,5,'Relation',1,0,'C','true');//end of line
$pdf->Cell(40,5,'Address',1,1,'C','true');//end of line

while($item = mysqli_fetch_assoc($sponsorInfo)){
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(15	,5,$item['ser_no'],1,0,'C');
    $pdf->Cell(40	,5,$item['sponsor_name'],1,0,'');
    $pdf->Cell(35,5,$item['occupation'],1,0,'');
    $pdf->Cell(40,5,$item['relation'],1,0,'');
    $pdf->Cell(40,5,$item['address'],1,1,'');//end of line
}
//Family members Table Data End

    //Sponsor/relative/friends table data
    $pdf->Ln(15);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(200,0,'18.    List of service item carried with you:');

//Svc Item Family members Table Data Start
$pdf->SetFont('Arial','B',12);
$pdf->Ln(5);
$pdf->SetFillColor(240,240,240);
$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(15	,5,'Ser',1,0,'C','true');
$pdf->Cell(155,5,'Item Details',1,1,'C','true');//end of line

while($item = mysqli_fetch_assoc($serviceItemInfo)){
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10	,5,'',0,0);
    $pdf->Cell(15	,5,$item['ser_no'],1,0,'C');
    $pdf->Cell(155,5,$item['details'],1,1,'');//end of line
}
//Svc Item Table Data End

    $pdf->Ln(15);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(140,0,'19.     Total amount of money being credited to you for the course/visit :  ');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,0,$visitInfo['total_money']);
$pdf->Ln(0);
$pdf->SetFont('Arial','',12);

$pdf->Cell(35,0,'                                                                                                                   ___________________');

    $pdf->Ln(10);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(150,0,'20.     Are you taking any personal money with you? If yes, state the amount :  ');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,0,$visitInfo['personal_money']);
$pdf->Ln(0);
$pdf->SetFont('Arial','',12);

$pdf->Cell(35,0,'                                                                                                                           _______________');

    $pdf->Ln(10);
    $pdf->SetFont('Arial','BI',11);
    $pdf->Cell(150,0,' *  I hereby certified that the information given above  are  correct  to  the  best  of  my  knowledge');
    $pdf->Ln(5);
    $pdf->Cell(150,0,'belief and I shall be liable of disciplinary action for giving any wrong statement.');

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

$date = date('d M Y',strtotime($visitInfo['submit_date']));
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


$pdf->SetFont('Arial','',12);
$pdf->Ln(15);
$pdf->Cell(150,0,'Annex:');
$pdf->Ln(10);
$pdf->Cell(150,0,'A.      General Instruction for BAF personnel while proceeding abroad. ');
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetMargins(20, 0, 10);

$pdf->Ln(5);
$pdf->SetFont('Arial',  'U', 12);
$pdf->Cell(0, 0, 'ANNEX \'A\' TO           ', 0, 0, 'R');
$pdf->Cell(0, 10, 'INT BRIEF                 ', 0, 0, 'R');
$pdf->Cell(0, 20, 'DATED:                     ', 0, 0, 'R');
$pdf->Ln(10);$pdf->Ln(10);
$pdf->SetFont('Arial', 'B' . 'U', 12);
$pdf->Cell(0, 0, 'GENERAL INSTRUCTIONS FOR BAF PERSONNEL WHILE PROCEEDING ABROAD', 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(150, 0, '1.    The  following  general  instruction  are  to  be  followed  by  BAF  personal during their stay abroad:');
$pdf->Ln(5);
/*$pdf->Cell(0, 0, '      a.     Discussion  on  military,  political,  social  &  economic  matters  contrary  to  the  interest of the','','','J');
$pdf->Ln(0);
$pdf->Cell(0, 10, '              BAF/country is prohibited.','','','J');
$pdf->Ln(0);
$pdf->Cell(150, 20, '      b.     Do not get allured by wine, wealth or unsocial activities.','','','J');
$pdf->Ln(0);
$pdf->Cell(150, 30, '      c.     No classified information shall be discussed with foreigners/unauthorized persons.');
$pdf->Ln(0);
$pdf->Cell(150, 40, '      d.     Be very careful about the spy and foreign intelligence agencies.');
$pdf->Ln(0);
$pdf->Cell(150, 50, '      e.     At  all  the  time  remains  aware  of  the  relation  between  Bangladesh  and  visiting   country.');
$pdf->Ln(0);
$pdf->Cell(150, 60, '      f.      Maintain a high standard of discipline.');
$pdf->Ln(0);
$pdf->Cell(150, 70, '      g.     Do not become a member of any social, cultural or any other clun/organisations or association.');
$pdf->Ln(0);
$pdf->Cell(150, 80, '      h.     Try to avoid invitation and taking/giving gift from/to foreigners. However,  gifts  received  under');
$pdf->Ln(0);
$pdf->Cell(150, 90, '              unavoidable circumstances to be forwarded to this directorate upon arrival as per AFO 113-13');
$pdf->Ln(0);
$pdf->Cell(150, 100, '              dated 12 March 1996 for necessary clearance.');
$pdf->Ln(0);
$pdf->Cell(150, 110, '      j.      Do  not  make   any   agreement  with  the   foreigners   unless  you  are  authorized  to  do  so.');
$pdf->Ln(0);
$pdf->Cell(150, 120, '      k.     Do not accept any cash as gift/payment/gesture under any circumstances.');
$pdf->Ln(0);
$pdf->Cell(150, 130, '      l.      Take  care  of   your   valuable   belonging   specially   passport,   official   documents,   foreign');
$pdf->Ln(0);
$pdf->Cell(150, 140, '              currency etc. Do not exchange your foreign currency with illegal and unauthorized dealers.');
$pdf->Ln(0);
$pdf->Cell(150, 150, '      m.    Do not make any reference/note of classified matters on your personal diaries.');
$pdf->Ln(0);
$pdf->Cell(150, 160, '      n.     Check your  personal  album.  Do  not  carry  any  photographs  containing  picture  or  military');
$pdf->Ln(0);
$pdf->Cell(150, 170, '              installations/equipments/sites.');
$pdf->Ln(0);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(150, 180, '      p.     For  india  visit  please  collect  contact  number  of   defence   Wing,   Bangladesh  High');
$pdf->Ln(0);
$pdf->Cell(150, 190, '              Commission,  India  and  intimate  about  you  immediately  after  arrival.  you  are   also');
$pdf->Ln(0);
$pdf->Cell(150, 200, '              advised to contact imm to defence Wing if any unwanted situation occurs.');
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 11);

$pdf->Cell(150, 210, '      q.     Do not carry any letter/document from the visiting country by hand for  onward handed over to');
$pdf->Ln(110);
$pdf->Cell(150, 0, '              respective Embassy/High Commission in Bangladesh.');
$pdf->Ln(0);
$pdf->Cell(150, 10, '      r.      Special Instruction (If any).');*/
$pdf->MultiCell(0, 5, $genInstInfo['gen_inst']);
$pdf->Ln(0);
$pdf->SetFont('Arial', '', 12);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(10);
$pdf->Cell(7, 0, '      ');
$pdf->MultiCell(0,5, $visitInfo['special_instruction']);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, -3, '      _________________________________________________________________________');
$pdf->SetFont('Arial', 'BI', 11);
$pdf->Ln(0);
$pdf->Cell(150, 15, '* I have read and understood AFO 200-2 dated 22 Apr 1990, AFO 113-13 dated 12 March 1996 and');
$pdf->Ln(0);
$pdf->Cell(150, 25, 'above mentioned instructions & will comply with these. Any violation of this order will render me');
$pdf->Ln(0);
$pdf->Cell(150, 35, 'liable to disciplinary action. I am also aware of the points for debrief.');

$pdf->Ln(25);
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

$date = date('d M Y',strtotime($visitInfo['submit_date']));
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

$pdf->SetFont('Arial', 'B' . 'U', 12);
$pdf->Ln(8);
$pdf->Cell(60, 0, '', 0, 0, '');
$pdf->Cell(0, 0, 'COUNTERSIGN', 0, 0, '');

ob_clean();
$pdf->Output('I',$personelInfo['bd_no'] . '_f_20387' . '.pdf');
?>
