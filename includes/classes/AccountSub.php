<?php
require_once("Constants.php");
require_once("Account.php");



class AccountSub{


    public static function getAddressContainer($data, $con){

        $account = new Account($con);

        $phone = $data['phone'];
        $address = $data['address'];
        $address2 = $data['address2'];
        $city = $data['city'];
        $postal = $data['postal'];
        $country = $data['country'];
        $prov = $data['prov'];
        $email = $data['email'];


        $html ='';
        $html .='<div class="form-div acc">'.$account->getError(Constants::$phoneCharacters).'
                                            '.$account->getError(Constants::$phoneInvalid).'
                    <label>Phone</label>
                    <input type="text" class="form-input acc" value="'.$phone.'" name="phone" placeholder="Phone" required />
                </div>

                <div class="form-div acc">'.$account->getError(Constants::$addressCharacters).'
                    <label>Address</label>
                    <input type="text" class="form-input acc" value="'.$address.'" name="address" placeholder="Address" required />
                </div>

                <div class="form-div acc">'.$account->getError(Constants::$addressCharacters).'
                    <label>Address2</label>
                    <input type="text" class="form-input acc" value="'.$address2.'" name="address2" placeholder="Address2"/>
                </div>
                <div class="form-div divided">              
                    <div class="form-div acc split">'.$account->getError(Constants::$cityCharacters).'
                        <label>City</label>
                        <input type="text" class="form-input acc" value="'.$city.'" name="city" placeholder="City" required />
                    </div>
                    <div class="form-div acc split">
                        <label>Province/State</label>
                        <select class="form-input acc" name="prov" required >
                            <option value="">Select Provinces</option>
                            <option value="AL">Alberta</option>
                            <option value="BC">British Columbia</option>
                            <option value="MA">Manitoba</option>
                            <option value="NB">New Brunswick</option>
                            <option value="NF">Newfoundland and Labrador</option>
                            <option value="ON" selected>Ontario</option>
                            <option value="NO">Northwest Territories</option>
                            <option value="NS">Nova Scotia</option>
                            <option value="NU">Nunavut</option>
                        </select>
                    </div>
                </div>
                <div class="form-div divided">              
                    <div class="form-div acc split">'.$account->getError(Constants::$postalCharacters).'
                        <label>Postal</label> 
                        <input type="text" class="form-input acc" value="'.$postal.'" name="postal" placeholder="Postal" required />
                    </div>
                    <div class="form-div acc split">
                        <label>Country</label>
                        <select class="form-input acc" name="country" required >
                            <option value="">Select Country</option>
                            <option value="CANADA" selected>Canada</option>
                            <option value="KOREA">Korea</option>
                        </select>
                    </div>
                </div>';

        return $html;
    }



    public static function dobContainer(){

        $html ='';
        
        $year_start  = 1920;
        $year_end = date('Y'); // current Year
        $user_selected_year = 2000; // user date of birth year
        $html .= '<select class="form-input acc" id="year" name="year">'."\n";
        for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
            $selected = ($user_selected_year == $i_year ? ' selected' : '');
            $html .= '<option value="'.$i_year.'"'.$selected.'>'.$i_year.'</option>'."\n";
        }
        $html .= '</select>'."\n";


        $selected_day = 1; //current day
        $html .= '<select class="form-input acc" id="day" name="day">'."\n";
        for ($i_day = 1; $i_day <= 31; $i_day++) { 
            $selected = ($selected_day == $i_day ? ' selected' : '');
            $html .= '<option value="'.$i_day.'"'.$selected.'>'.$i_day.'</option>'."\n";
        }
        $html .= '</select>'."\n";

        $selected_month = date('m'); //current month
        $html .= '<select class="form-input acc" id="month" name="month">'."\n";
        for ($i_month = 1; $i_month <= 12; $i_month++) { 
            $selected = ($selected_month == $i_month ? ' selected' : '');
            $html .= '<option value="'.$i_month.'"'.$selected.'>'. date('M', mktime(0,0,0,$i_month)).'</option>'."\n";
        }
        $html .= '</select>'."\n";

        return $html;
    }



    public static function changePassword($data, $con){

        $account = new Account($con);
        
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];

        $html ='';
        $html .='<div class="form-div divided">              
                    <div class="form-div acc split">
                        '.$account->getError(Constants::$firstNameCharacters).'
                        <label>First Name</label>
                        <input type="text" class="form-input acc" value="'.$firstName.'" name="firstName" placeholder="First Name" required />
                    </div>
                    <div class="form-div acc split">
                        '.$account->getError(Constants::$lastNameCharacters).'
                        <label>Last Name</label>
                        <input type="text" class="form-input acc" value="'.$lastName.'" name="lastName" placeholder="Last Name" required />
                    </div>
                </div>

                <div class="form-div acc">
                    <label>Old Password</label>
                    <input type="password" class="form-input acc" name="oldpassword" placeholder="Old Password" required />
                </div>

                <div class="form-div acc">
                    <label>Password</label>

                    <input type="password" class="form-input acc" name="password" placeholder="Password" required />
                </div>

                <div class="form-div acc">
                    <label>Password Confirm</label>
                    <input type="password" class="form-input acc" name="password2" placeholder="Password Confirm" required />
                </div>';

        return $html;
    }


    public static function accountInfoCont($data){

        $username = $data['username'];
        $phone = $data['phone'];
        $address = $data['address'];
        $address2 = $data['address2'];
        $city = $data['city'];
        $postal = $data['postal'];
        $country = $data['country'];
        $prov = $data['prov'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $email = $data['email'];

        $html ='';
        $html .='<table>
                <tbody>
                    <tr>
                        <td class="tbl pt l_f"><span>First Name:</span></td>
                        <td class="tbl pv l_s">'.$firstName.'</span></td>
                        <td class="tbl pt r_f"><span>Last Name:</span></td>
                        <td class="tbl pv r_e">'.$lastName.'</span></td>
                    </tr>
                    <tr>
                        <td class="tbl pt l_f"><span>Phone:</span></td>
                        <td class="tbl pv l_s"><span>'.$phone.'</span></td>
                        <td class="tbl pt r_f"><span>Email:</span></td>
                        <td class="tbl pv r_e"><span>'.$email.'</span></td>
                    </tr>
                    <tr>
                        <td class="tbl pt l_f"><span>Address:</span></td>
                        <td class="tbl pv l_e"><span>'.$address.'</span></td>
                    </tr>
                    <tr>
                        <td class="tbl pt l_f"><span>Address2:</span></td>
                        <td class="tbl pv l_e"><span>'.$address2.'</span></td>
                    </tr>
                    <tr>
                        <td class="tbl pt l_f"><span>City:</span></td>
                        <td class="tbl pv l_s"><span>'.$city.'</span></td>
                        <td class="tbl pt r_f"><span>Postal:</span></td>
                        <td class="tbl pv r_e"><span>'.$postal.'</span></td>
                    </tr>
                    <tr>
                        <td class="tbl pt l_f"><span>Country:</span></td>
                        <td class="tbl pv l_s"><span>'.$country.'</span></td>
                        <td class="tbl pt r_f"><span>Province:</span></td>
                        <td class="tbl pv r_e"><span>'.$prov.'</span></td>
                    </tr>
                </tbody>
            </table>';

        return $html;
    }


}

?>