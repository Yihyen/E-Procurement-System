<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

if(isset($_SESSION['message'])){
    echo "<script>alert('Already have this regNum')</script>";
    unset ($_SESSION['message']);
} 

//generate catalog ID
$query = "SELECT * FROM potential_supplier ORDER BY potential_id DESC LIMIT 1";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);
$lastid = $row['potential_id'];

if (empty($lastid)) {
    $sid = "PS0001";
} else {
    $get_id = str_replace("PS", "", $lastid);
    $get_string = str_pad($get_id + 1, 4, 0, STR_PAD_LEFT);
    $sid = 'PS' . $get_string;
}

//set date
date_default_timezone_set('Asia/Kuala_Lumpur');
$Format = 'Y-m-d';
$CDT = date($Format);
$FDT = date($Format);

?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

        <title>Supplier Application</title>

    </head>
    <body>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Supplier Application</h4>
                        </div>
                        <div class="card-body">
                            <form action="codeDatabase.php" enctype="multipart/form-data" method="POST">
                                <div class="mb-3">
                                    <input type="hidden" name="potential_id" class="form-control" id = "potential_id" value="<?php echo $sid; ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Company Name:</label>
                                    <input type="text" name="companyName" id="companyName" class="form-control" placeholder="Enter company name" onkeyup="checkName()" required>
                                </div>
                                <div class="icons0">
                                    <span class="icon1 fas fa-exclamation"></span> <!--！-->
                                    <span class="icon2 fas fa-check"></span> <!--v-->
                                </div>
                                <div class="error-text">
                                    Please Enter Valid Company Name
                                </div>
                                <div class="mb-3">
                                    <label>Address:</label>
                                    <input onkeyup="checkAddress()" type="text" name="address" id="address" class="form-control" placeholder="Enter address" required>
                                </div>
                                <div class="icons0">
                                    <span class="icon7 fas fa-exclamation"></span> <!--！-->
                                    <span class="icon8 fas fa-check"></span> <!--v-->
                                </div>
                                <div class="error-text3">
                                    Please Enter Valid Address
                                </div>
                                <div class="mb-3">
                                    <label>Contact Number:</label>
                                    <input onkeyup="checkContact()" type="text" name="contact" id="contact" class="form-control" placeholder="Enter contact number" required>
                                </div>
                                <div class="icons0">
                                    <span class="icon9 fas fa-exclamation"></span> <!--！-->
                                    <span class="icon10 fas fa-check"></span> <!--v-->
                                </div>
                                <div class="error-text4">
                                    Please Enter Valid Contact Number
                                </div>
                                <div class="mb-3">
                                    <label>Fax Number:</label>
                                    <input onkeyup="checkFax()" type="text" name="fax" id="fax" class="form-control" placeholder="Enter fax number" required>
                                </div>
                                <div class="icons0">
                                    <span class="icon11 fas fa-exclamation"></span> <!--！-->
                                    <span class="icon12 fas fa-check"></span> <!--v-->
                                </div>
                                <div class="error-text5">
                                    Please Enter Valid Fax Number
                                </div>
                                
                                <div class="mb-3">
                                    <label>Catalog File:</label>
                                    <input type="file"  data-default-file="pdf" name="img_file" id="img_file" onchange="getImagePreview()" required>
                                    <div class="mvv">
                                        <iframe id="preview" frameborder="0" scrolling="no" width="345px"></iframe>
                                    </div>
                                </div>
                                <div class="behind">
                                    <div class="mb-3">
                                        <label>Registration Number:</label>
                                        <input type="text" name="regNum" id="regNum" class="form-control" placeholder="Enter registration mumber" onkeyup="checkReg()" required>
                                    </div>
                                    <div class="icons">
                                        <span class="icon5 fas fa-exclamation"></span> <!--！-->
                                        <span class="icon6 fas fa-check"></span> <!--v-->
                                    </div>
                                    <div class="error-text2">
                                        Please Enter Valid Registration Number
                                    </div>
                                    <div class="mb-3">
                                        <label for="country">Country: </label>
                                        <select id="country" name="country" class="form-control" required value="">
                                            <option value="Afghanistan" selected="selected" >Afghanistan</option>
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
                                            <option value="Taiwan">Taiwan</option>
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
                                    </div>
                                    <div class="mb-3">
                                        <label>Email:</label>
                                        <input onkeyup="checkEmail()" type="text" name="email" id="email" class="form-control" placeholder="Enter email" required>
                                    </div>
                                    <div class="icons">
                                        <span class="icon3 fas fa-exclamation"></span> <!--！-->
                                        <span class="icon4 fas fa-check"></span> <!--v-->
                                    </div>
                                    <div class="error-text1">
                                        Please Enter Valid Email
                                    </div>
                                    <div class="mb-3">
                                        <label>Type of Business:</label>
                                        <input onkeyup="checkType()" type="text" name="typeOfBusiness" id="typeOfBusiness" class="form-control" placeholder="Enter business type" required>
                                    </div>
                                    <div class="icons">
                                        <span class="icon13 fas fa-exclamation"></span> <!--！-->
                                        <span class="icon14 fas fa-check"></span> <!--v-->
                                    </div>
                                    <div class="error-text6">
                                        Please Enter Valid Business Type
                                    </div>  
                                    <div class="behhind">
                                        <div class="mb-3">
                                            <label>Biz Profile:</label>
                                            <input type="file"  data-default-file="pdf" name="biz_file" id="biz_file" onchange="getBizPreview()" required>
                                            <div class="mvv">
                                                <iframe id="preview1" frameborder="0" scrolling="no" width="370px"></iframe>
                                            </div>
                                        </div>
                                    </div>      
                                </div> 
                                <br>
                                <div class="mb-3">
                                    <input type="hidden" name="status" value="Pending">
                                    <button type="submit" name="registerSupplier" class="btn btn-primary">Apply</button>
                                </div>
                            </form>
                        </div>
                    </div><br>
                </div>
            </div>
        </div>

        <style>
            .mt-5{
                width:880px;
                font-family: 'Poppins', sans-serif;
            }

            .card-header{
                color:#17a2b8;
                text-align: center;
            }

            .form-control{
                width:370px;
            }

            form .icons{
                position: absolute;
                right: 10px;
                transform: translateY(-190%);
            }

            form .icons0{
                position: absolute;
                left: 345px;
                transform: translateY(-190%);
            }

            .icons span{ /*error circle*/
                height: 25px;
                width: 25px;
                border: 2px solid;
                border-radius: 50%;
                line-height: 23px;
                display:none;
                margin-bottom: -4px;
            }

            .icons0 span{ /*error circle*/
                height: 25px;
                width: 25px;
                border: 2px solid;
                border-radius: 50%;
                line-height: 23px;
                display:none;
                margin-bottom: -4px;
            }

            .icons span.icon3, .icon5, .icon13{
                color: #e74c3c;
                border-color: #e74c3c;
                text-align: center;
            }

            .icons0 span.icon1, .icon7, .icon9, .icon11{
                color: #e74c3c;
                border-color: #e74c3c;
                text-align: center;
            }

            .icons span.icon4, .icon6, .icon14{
                color: #27ae60;
                border-color: #27ae60;
                text-align: center;
            }

            .icons0 span.icon2, .icon8, .icon10, .icon12{
                color: #27ae60;
                border-color: #27ae60;
                text-align: center;
            }

            form .error-text1, .error-text2, .error-text6{
                position: relative;
                margin: 15px 0 10px 0;
                background: #e74c3c;
                color: #fceae8;
                font-size: 15px;
                padding: 8px;
                border-radius: 5px;
                user-select: none;
                display: none;
            }

            form .error-text1:before, .error-text2:before, .error-text6:before{
                position: absolute;
                content: '';
                height: 15px;
                width: 15px;
                background: #e74c3c;
                right: 20px;
                top: -5px;
                transform: rotate(45deg);
            }

            form .error-text, .error-text3, .error-text4, .error-text5{
                position: relative;
                margin: 15px 0 10px 0;
                background: #e74c3c;
                width: 370px;
                color: #fceae8;
                font-size: 15px;
                padding: 8px;
                border-radius: 5px;
                user-select: none;
                display: none;
            }

            form .error-text:before, .error-text3:before, .error-text4:before, .error-text5:before{
                position: absolute;
                content: '';
                height: 15px;
                width: 15px;
                background: #e74c3c;
                left: 150px;
                top: -5px;
                transform: rotate(45deg);
            }
            .mvv{
                border: 2px dashed blue;
                margin-right: 470px;
            }

            .mb-3 input{
                margin-bottom: 10px;
            }

            .btn-primary {
                display: block;
                margin-left: auto;
                margin-right: auto;
            }

            .behind{
                position: absolute;
                right: 40px;
                top:70px;
            }

            .behhind{
                position: absolute;
            }

        </style>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

        <script>
        const companyName = document.querySelector("#companyName");
        const regNum = document.querySelector("#regNum");
        const address = document.querySelector("#address");
        const contact = document.querySelector("#contact");
        const email = document.querySelector("#email");
        const faxNum = document.querySelector("#fax");
        const type = document.querySelector("#typeOfBusiness");
        //name
        const icon1 = document.querySelector(".icon1");
        const icon2 = document.querySelector(".icon2");
        const error = document.querySelector(".error-text");
        const btn = document.querySelector("button");
        //email
        const icon3 = document.querySelector(".icon3");
        const icon4 = document.querySelector(".icon4");
        const error1 = document.querySelector(".error-text1");
        //reg
        const icon5 = document.querySelector(".icon5");
        const icon6 = document.querySelector(".icon6");
        const error2 = document.querySelector(".error-text2");
        //address
        const icon7 = document.querySelector(".icon7");
        const icon8 = document.querySelector(".icon8");
        const error3 = document.querySelector(".error-text3");
        //contact
        const icon9 = document.querySelector(".icon9");
        const icon10 = document.querySelector(".icon10");
        const error4 = document.querySelector(".error-text4");
        //fax
        const icon11 = document.querySelector(".icon11");
        const icon12 = document.querySelector(".icon12");
        const error5 = document.querySelector(".error-text5");
        //type
        const icon13 = document.querySelector(".icon13");
        const icon14 = document.querySelector(".icon14");
        const error6 = document.querySelector(".error-text6");

        let regExp = /^[a-zA-Z\s]+$/; //a-z / A-z
        let regExp1 = /^([0-9]{6})+$/; // 0-9 can 6 number
        let regExp2 = /^[a-zA-Z\s\d\,\.\-\/]+$/; //a-z / A-z / space / 0-9 /,/-//
        let regExp3 = /^([0-9]{9,11})+$/; // 0-9 can 9-11 number
        let regExp4 = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

        function checkName() {
            if (companyName.value.match(regExp)) {
                companyName.style.borderColor = "#27ae60"; //green
                companyName.style.background = "#eafaf1";
                icon1.style.display = "none";
                icon2.style.display = "block";
                error.style.display = "none";
//                btn.style.display = "block";
            } else if (companyName.value === "") {
                companyName.style.borderColor = "lightgrey";
                companyName.style.background = "#fff";
                icon1.style.display = "none";
                icon2.style.display = "none";
                error.style.display = "none";
//                btn.style.display = "none";
            } else {
                companyName.style.borderColor = "#e74c3c"; //red
                companyName.style.background = "#fceae9";
                icon1.style.display = "block";
                icon2.style.display = "none";
                error.style.display = "block";
                btn.style.display = "none";
            }
        }

        function checkReg() {
            if (regNum.value.match(regExp1)) {
                regNum.style.borderColor = "#27ae60"; //green
                regNum.style.background = "#eafaf1";
                icon5.style.display = "none";
                icon6.style.display = "block";
                error2.style.display = "none";
//                btn.style.display = "block";
            } else if (regNum.value === "") {
                regNum.style.borderColor = "lightgrey";
                regNum.style.background = "#fff";
                icon5.style.display = "none";
                icon6.style.display = "none";
                error2.style.display = "none";
//                btn.style.display = "none";
            } else {
                regNum.style.borderColor = "#e74c3c"; //red
                regNum.style.background = "#fceae9";
                icon5.style.display = "block";
                icon6.style.display = "none";
                error2.style.display = "block";
                btn.style.display = "none";
            }
        }

        function checkAddress() {
            if (address.value.match(regExp2)) {
                address.style.borderColor = "#27ae60"; //green
                address.style.background = "#eafaf1";
                icon7.style.display = "none";
                icon8.style.display = "block";
                error3.style.display = "none";
//                btn.style.display = "block";
            } else if (address.value === "") {
                address.style.borderColor = "lightgrey";
                address.style.background = "#fff";
                icon7.style.display = "none";
                icon8.style.display = "none";
                error3.style.display = "none";
//                btn.style.display = "none";
            } else {
                address.style.borderColor = "#e74c3c"; //red
                address.style.background = "#fceae9";
                icon7.style.display = "block";
                icon8.style.display = "none";
                error3.style.display = "block";
                btn.style.display = "none";
            }
        }

        function checkEmail() {
            if (email.value.match(regExp4)) {
                email.style.borderColor = "#27ae60";
                email.style.background = "#eafaf1";
                icon3.style.display = "none";
                icon4.style.display = "block";
                error1.style.display = "none";
//             btn1.style.display = "block";
            } else if (email.value == "") {
                email.style.borderColor = "lightgrey";
                email.style.background = "#fff";
                icon3.style.display = "none";
                icon4.style.display = "none";
                error1.style.display = "none";
                btn.style.display = "none";
            } else {
                email.style.borderColor = "#e74c3c";
                email.style.background = "#fceae9";
                icon3.style.display = "block";
                icon4.style.display = "none";
                error1.style.display = "block";
//             btn1.style.display = "none";
            }
        }

        function checkContact() {
            if (contact.value.match(regExp3)) {
                contact.style.borderColor = "#27ae60"; //green
                contact.style.background = "#eafaf1";
                icon9.style.display = "none";
                icon10.style.display = "block";
                error4.style.display = "none";
//                btn.style.display = "block";
            } else if (contact.value === "") {
                contact.style.borderColor = "lightgrey";
                contact.style.background = "#fff";
                icon9.style.display = "none";
                icon10.style.display = "none";
                error4.style.display = "none";
//                btn.style.display = "none";
            } else {
                contact.style.borderColor = "#e74c3c"; //red
                contact.style.background = "#fceae9";
                icon9.style.display = "block";
                icon10.style.display = "none";
                error4.style.display = "block";
                btn.style.display = "none";
            }
        }

        function checkFax() {
            if (faxNum.value.match(regExp3)) {
                faxNum.style.borderColor = "#27ae60"; //green
                faxNum.style.background = "#eafaf1";
                icon11.style.display = "none";
                icon12.style.display = "block";
                error5.style.display = "none";
//                btn.style.display = "block";
            } else if (faxNum.value === "") {
                faxNum.style.borderColor = "lightgrey";
                faxNum.style.background = "#fff";
                icon11.style.display = "none";
                icon12.style.display = "none";
                error5.style.display = "none";
//                btn.style.display = "none";
            } else {
                faxNum.style.borderColor = "#e74c3c"; //red
                faxNum.style.background = "#fceae9";
                icon11.style.display = "block";
                icon12.style.display = "none";
                error5.style.display = "block";
                btn.style.display = "none";
            }
        }

        function checkType() {
            if (type.value.match(regExp)) {
                type.style.borderColor = "#27ae60"; //green
                type.style.background = "#eafaf1";
                icon13.style.display = "none";
                icon14.style.display = "block";
                error6.style.display = "none";
                btn.style.display = "block";
            } else if (type.value === "") {
                type.style.borderColor = "lightgrey";
                type.style.background = "#fff";
                icon13.style.display = "none";
                icon14.style.display = "none";
                error6.style.display = "none";
                btn.style.display = "none";
            } else {
                type.style.borderColor = "#e74c3c"; //red
                type.style.background = "#fceae9";
                icon13.style.display = "block";
                icon14.style.display = "none";
                error6.style.display = "block";
                btn.style.display = "none";
            }
        }

        function getImagePreview() {
            pdffile = document.getElementById("img_file").files[0];
            pdffile_url = URL.createObjectURL(pdffile);
            $('#preview').attr('src', pdffile_url);
        }

        function getBizPreview() {
            pdffile = document.getElementById("biz_file").files[0];
            pdffile_url = URL.createObjectURL(pdffile);
            $('#preview1').attr('src', pdffile_url);
        }

        </script>
    </body>
</html>
