<?php
class Account {

    private $con;
    private $errorArray = array();
    private $sqlData = array();
    private $newid;

    public function __construct($con) {
        $this->con = $con;
    }

    
    public function login($un, $pw) {
        $pw = hash("sha512", $pw);

        $query = $this->con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");
        $query->bindValue(":un", $un);
        $query->bindValue(":pw", $pw);
                                    // if($query->rowCount() == 1) {
        if($query->execute()){
            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
            return $this->sqlData;
        } 

        array_push($this->errorArray, Constants::$loginFailed);
        return false;
    }
    
    public function logout() { session_start(); session_destroy(); }


    public function updateDetails($fn, $ln, $em, $un, $pw) {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateNewEmail($em, $un);

        if(empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE users SET firstName=:fn, lastName=:ln, email=:em
                                            WHERE username=:un");
            $query->bindValue(":fn", $fn);
            $query->bindValue(":ln", $ln);
            $query->bindValue(":em", $em);
            $query->bindValue(":un", $un);

            return $query->execute();
        }

        return false;
    }

    public function register($fn, $ln, $un, $em, $pw, $pw2) {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUsername($un);
        $this->validateEmails($em);
        $this->validatePasswords($pw, $pw2);

        if(empty($this->errorArray)) {
            return $this->insertUserDetails($fn, $ln, $un, $em, $pw);
        }
        return false;
    }

