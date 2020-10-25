<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: ../index.php');
} else {
    //Visit id increase code start
    include('../config.php');
    $sql = "SELECT visit_info_id FROM debrief_20389_training_info WHERE bd_no='$_SESSION[bd_no]' ORDER BY visit_info_id DESC LIMIT 1";
    if (mysqli_query($link, $sql)) {
        $visitId = mysqli_query($link, $sql);
        $visitId = mysqli_fetch_assoc($visitId);
        $visitId = $visitId['visit_info_id'];
        $_SESSION['visitId'] = ++$visitId;
    } else {
        $_SESSION['visitId'] = 1;
    }
    //Visit id increase code end
}

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'logout') {
        require_once('../Login.php');
        $logout = new Login();
        $message = $logout->adminLogout();
        $_SESSION['message'] = $message;
    }
}

$message = '';
if (isset($_POST['btn_submit'])) {
    require_once '../Briefing.php';
    $breifing = new Briefing();
    $message = $breifing->makeUserActive();
    $message .= $breifing->saveDebriefTrainingData();
    header('Location: homepage.php');
}
include('f_header.php');
?>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="well">
                <h4 class="text-center text-warning"><?php //echo "Visit ID :". $_SESSION['visitId']." Group ID :". $_SESSION['groupId'];  ?></h4>
                <h3 class="text-center text-default"><b><u>DIRECTORATE OF AIR INTELLIGENCE <br> INTELLIGENCE DE-BRIEFING
                            ON RETURN FROM COURSE ABROAD</u></b></h3>
                <h4 class="text-center text-default">(This form is prepared in accordance with AFO 200-2 dated 22 Apr
                    1990. Following info are to be furnished by all
                    BAF personnel returning from abroad. You may be add extra papers, documents, photos and maps to
                    furnish your report). </h4>

                <form class="form" id="f_20389" method="POST" action="" data-toggle="validator">
                    <input type="hidden" name="type_of_visit" value="de_brief_training">

                    <div class="form-group row has-feedback">
                        <div class="field col-md-12">
                            <label for="full_name">1. Name</label>
                            <input value="<?php echo $_SESSION['name'] ?>" class="form-control" disabled>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>2. Rank</label>
                            <input name="rank" value="<?php echo $_SESSION['rank'] ?>" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>3. BD/No</label>
                            <input type="number" class="form-control" id="bd_no" name="bd_no"
                                   value="<?php echo $_SESSION['bd_no']; ?>" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>4. Branch/Trade</label>
                            <input value="<?php echo $_SESSION['br_trade'] ?>" class="form-control" disabled>
                        </div>
                        <div class="col-md-6">
                            <label  class="required">5. Unit </label>
                            <input type="text" class="form-control" id="unit" name="unit" placeholder="Unit">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="required">6. Total duration of staying abroad: From </label>
                            <input type="date" class="form-control" name="duration_of_stay_from" placeholder="From">
                        </div>
                        <div class="col-md-6">
                            <label>To </label>
                            <input type="date" class="form-control" name="duration_of_stay_to" placeholder="To">
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label class="required">7. Country at which the course was conducted</label>
                            <select id="destination_country" name="destination_country" class="form-control" required data-error="Select your Destination Country!">
                                <option value="">--Select Country--</option>
                                <option value="Afghanistan">Afghanistan</option>
                                <option value="Åland Islands">Åland Islands</option>
                                <option value="Albania">Albania</option>
                                <option value="Algeria">Algeria</option>
                                <option value="American Samoa">American Samoa</option>
                                <option value="Andorra">Andorra</option>
                                <option value="Angola">Angola</option>
                                <option value="Anguilla">Anguilla</option>
                                <option value="Antarctica">Antarctica</option>
                                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                <option value="Argentina">Argentina</option>
                                <option value="Armenia">Armenia</option>
                                <option value="Aruba">Aruba</option>
                                <option value="Australia">Australia</option>
                                <option value="Austria">Austria</option>
                                <option value="Azerbaijan">Azerbaijan</option>
                                <option value="Bahamas">Bahamas</option>
                                <option value="Bahrain">Bahrain</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="Barbados">Barbados</option>
                                <option value="Belarus">Belarus</option>
                                <option value="Belgium">Belgium</option>
                                <option value="Belize">Belize</option>
                                <option value="Benin">Benin</option>
                                <option value="Bermuda">Bermuda</option>
                                <option value="Bhutan">Bhutan</option>
                                <option value="Bolivia">Bolivia</option>
                                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                <option value="Botswana">Botswana</option>
                                <option value="Bouvet Island">Bouvet Island</option>
                                <option value="Brazil">Brazil</option>
                                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                <option value="Brunei Darussalam">Brunei Darussalam</option>
                                <option value="Bulgaria">Bulgaria</option>
                                <option value="Burkina Faso">Burkina Faso</option>
                                <option value="Burundi">Burundi</option>
                                <option value="Cambodia">Cambodia</option>
                                <option value="Cameroon">Cameroon</option>
                                <option value="Canada">Canada</option>
                                <option value="Cape Verde">Cape Verde</option>
                                <option value="Cayman Islands">Cayman Islands</option>
                                <option value="Central African Republic">Central African Republic</option>
                                <option value="Chad">Chad</option>
                                <option value="Chile">Chile</option>
                                <option value="China">China</option>
                                <option value="Christmas Island">Christmas Island</option>
                                <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Comoros">Comoros</option>
                                <option value="Congo">Congo</option>
                                <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                                <option value="Cook Islands">Cook Islands</option>
                                <option value="Costa Rica">Costa Rica</option>
                                <option value="Cote D'ivoire">Cote D'ivoire</option>
                                <option value="Croatia">Croatia</option>
                                <option value="Cuba">Cuba</option>
                                <option value="Cyprus">Cyprus</option>
                                <option value="Czech Republic">Czech Republic</option>
                                <option value="Denmark">Denmark</option>
                                <option value="Djibouti">Djibouti</option>
                                <option value="Dominica">Dominica</option>
                                <option value="Dominican Republic">Dominican Republic</option>
                                <option value="Ecuador">Ecuador</option>
                                <option value="Egypt">Egypt</option>
                                <option value="El Salvador">El Salvador</option>
                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                <option value="Eritrea">Eritrea</option>
                                <option value="Estonia">Estonia</option>
                                <option value="Ethiopia">Ethiopia</option>
                                <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                <option value="Faroe Islands">Faroe Islands</option>
                                <option value="Fiji">Fiji</option>
                                <option value="Finland">Finland</option>
                                <option value="France">France</option>
                                <option value="French Guiana">French Guiana</option>
                                <option value="French Polynesia">French Polynesia</option>
                                <option value="French Southern Territories">French Southern Territories</option>
                                <option value="Gabon">Gabon</option>
                                <option value="Gambia">Gambia</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Germany">Germany</option>
                                <option value="Ghana">Ghana</option>
                                <option value="Gibraltar">Gibraltar</option>
                                <option value="Greece">Greece</option>
                                <option value="Greenland">Greenland</option>
                                <option value="Grenada">Grenada</option>
                                <option value="Guadeloupe">Guadeloupe</option>
                                <option value="Guam">Guam</option>
                                <option value="Guatemala">Guatemala</option>
                                <option value="Guernsey">Guernsey</option>
                                <option value="Guinea">Guinea</option>
                                <option value="Guinea-bissau">Guinea-bissau</option>
                                <option value="Guyana">Guyana</option>
                                <option value="Haiti">Haiti</option>
                                <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                                <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                                <option value="Honduras">Honduras</option>
                                <option value="Hong Kong">Hong Kong</option>
                                <option value="Hungary">Hungary</option>
                                <option value="Iceland">Iceland</option>
                                <option value="India">India</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                                <option value="Iraq">Iraq</option>
                                <option value="Ireland">Ireland</option>
                                <option value="Isle of Man">Isle of Man</option>
                                <option value="Israel">Israel</option>
                                <option value="Italy">Italy</option>
                                <option value="Jamaica">Jamaica</option>
                                <option value="Japan">Japan</option>
                                <option value="Jersey">Jersey</option>
                                <option value="Jordan">Jordan</option>
                                <option value="Kazakhstan">Kazakhstan</option>
                                <option value="Kenya">Kenya</option>
                                <option value="Kiribati">Kiribati</option>
                                <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                                <option value="Korea, Republic of">Korea, Republic of</option>
                                <option value="Kuwait">Kuwait</option>
                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                <option value="Latvia">Latvia</option>
                                <option value="Lebanon">Lebanon</option>
                                <option value="Lesotho">Lesotho</option>
                                <option value="Liberia">Liberia</option>
                                <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                <option value="Liechtenstein">Liechtenstein</option>
                                <option value="Lithuania">Lithuania</option>
                                <option value="Luxembourg">Luxembourg</option>
                                <option value="Macao">Macao</option>
                                <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                                <option value="Madagascar">Madagascar</option>
                                <option value="Malawi">Malawi</option>
                                <option value="Malaysia">Malaysia</option>
                                <option value="Maldives">Maldives</option>
                                <option value="Mali">Mali</option>
                                <option value="Malta">Malta</option>
                                <option value="Marshall Islands">Marshall Islands</option>
                                <option value="Martinique">Martinique</option>
                                <option value="Mauritania">Mauritania</option>
                                <option value="Mauritius">Mauritius</option>
                                <option value="Mayotte">Mayotte</option>
                                <option value="Mexico">Mexico</option>
                                <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                                <option value="Moldova, Republic of">Moldova, Republic of</option>
                                <option value="Monaco">Monaco</option>
                                <option value="Mongolia">Mongolia</option>
                                <option value="Montenegro">Montenegro</option>
                                <option value="Montserrat">Montserrat</option>
                                <option value="Morocco">Morocco</option>
                                <option value="Mozambique">Mozambique</option>
                                <option value="Myanmar">Myanmar</option>
                                <option value="Namibia">Namibia</option>
                                <option value="Nauru">Nauru</option>
                                <option value="Nepal">Nepal</option>
                                <option value="Netherlands">Netherlands</option>
                                <option value="Netherlands Antilles">Netherlands Antilles</option>
                                <option value="New Caledonia">New Caledonia</option>
                                <option value="New Zealand">New Zealand</option>
                                <option value="Nicaragua">Nicaragua</option>
                                <option value="Niger">Niger</option>
                                <option value="Nigeria">Nigeria</option>
                                <option value="Niue">Niue</option>
                                <option value="Norfolk Island">Norfolk Island</option>
                                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                <option value="Norway">Norway</option>
                                <option value="Oman">Oman</option>
                                <option value="Pakistan">Pakistan</option>
                                <option value="Palau">Palau</option>
                                <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                                <option value="Panama">Panama</option>
                                <option value="Papua New Guinea">Papua New Guinea</option>
                                <option value="Paraguay">Paraguay</option>
                                <option value="Peru">Peru</option>
                                <option value="Philippines">Philippines</option>
                                <option value="Pitcairn">Pitcairn</option>
                                <option value="Poland">Poland</option>
                                <option value="Portugal">Portugal</option>
                                <option value="Puerto Rico">Puerto Rico</option>
                                <option value="Qatar">Qatar</option>
                                <option value="Reunion">Reunion</option>
                                <option value="Romania">Romania</option>
                                <option value="Russian Federation">Russian Federation</option>
                                <option value="Rwanda">Rwanda</option>
                                <option value="Saint Helena">Saint Helena</option>
                                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                <option value="Saint Lucia">Saint Lucia</option>
                                <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                                <option value="Samoa">Samoa</option>
                                <option value="San Marino">San Marino</option>
                                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                <option value="Saudi Arabia">Saudi Arabia</option>
                                <option value="Senegal">Senegal</option>
                                <option value="Serbia">Serbia</option>
                                <option value="Seychelles">Seychelles</option>
                                <option value="Sierra Leone">Sierra Leone</option>
                                <option value="Singapore">Singapore</option>
                                <option value="Slovakia">Slovakia</option>
                                <option value="Slovenia">Slovenia</option>
                                <option value="Solomon Islands">Solomon Islands</option>
                                <option value="Somalia">Somalia</option>
                                <option value="South Africa">South Africa</option>
                                <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                                <option value="Spain">Spain</option>
                                <option value="Sri Lanka">Sri Lanka</option>
                                <option value="Sudan">Sudan</option>
                                <option value="Suriname">Suriname</option>
                                <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                <option value="Swaziland">Swaziland</option>
                                <option value="Sweden">Sweden</option>
                                <option value="Switzerland">Switzerland</option>
                                <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                                <option value="Tajikistan">Tajikistan</option>
                                <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                <option value="Thailand">Thailand</option>
                                <option value="Timor-leste">Timor-leste</option>
                                <option value="Togo">Togo</option>
                                <option value="Tokelau">Tokelau</option>
                                <option value="Tonga">Tonga</option>
                                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                <option value="Tunisia">Tunisia</option>
                                <option value="Turkey">Turkey</option>
                                <option value="Turkmenistan">Turkmenistan</option>
                                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                <option value="Tuvalu">Tuvalu</option>
                                <option value="Uganda">Uganda</option>
                                <option value="Ukraine">Ukraine</option>
                                <option value="United Arab Emirates">United Arab Emirates</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="United States">United States</option>
                                <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                <option value="Uruguay">Uruguay</option>
                                <option value="Uzbekistan">Uzbekistan</option>
                                <option value="Vanuatu">Vanuatu</option>
                                <option value="Venezuela">Venezuela</option>
                                <option value="Viet Nam">Viet Nam</option>
                                <option value="Virgin Islands, British">Virgin Islands, British</option>
                                <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                <option value="Wallis and Futuna">Wallis and Futuna</option>
                                <option value="Western Sahara">Western Sahara</option>
                                <option value="Yemen">Yemen</option>
                                <option value="Zambia">Zambia</option>
                                <option value="Zimbabwe">Zimbabwe</option>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div style="border: 1px solid forestgreen;" class="table-responsive">
                        <label>8. Transit country/ countries (other than ser no 7): </label>
                        <table class="table table-bordered" id="transit_table">
                            <tr>
                                <th width="10%">Ser No</th>
                                <th width="25%">Country</th>
                                <th width="25%">Duration of Stay</th>
                                <th width="30%">Purpose</th>
                                <th width="10%">Action</th>
                            </tr>
                            <tr>
                                <td style="background-color: white" contenteditable="true" class="transit_ser_no"></td>
                                <td style="background-color: white" contenteditable="true" class="transit_country"></td>
                                <td style="background-color: white" contenteditable="true" class="transit_stay"></td>
                                <td style="background-color: white" contenteditable="true" class="transit_purpose"></td>
                                <td>
                                    <button type="button" id="addDebriefTransitTable" class="btn btn-success btn-xs">
                                        Add
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="required">9. Details of Training: </label>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label class="required">a. Name of the course</label>
                            <input type="text" pattern="^[_A-z0-9-.,() ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="name_of_course" placeholder="Course Name">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-6">
                            <label class="required">b. Duration of the course: From</label>
                            <input type="date" class="form-control" name="course_from" placeholder="From">
                        </div>
                        <div class="col-md-6">
                            <label class="required">To</label>
                            <input type="date" class="form-control" name="course_to" placeholder="To">
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label class="required">c. Name and address of the institution</label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="name_address_of_institution">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>d. General description about the course content, composition of student officers
                                and observations about its utility and benefit to BAF </label>
                            <input pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="course_content">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div style="border: 1px solid forestgreen;" class="table-responsive">
                        <label>
                            e. Was the course conducted only for Bangladeshi student? If no then privide details of the other
                            foreign students: (you may attach a course photograph). If the number of students are
                            more, you may give a summary of total number of students with rank as per following:
                        </label>

                        <table class="table table-bordered" id="summary_of_students">
                            <tr>
                                <th width="10%">Ser No</th>
                                <th width="25%">Nationality</th>
                                <th width="30%">Ranks/Particulars</th>
                                <th width="25%">Remarks</th>
                                <th width="10%">Action</th>
                            </tr>
                            <tr>
                                <td style="background-color: white" contenteditable="true"
                                    class="foreign_student_ser_no"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="foreign_student_nationality"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="foreign_student_ranks_particulars"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="foreign_student_remarks"></td>
                                <td>
                                    <button type="button" id="addForeignStudent" class="btn btn-success btn-xs">Add
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12" style="margin-top: 10px">
                            <label>f. Your observation and guidance to BAF personnel attending the same course in
                                future: </label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="observation_for_future">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>g. Which appointment in BAF would allow you to exercise the most from the
                                course?</label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="appointment_in_baf">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>10. Amount of money received from Bangladesh Govt. in foreign currency: </label>
                        </div>
                        <div class="col-md-6">
                            <label>a. Daily rate</label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="money_daily_rate">
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="col-md-6">
                            <label>b. Total</label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="money_total">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>11. Facilities provided by the visiting country: </label>
                        </div>
                        <div class="col-md-12">
                            <label>a. Were you given any cash by the host? If yes, state reasons and amount</label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="cash_by_host">
                            <div class="with-errors help-block"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>b. Was food and accommodation free?</label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="food_accommodation">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>c. Was transportation free?</label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="transportation">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>12. Foreign currency carried at your own arrangement</label>
                            <input type="text" pattern="^[_A-z0-9-.,/ ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="own_currency">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>13. Personal expenditure incurred during stay abroad(monthly)</label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="monthly_expenditure">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>14. Did you lose any of your personal items or money during your stay or on the
                                way?</label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="lose_personal_item">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>15. Have you cleared all bills from all concerned against you?</label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="bill_clear">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>16. Have you made any financial transaction with any foreigner or bangladeshi
                                national residing
                                there? If yes, give details</label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="financial_transaction">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>17. Total amount of foreign currency brought back to Bangladesh: </label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="currency_back">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div style="border: 1px solid forestgreen;" class="table-responsive">
                        <label>18. List a few names of your close friends in abroad who displayed keen interest about
                            BAF or
                            Bangladesh Armed Forces:</label>
                        <table class="table table-bordered" id="foreign_friends_table">
                            <tr>
                                <th width="10%">Ser No</th>
                                <th width="25%">Name & Address</th>
                                <th width="35%">Occupation</th>
                                <th width="20%">Remarks</th>
                                <th width="10%">Action</th>
                            </tr>
                            <tr>
                                <td style="background-color: white" contenteditable="true"
                                    class="foreign_friends_ser_no"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="foreign_friends_name_address"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="foreign_friends_occupation"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="foreign_friends_remarks"></td>
                                <td>
                                    <button type="button" id="addForeignFriend" class="btn btn-success btn-xs">Add
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div style="border: 1px solid forestgreen; margin-top: 10px" class="table-responsive">
                        <label>19. Was any foreigner exceptionally kind to you or came to help you out of
                            dificulties.Give details :</label>
                        <table class="table table-bordered" id="kind_foreigner_table">
                            <tr>
                                <th width="10%">Ser No</th>
                                <th width="25%">Name & Address</th>
                                <th width="35%">Occupation</th>
                                <th width="20%">Remarks</th>
                                <th width="10%">Action</th>
                            </tr>
                            <tr>
                                <td style="background-color: white" contenteditable="true"
                                    class="kind_foreigner_ser_no"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="kind_foreigner_name_address"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="kind_foreigner_occupation"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="kind_foreigner_remarks"></td>
                                <td>
                                    <button type="button" id="addKindForeigner" class="btn btn-success btn-xs">Add
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12" style="margin-top: 10px">
                            <label>20. Did you contract/promise or were forced to marry any foreigner? If yes, write in
                                details</label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="promise">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>21. Do you know if any of your fellow members made friendship or any agreemarnt with
                                any
                                foreigner/ If yes, furnish details </label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="friendship">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>22. Have you discussed any classified information with any foreigner? If yes, Give
                                details</label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="classified_info">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div style="border: 1px solid forestgreen;" class="table-responsive">
                        <label>23. During your stay abroad did you lose any service property or documents? If yes, list
                            them:</label>
                        <table class="table table-bordered" id="lose_service_property">
                            <tr>
                                <th width="10%">Ser No</th>
                                <th width="25%">Type of docu</th>
                                <th width="35%">Place at which lost</th>
                                <th width="20%">Remarks</th>
                                <th width="8%">Action</th>
                            </tr>
                            <tr>
                                <td style="background-color: white" contenteditable="true" class="lost_ser_no"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="lost_type_of_docu"></td>
                                <td style="background-color: white" contenteditable="true" class="lost_place"></td>
                                <td style="background-color: white" contenteditable="true" class="lost_remarks"></td>
                                <td>
                                    <button type="button" id="addLostItem" class="btn btn-success btn-xs">Add</button>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12" style="margin-top: 10px">
                            <label>24. Have you or any member of your team encountered any difficulty or got involved in
                                any problem/ trouble? Give details</label>
                            <input type="text" pattern="^[_A-z0-9-.,/ ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="difficulty">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div style="border: 1px solid forestgreen;" class="table-responsive">
                        <label>25. Give details of the places/ institution where you submitted your bio-data:</label>
                        <table class="table table-bordered" id="cv_submit_table">
                            <tr>
                                <th width="10%">Ser No</th>
                                <th width="50%">Place/ Name of the Institution</th>
                                <th width="30%">Reasons/ Remarks</th>
                                <th width="10%">Action</th>
                            </tr>
                            <tr>
                                <td style="background-color: white" contenteditable="true" class="cv_ser_no"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="cv_name_of_institution"></td>
                                <td style="background-color: white" contenteditable="true" class="cv_remarks"></td>
                                <td>
                                    <button type="button" id="addCvTable" class="btn btn-success btn-xs">Add</button>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12" style="margin-top: 10px">
                            <label>26. Have you ever suspected any member of your team of having secret understanding
                                with any foreigner? Write in details </label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="secret_understanding">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>27. Details of the foreign intelligence network or spy if you could observe
                                them</label>
                            <input type="text" pattern="^[_A-z0-9-.,/ ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="foreign_spy">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>28. Wtite in details about the interest of foreigner on military, political, social
                                and economic situation of Bangladesh </label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="interest_of_foreigner">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>29. General impression of the foreigner and their Govt about Bangladesh (to include
                                veiws, opinions, expressed by high officials/ published in their media) </label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="impression_about_bd">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div style="border: 1px solid forestgreen;" class="table-responsive">
                        <label>30. Details of the military/ industrial sites visited/ stayed: (you may add map/ photo to
                            furnish this column) </label>
                        <table class="table table-bordered" id="military_site_visited">
                            <tr>
                                <th width="10%">Ser No</th>
                                <th width="20%">Place</th>
                                <th width="60%">Importance (give details in case of mil installations)</th>
                                <th width="10%">Action</th>
                            </tr>
                            <tr>
                                <td style="background-color: white" contenteditable="true" class="mil_site_ser_no"></td>
                                <td style="background-color: white" contenteditable="true" class="mil_site_place"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="mil_site_importance"></td>
                                <td>
                                    <button type="button" name="addMilSiteVisit" id="addMilSiteVisit"
                                            class="btn btn-success btn-xs">Add
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group row has-feedback">
                        <div class="col-md-12" style="margin-top: 10px">
                            <label>31. Give a pen picture about the political, social, military and security system of the
                                country:</label>
                            <input type="text" pattern="^[_A-z0-9-.,/ ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="pen_picture">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div style="border: 1px solid forestgreen;" class="table-responsive">
                        <label>32. Details of the meeting with military and civil high officials:</label>
                        <table class="table table-bordered" id="meeting_table">
                            <tr>
                                <th width="10%">Ser No</th>
                                <th width="20%">particulars</th>
                                <th width="40%">Appointment</th>
                                <th width="40%">Purpose of Meeting</th>
                                <th width="10%">Action</th>
                            </tr>
                            <tr>
                                <td style="background-color: white" contenteditable="true" class="meeting_ser_no"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="meeting_particulars"></td>
                                <td style="background-color: white" contenteditable="true"
                                    class="meeting_appointment"></td>
                                <td style="background-color: white" contenteditable="true" class="meeting_purpose"></td>
                                <td>
                                    <button type="button" id="addMeeting" class="btn btn-success btn-xs">Add</button>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div style="border: 1px solid forestgreen; margin-top: 10px" class="table-responsive">
                        <label>33. Did you become a member of any foreign organization/ club/ association? Give
                            details:</label>
                        <table class="table table-bordered" id="club_member">
                            <tr>
                                <th width="10%">Ser No</th>
                                <th width="60%">Name of the Club/ Org</th>
                                <th width="20%">Remarks</th>
                                <th width="10%">Action</th>
                            </tr>
                            <tr>
                                <td style="background-color: white" contenteditable="true" class="club_ser_no"></td>
                                <td style="background-color: white" contenteditable="true" class="club_name"></td>
                                <td style="background-color: white" contenteditable="true" class="club_remarks"></td>
                                <td>
                                    <button type="button" id="addClub" class="btn btn-success btn-xs">Add</button>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12" style="margin-top: 10px">
                            <label>34. Write important social and security problem of the visited country</label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="security_problem">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12">
                            <label>35. Latest development and progress in the military field of the country
                                visited</label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   name="progress_in_military">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div style="border: 1px solid forestgreen;" class="table-responsive">
                        <label>36. Particulars of gift received from foreign nationals: (you may include the gift items
                            for nec clearance as per AFO 113-13 dated 12 March 1996)
                        </label>
                        <table class="table table-bordered" id="giftItemTable">
                            <tr>
                                <th width="10%">Ser No</th>
                                <th width="15%">Details of Gift Received</th>
                                <th width="15%">Date of Receipt</th>
                                <th width="15%">Approx Value</th>
                                <th width="30%">Name of Dignitary/ Institution from whom received</th>
                                <th width="20%">Remarks (Mention if Enclosed)</th>
                                <th width="10%">Action</th>
                            </tr>
                            <tr>
                                <td style="background-color: white" contenteditable="true" class="gift_ser_no"></td>
                                <td style="background-color: white" contenteditable="true" class="gift_details"></td>
                                <td style="background-color: white" contenteditable="true" class="gift_date"></td>
                                <td style="background-color: white" contenteditable="true" class="gift_value"></td>
                                <td style="background-color: white" contenteditable="true" class="gift_dignitary"></td>
                                <td style="background-color: white" contenteditable="true" class="gift_remarks"></td>
                                <td>
                                    <button type="button" id="addGiftItem" class="btn btn-success btn-xs">Add</button>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12" style="margin-top: 10px">
                            <label>37.<br> a. Have you purchased any fire arms?</label>
                            <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
                                   data-pattern-error="Special Character (&,$,# etc) not allowed!!" class="form-control"
                                   id="fire_arm" name="fire_arm">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <label for="">b. If yes, fill up the fol boxes:</label>
                    <div style="border: 1px solid forestgreen; margin-top: 5px" class="table-responsive">
                        <label></label>
                        <table class="table table-bordered" id="fire_arms_table">
                            <tr>
                                <th width="10%">Ser No</th>
                                <th width="25%">Type of Fire Arms</th>
                                <th width="20%">Price</th>
                                <th width="25%">Permission taken from</th>
                                <th width="20%">Remarks</th>
                                <th width="10%">Action</th>
                            </tr>
                            <tr>
                                <td style="background-color: white" contenteditable="true" class="arms_ser_no"></td>
                                <td style="background-color: white" contenteditable="true" class="arms_type"></td>
                                <td style="background-color: white" contenteditable="true" class="arms_price"></td>
                                <td style="background-color: white" contenteditable="true" class="arms_permission"></td>
                                <td style="background-color: white" contenteditable="true" class="arms_remarks"></td>
                                <td>
                                    <button type="button" id="addFireArms" class="btn btn-success btn-xs">Add</button>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-group row has-feedback">
                        <div class="col-md-12" style="margin-top: 10px">
                            <label>Is there any other BAF personnel travelled with you? If yes, give their svc number</label>
                            <input class="btn btn-info" type="button" value="Yes" name="btnpersonTravelingWith" required/>
                            <input class="btn btn-info" type="button" value="No" name="btnpersonTravelingWith" required/>
                            <div class="col-md-5 col-md-offset-4">
                                <table style="display: none" class="table table-bordered" id="personTravelingWith">
                                    <tr>
                                        <th width="5%" style="text-align: center">Ser No</th>
                                        <th width="15%" style="text-align: center">Svc No</th>
                                        <th width="5%" style="text-align: center">Action</th>
                                    </tr>
                                    <tr>
                                        <td style="background-color: white; text-align: center" contenteditable="true" class="ser_no">1</td>
                                        <td>
                                            <div class="form-group has-feedback">
                                                <input class="svc_no form-control" type="number" data-error="Svc No minimum 4 Character !" pattern="^[0-9]{1,}$" placeholder="Svc No" data-minlength="4">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </td>
                                        <td><button type="button" id="add" class="btn btn-success btn-sm">Add</button></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <h4 class="text-center text-warning">
                        <input type="checkbox" name="agreement" value="1" required> * I hereby certified that the
                        information given above are correct to the best of my knowledge
                        belief and I shall be liable of disciplinary action for giving any wrong statement.
                    </h4>

                    <div class="form-group row">
                        <div class="col-md-offset-5 col-md-7">
                            <button type="submit" class="btn btn-success" id="save" name="btn_submit">Submit</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script src="../js/jquery-1.12.4.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/validator.js"></script>
