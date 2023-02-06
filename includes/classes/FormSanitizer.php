<?php
class FormSanitizer {

    public static function sanitizeFormString($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        // $inputText = trim($inputText);
        // $inputText = strtolower($inputText);
        // $inputText = ucfirst($inputText);
        return $inputText;
    }

    public static function sanitizeFormUsername($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
    }

    public static function sanitizeFormPassword($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
    }

    public static function sanitizeFormEmail($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
    }

    public static function sanitizeFormPhone($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        $inputText = str_replace("-", "", $inputText);
        $inputText = preg_replace('/[^0-9]/', '', $inputText);
        return $inputText;
    }
    // if(strlen($_POST['phone']) === 10) {
    // if (!preg_match('/^[0-9-+]$/',$var)) { // error } else { // good }}

    public static function sanitizeFormPostal($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        $inputText = strtoupper($inputText);
        return $inputText;
    }


    public static function sanitizeFormCardNumber($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
    }
    public static function sanitizeFormCVV($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
    }
    public static function sanitizeFormExpire($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
    }
    public static function sanitizeFormPrintName($inputText) {
        $inputText = strip_tags($inputText);
        return $inputText;
    }


}
?>