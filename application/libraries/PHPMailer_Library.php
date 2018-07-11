<?php defined('BASEPATH') OR exit('No direct script access allowed.');

class PHPMailer_Library
{
    public function __construct()
    {
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load()
    {
        require_once(APPPATH."third_party/phpmailer/PHPMailerAutoload.php");
        $objMail = new PHPMailer;
        return $objMail;
    }
}   