</body>
</html>
<script type="text/javascript">
    $(function () {
        $("input[name=btnpersonTravelingWith]").click(function () {
            if ($(this).val() == "Yes") {
                $("#personTravelingWith").show();
            } else {
                $("#personTravelingWith").hide();
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        var count = 1;

        // Destination Country Session Create function
        $('#destination_country').change(function () {
            var destination_country = $(this).val();

            $.ajax({
                url: "../session_create.php",
                method: "POST",
                data: {destination_country: destination_country},
                success: function (data) {
                    //alert(data);
                }
            });
        });

        // Persons Traveling with info add function
        $('#add').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white; text-align: center' contenteditable='true' class='ser_no'></td>";
            html_code += "<td style=\"background-color: white\">\n" +
                "                        <div class=\"form-group has-feedback\">\n" +
                "                            <input class=\"svc_no form-control\" type=\"text\" data-pattern-error=\"Only Number Allowed\" pattern=\"^[0-9]{1,}$\" placeholder=\"Svc No\" required>\n" +
                "                            <div class=\"help-block with-errors\"></div>\n" +
                "                        </div>\n" +
                "                    </td>";
            html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-sm remove'>Del</button></td>";
            html_code += "</tr>";
            $('#personTravelingWith').append(html_code);
        });

        // 08. Transit table add function
        $('#addDebriefTransitTable').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='transit_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='transit_country'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='transit_stay'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='transit_purpose' ></td>";
            html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#transit_table').append(html_code);
        });

        // 09.e Transit table add function
        $('#addForeignStudent').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='foreign_student_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='foreign_student_nationality'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='foreign_student_ranks_particulars'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='foreign_student_remarks' ></td>";
            html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#summary_of_students').append(html_code);
        });

        // 18 Foreign Friends Table add function
        $('#addForeignFriend').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='foreign_friends_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='foreign_friends_name_address'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='foreign_friends_occupation'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='foreign_friends_remarks' ></td>";
            html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#foreign_friends_table').append(html_code);
        });

        // 19 Exceptionally kind Foreign Friends Table add function
        $('#addKindForeigner').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='kind_foreigner_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='kind_foreigner_name_address'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='kind_foreigner_occupation'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='kind_foreigner_remarks' ></td>";
            html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#kind_foreigner_table').append(html_code);
        });

        // 23 Lose svc item Table add function
        $('#addLostItem').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='lost_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='lost_type_of_docu'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='lost_place'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='lost_remarks' ></td>";
            html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#lose_service_property').append(html_code);
        });

        // 25 CV Submit Table add function
        $('#addCvTable').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='cv_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='cv_name_of_institution'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='cv_remarks'></td>";
            html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#cv_submit_table').append(html_code);
        });

        // 30 Military Site Visit Table add function
        $('#addMilSiteVisit').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='mil_site_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='mil_site_place'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='mil_site_importance'></td>";
            html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#military_site_visited').append(html_code);
        });

        // 32 Meeting with Military Person Table add function
        $('#addMeeting').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='meeting_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='meeting_particulars'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='meeting_appointment'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='meeting_purpose'></td>";
            html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#meeting_table').append(html_code);
        });

        // 33 Club member Table add function
        $('#addClub').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='club_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='club_name'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='club_remarks'></td>";
            html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#club_member').append(html_code);
        });

        // 36 Gift Item Table add function
        $('#addGiftItem').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='gift_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='gift_details'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='gift_date'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='gift_value'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='gift_dignitary'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='gift_remarks'></td>";
            html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#giftItemTable').append(html_code);
        });

        // 37.b Fire Arms Table add function
        $('#addFireArms').click(function () {
            count = count + 1;
            var html_code = "<tr id='row" + count + "'>";
            html_code += "<td style='background-color: white' contenteditable='true' class='arms_ser_no'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='arms_type'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='arms_price'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='arms_permission'></td>";
            html_code += "<td style='background-color: white' contenteditable='true' class='arms_remarks'></td>";
            html_code += "<td><button type='button' name='remove' data-row='row" + count + "' class='btn btn-danger btn-xs remove'>Del</button></td>";
            html_code += "</tr>";
            $('#fire_arms_table').append(html_code);
        });

        $(document).on('click', '.remove', function () {
            var delete_row = $(this).data("row");
            $('#' + delete_row).remove();
        });

        $('#f_20389').validator().on('submit', function (e) {
            if (e.isDefaultPrevented()) {
                // handle the invalid form...
                alert("Please Fill the form correctly.");
            } else {
                // everything looks good!

                var svc_no = [];
                $('.svc_no').each(function () {
                    svc_no.push($(this).val());
                });

                $.ajax({
                    url: "debrief_insert_dynamic_tables/groupMemberInsert.php",
                    method: "POST",
                    data: {svc_no: svc_no},
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        //fetch_item_data();
                    }
                });

                var transit_ser_no = [];
                var transit_country = [];
                var transit_stay = [];
                var transit_purpose = [];
                $('.transit_ser_no').each(function () {
                    transit_ser_no.push($(this).text());
                });
                $('.transit_country').each(function () {
                    transit_country.push($(this).text());
                });
                $('.transit_stay').each(function () {
                    transit_stay.push($(this).text());
                });
                $('.transit_purpose').each(function () {
                    transit_purpose.push($(this).text());
                });

                $.ajax({
                    url: "debrief_insert_dynamic_tables/insertDebriefTransitTable.php",
                    method: "POST",
                    data: {
                        transit_ser_no: transit_ser_no,
                        transit_country: transit_country,
                        transit_stay: transit_stay,
                        transit_purpose: transit_purpose
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        fetch_item_data();
                    }
                });

                var foreign_student_ser_no = [];
                var foreign_student_nationality = [];
                var foreign_student_ranks_particulars = [];
                var foreign_student_remarks = [];
                $('.foreign_student_ser_no').each(function () {
                    foreign_student_ser_no.push($(this).text());
                });
                $('.foreign_student_nationality').each(function () {
                    foreign_student_nationality.push($(this).text());
                });
                $('.foreign_student_ranks_particulars').each(function () {
                    foreign_student_ranks_particulars.push($(this).text());
                });
                $('.foreign_student_remarks').each(function () {
                    foreign_student_remarks.push($(this).text());
                });

                $.ajax({
                    url: "debrief_insert_dynamic_tables/insertForeignStudentTable.php",
                    method: "POST",
                    data: {
                        foreign_student_ser_no: foreign_student_ser_no,
                        foreign_student_nationality: foreign_student_nationality,
                        foreign_student_ranks_particulars: foreign_student_ranks_particulars,
                        foreign_student_remarks: foreign_student_remarks
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        fetch_item_data();
                    }
                });

                var foreign_friends_ser_no = [];
                var foreign_friends_name_address = [];
                var foreign_friends_occupation = [];
                var foreign_friends_remarks = [];
                $('.foreign_friends_ser_no').each(function () {
                    foreign_friends_ser_no.push($(this).text());
                });
                $('.foreign_friends_name_address').each(function () {
                    foreign_friends_name_address.push($(this).text());
                });
                $('.foreign_friends_occupation').each(function () {
                    foreign_friends_occupation.push($(this).text());
                });
                $('.foreign_friends_remarks').each(function () {
                    foreign_friends_remarks.push($(this).text());
                });

                $.ajax({
                    url: "debrief_insert_dynamic_tables/insertForeignFriendTable.php",
                    method: "POST",
                    data: {
                        foreign_friends_ser_no: foreign_friends_ser_no,
                        foreign_friends_name_address: foreign_friends_name_address,
                        foreign_friends_occupation: foreign_friends_occupation,
                        foreign_friends_remarks: foreign_friends_remarks
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        fetch_item_data();
                    }
                });

                var kind_foreigner_ser_no = [];
                var kind_foreigner_name_address = [];
                var kind_foreigner_occupation = [];
                var kind_foreigner_remarks = [];
                $('.kind_foreigner_ser_no').each(function () {
                    kind_foreigner_ser_no.push($(this).text());
                });
                $('.kind_foreigner_name_address').each(function () {
                    kind_foreigner_name_address.push($(this).text());
                });
                $('.kind_foreigner_occupation').each(function () {
                    kind_foreigner_occupation.push($(this).text());
                });
                $('.kind_foreigner_remarks').each(function () {
                    kind_foreigner_remarks.push($(this).text());
                });

                $.ajax({
                    url: "debrief_insert_dynamic_tables/insertKindForeignerTable.php",
                    method: "POST",
                    data: {
                        kind_foreigner_ser_no: kind_foreigner_ser_no,
                        kind_foreigner_name_address: kind_foreigner_name_address,
                        kind_foreigner_occupation: kind_foreigner_occupation,
                        kind_foreigner_remarks: kind_foreigner_remarks
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        fetch_item_data();
                    }
                });

                var lost_ser_no = [];
                var lost_type_of_docu = [];
                var lost_place = [];
                var lost_remarks = [];
                $('.lost_ser_no').each(function () {
                    lost_ser_no.push($(this).text());
                });
                $('.lost_type_of_docu').each(function () {
                    lost_type_of_docu.push($(this).text());
                });
                $('.lost_place').each(function () {
                    lost_place.push($(this).text());
                });
                $('.lost_remarks').each(function () {
                    lost_remarks.push($(this).text());
                });

                $.ajax({
                    url: "debrief_insert_dynamic_tables/insertLostSvcProperty.php",
                    method: "POST",
                    data: {
                        lost_ser_no: lost_ser_no,
                        lost_type_of_docu: lost_type_of_docu,
                        lost_place: lost_place,
                        lost_remarks: lost_remarks
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        fetch_item_data();
                    }
                });

                var cv_ser_no = [];
                var cv_name_of_institution = [];
                var cv_remarks = [];
                $('.cv_ser_no').each(function () {
                    cv_ser_no.push($(this).text());
                });
                $('.cv_name_of_institution').each(function () {
                    cv_name_of_institution.push($(this).text());
                });
                $('.cv_remarks').each(function () {
                    cv_remarks.push($(this).text());
                });

                $.ajax({
                    url: "debrief_insert_dynamic_tables/insertCvTable.php",
                    method: "POST",
                    data: {cv_ser_no: cv_ser_no, cv_name_of_institution: cv_name_of_institution, cv_remarks: cv_remarks},
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        fetch_item_data();
                    }
                });

                var mil_site_ser_no = [];
                var mil_site_place = [];
                var mil_site_importance = [];
                $('.mil_site_ser_no').each(function () {
                    mil_site_ser_no.push($(this).text());
                });
                $('.mil_site_place').each(function () {
                    mil_site_place.push($(this).text());
                });
                $('.mil_site_importance').each(function () {
                    mil_site_importance.push($(this).text());
                });

                $.ajax({
                    url: "debrief_insert_dynamic_tables/insertMilSiteVisit.php",
                    method: "POST",
                    data: {
                        mil_site_ser_no: mil_site_ser_no,
                        mil_site_place: mil_site_place,
                        mil_site_importance: mil_site_importance
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        fetch_item_data();
                    }
                });

                var meeting_ser_no = [];
                var meeting_particulars = [];
                var meeting_appointment = [];
                var meeting_purpose = [];
                $('.meeting_ser_no').each(function () {
                    meeting_ser_no.push($(this).text());
                });
                $('.meeting_particulars').each(function () {
                    meeting_particulars.push($(this).text());
                });
                $('.meeting_appointment').each(function () {
                    meeting_appointment.push($(this).text());
                });
                $('.meeting_purpose').each(function () {
                    meeting_purpose.push($(this).text());
                });

                $.ajax({
                    url: "debrief_insert_dynamic_tables/insertMeetingTable.php",
                    method: "POST",
                    data: {
                        meeting_ser_no: meeting_ser_no,
                        meeting_particulars: meeting_particulars,
                        meeting_appointment: meeting_appointment,
                        meeting_purpose: meeting_purpose
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        fetch_item_data();
                    }
                });

                var club_ser_no = [];
                var club_name = [];
                var club_remarks = [];
                $('.club_ser_no').each(function () {
                    club_ser_no.push($(this).text());
                });
                $('.club_name').each(function () {
                    club_name.push($(this).text());
                });
                $('.club_remarks').each(function () {
                    club_remarks.push($(this).text());
                });

                $.ajax({
                    url: "debrief_insert_dynamic_tables/insertClubMmberTable.php",
                    method: "POST",
                    data: {club_ser_no: club_ser_no, club_name: club_name, club_remarks: club_remarks},
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        fetch_item_data();
                    }
                });


                var gift_ser_no = [];
                var gift_details = [];
                var gift_date = [];
                var gift_value = [];
                var gift_dignitary = [];
                var gift_remarks = [];
                $('.gift_ser_no').each(function () {
                    gift_ser_no.push($(this).text());
                });
                $('.gift_details').each(function () {
                    gift_details.push($(this).text());
                });
                $('.gift_date').each(function () {
                    gift_date.push($(this).text());
                });
                $('.gift_value').each(function () {
                    gift_value.push($(this).text());
                });
                $('.gift_dignitary').each(function () {
                    gift_dignitary.push($(this).text());
                });
                $('.gift_remarks').each(function () {
                    gift_remarks.push($(this).text());
                });

                $.ajax({
                    url: "debrief_insert_dynamic_tables/insertGiftItemTable.php",
                    method: "POST",
                    data: {
                        gift_ser_no: gift_ser_no,
                        gift_details: gift_details,
                        gift_date: gift_date,
                        gift_value: gift_value,
                        gift_dignitary: gift_dignitary,
                        gift_remarks: gift_remarks
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        fetch_item_data();
                    }
                });

                var arms_ser_no = [];
                var arms_type = [];
                var arms_price = [];
                var arms_permission = [];
                var arms_remarks = [];
                $('.arms_ser_no').each(function () {
                    arms_ser_no.push($(this).text());
                });
                $('.arms_type').each(function () {
                    arms_type.push($(this).text());
                });
                $('.arms_price').each(function () {
                    arms_price.push($(this).text());
                });
                $('.arms_permission').each(function () {
                    arms_permission.push($(this).text());
                });
                $('.arms_remarks').each(function () {
                    arms_remarks.push($(this).text());
                });

                $.ajax({
                    url: "debrief_insert_dynamic_tables/insertFireArmsTable.php",
                    method: "POST",
                    data: {
                        arms_ser_no: arms_ser_no,
                        arms_type: arms_type,
                        arms_price: arms_price,
                        arms_permission: arms_permission,
                        arms_remarks: arms_remarks
                    },
                    success: function (data) {
                        //alert(data);
                        $("td[contentEditable='true']").text("");
                        for (var i = 2; i <= count; i++) {
                            $('tr#' + i + '').remove();
                        }
                        fetch_item_data();
                    }
                });
            }
        });
    });
</script>