    private function insertUserDetails($fn, $ln, $un, $em, $pw) {
        
        $pw = hash("sha512", $pw);
        $query = $this->con->prepare("INSERT INTO users (firstName, lastName, username, email, password)
                                        VALUES (:fn, :ln, :un, :em, :pw)");
        $query->bindValue(":fn", $fn);
        $query->bindValue(":ln", $ln);
        $query->bindValue(":un", $un);
        $query->bindValue(":em", $em);
        $query->bindValue(":pw", $pw);

        if($query->execute()){
            $this->newid = $this->con->lastInsertId();
            return $this->newid;
        } else {
            return false;
        }
    }


    public function orders($fn, $ln, $ph, $ad, $ad2, $co, $pr, $ci, $po) {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validatePhone($ph);
        $this->validateAddress($ad);
        $this->validateCity($ci);
        $this->validatePostal($po);

        if(empty($this->errorArray)) {
            return true;
        } else {
            return false;
        }
    }

    public function insertOrders($o_c, $o_s, $u_i, $c_i, $fn, $ln, $ph, $ad, $ad2, $co, $pr, $ct, $po, $sa) {

        $query = $this->con->prepare("INSERT INTO orders (order_cost, order_status, user_id, card_id, username, phone, address, address2, country, prov, city, postal, saveAddress)
                                        VALUES (:o_c, :o_s, :u_i, :c_i, :un, :ph, :ad, :ad2, :co, :pr, :ct, :po, :sa)");
        $query->bindValue(":o_c", $o_c);
        $query->bindValue(":o_s", $o_s);
        $query->bindValue(":u_i", $u_i);
        $query->bindValue(":c_i", $c_i);
        $query->bindValue(":un", $fn." ".$ln);

        $query->bindValue(":ph", $ph);
        $query->bindValue(":ad", $ad);
        $query->bindValue(":ad2", $ad2);
        $query->bindValue(":co", $co);
        $query->bindValue(":pr", $pr);
        
        $query->bindValue(":ct", $ct);
        $query->bindValue(":po", $po);
        $query->bindValue(":sa", $sa);

        if($query->execute()){
            $this->newid = $this->con->lastInsertId();
            $new_o_id = $this->newid;
            
            function getRandomChar($nid) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 3; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                $randomNumber = rand(100,999);
                $uniqid = $randomNumber.'-'.$nid.$randomString;
                               
                return $uniqid;
            }

            $uniq_id = getRandomChar($new_o_id);

            $query2 = $this->con->prepare("UPDATE orders 
                                            SET order_myId = :o_mi
                                            WHERE order_id = :o_id");
                                            
            $query2->bindValue(":o_mi", $uniq_id);
            $query2->bindValue(":o_id", $new_o_id);

            if($query2->execute()){
                return $this->newid;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }


    public function checkCard ($u_i, $cv, $ex, $cn, $pn, $sc) {
        
        $this->validateCvv($cv);
        $this->validateCardNumber($cn);
        $this->validateExpire($ex);
        
        if(empty($this->errorArray)) {

            if($sc != null){
                $query = $this->con->prepare("INSERT INTO card (user_id, card_cvv, card_expire, card_number, printname)
                                            VALUES (:ui, :cv, :ex, :cn, :pn)");
                $query->bindValue(":ui", $u_i);
                $query->bindValue(":cv", $cv);
                $query->bindValue(":ex", $ex);
                $query->bindValue(":cn", $cn);
                $query->bindValue(":pn", $pn);
                
                if($query->execute()){
                    $this->newid = $this->con->lastInsertId();
                    return $this->newid;
                } 
            } else {
                return true;
            }
        }
        return false;
    }


    public function order_items ($u_i, $o_i, $p_id, $pn, $pimg, $price, $qty) {

        $query = $this->con->prepare("INSERT INTO order_items (user_id, order_id, product_id, product_name, product_image1, product_price, product_quantity)
                                        VALUES (:u_i, :o_i, :p_id, :pn, :pimg, :price, :qty)");
        $query->bindValue(":u_i", $u_i);
        $query->bindValue(":o_i", $o_i);
        $query->bindValue(":p_id", $p_id);
        $query->bindValue(":pn", $pn);
        $query->bindValue(":pimg", $pimg);
        $query->bindValue(":price", $price);
        $query->bindValue(":qty", $qty);

        // if($query->rowCount() == 1) {
        if($query->execute()){
            return true;
        }
        return false;
    }

    public function getOrderInfo ($u_i){
                                            
        $query = $this->con->prepare("SELECT * FROM `orders` 
                                        INNER JOIN `orderItem` 
                                        ON orders.order_id = order_items.order_id 
                                        WHERE orders.user_id = :ui;");
        $query->bindValue(":u_i", $u_i);

        // if($query->rowCount() == 1) {
        if($query->execute()){
            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
            return $this->sqlData;
        }
        return false;
        
    }




    public function updatePassword($u_i, $un, $oldPw, $pw, $pw2) {
        $this->validateOldPassword($oldPw, $un);
        $this->validatePasswords($pw, $pw2);

        if(empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE users SET password=:pw, username=:un WHERE user_id=:u_id");
            $pw = hash("sha512", $pw);
            $query->bindValue(":pw", $pw);
            $query->bindValue(":u_id", $u_i);
            $query->bindValue(":un", $un);

            return $query->execute();
        }

        return false;
    }

    public function registSubscript($ph, $em, $bd, $un) {
        $this->validatePhone($ph);
        $this->validateNewEmail($em, $un);

        if(empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE users SET phone=:ph, email=:em, bod=:bd WHERE username=:un");
            $query->bindValue(":ph", $ph);
            $query->bindValue(":em", $em);
            $query->bindValue(":bd", $bd);
            $query->bindValue(":un", $un);

            return $query->execute();
        }

        return false;
    }




    public function getUserInfo($u_i){
                                            
        $query = $this->con->prepare("SELECT * FROM orders od
                                        LEFT JOIN users us 
                                        ON od.user_id = us.user_id
                                        WHERE 1 = 0 
                                            UNION ALL
                                            SELECT * FROM orders od
                                            RIGHT JOIN users us
                                            ON od.user_id = us.user_id
                                            WHERE od.user_id = :u_id ;");

        $query->bindValue(":u_id", $u_i);
    
        if($query->execute()){
            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
            return $this->sqlData;
        }
        return false;
        
    }










    /* ------------------------------------- */

    private function validateFirstName($fn) {
        if(strlen($fn) < 2 || strlen($fn) > 25) {
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    private function validateLastName($ln) {
        if(strlen($ln) < 2 || strlen($ln) > 25) {
            array_push($this->errorArray, Constants::$lastNameCharacters);
        }
    }

    private function validateUsername($un) {
        if(strlen($un) < 2 || strlen($un) > 25) {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }

        $query = $this->con->prepare("SELECT * FROM users WHERE username=:un");
        $query->bindValue(":un", $un);

        $query->execute();
        
        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$usernameTaken);
        }
    }

    private function validateEmails($em) {

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT * FROM users WHERE email=:em");
        $query->bindValue(":em", $em);

        $query->execute();
        
        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    private function validateNewEmail($em, $un) {

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT * FROM users WHERE email=:em AND username != :un");
        $query->bindValue(":em", $em);
        $query->bindValue(":un", $un);

        $query->execute();
        
        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    private function validatePasswords($pw, $pw2) {
        if($pw != $pw2) {
            array_push($this->errorArray, Constants::$passwordsDontMatch);
            return;
        }

        if(strlen($pw) < 5 || strlen($pw) > 25) {
            array_push($this->errorArray, Constants::$passwordLength);
        }
    }

    public function validateOldPassword($oldPw, $un) {
        $pw = hash("sha512", $oldPw);

        $query = $this->con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");
        $query->bindValue(":un", $un);
        $query->bindValue(":pw", $pw);

        $query->execute();

        if($query->rowCount() == 0) {
            array_push($this->errorArray, Constants::$passwordIncorrect);
        }
    }

/* ^[0-9-+]$ */
    private function validatePhone($ph) {
        if(!filter_var($ph, FILTER_SANITIZE_NUMBER_INT)) {
            array_push($this->errorArray, Constants::$phoneCharacters);
            return;
        }
        if(strlen($ph) < 9 || strlen($ph) > 11) {
            array_push($this->errorArray, Constants::$phoneCharacters);
            return;
        }
        if (!preg_match('/[0-9]/',$ph)) { 
            array_push($this->errorArray, Constants::$phoneInvalid);
            return;
        }
    }

    private function validateAddress($ad) {
        if(strlen($ad) != 2) {
            array_push($this->errorArray, Constants::$addressCharacters);
            return;
        }
        if(!preg_match('/^(?:\\d+ [a-zA-Z ]+, ){2}[a-zA-Z ]+$/', $ad)) {
            array_push($this->errorArray, Constants::$addressCharacters);
            return;
        }
    }

    private function validateCity($ad) {
        if(strlen($ad) != 2) {
            array_push($this->errorArray, Constants::$cityCharacters);
            return;
        }
    }

    private function validatePostal($po) {
        if(strlen($po) != 6) {
            array_push($this->errorArray, Constants::$postalCharacters);
            return;
        }
        if (!preg_match('/^[0-9-+]$/',$po)) { 
            array_push($this->errorArray, Constants::$postalCharacters);
            return;
        }
    }



    private function validateCvv($cv) {
        if(!preg_match('/\d{3}/',$cv)) {
            array_push($this->errorArray, Constants::$cvvCharLength);
            return;
        }
    }
    private function validateCardNumber($cn) {
        if(!preg_match('/\d{12}/',$cn)) {
            array_push($this->errorArray, Constants::$cardNumberLength);
            return;
        }
    }
    private function validateExpire($ex) {
        if(!preg_match('/\d{4}/',$ex)) {
            array_push($this->errorArray, Constants::$expireCharLength);
            return;
        }
    }





    /*  */
    public function getError($error) {
        if(in_array($error, $this->errorArray)) {
            return "<span class='errorMessage'>$error</span>";
        }
    }

    public function getFirstError() {
        if(!empty($this->errorArray)) {
            return $this->errorArray[0];
        }
    }



}
?>