<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
	'protocol' => "smtp",
    'smtp_host' => "smtp.hostinger.com", 
    'smtp_port' => 465,
    'smtp_user' => "admin@remajacemput.pe.hu",
    'smtp_pass' => "Admin123#@!",
    'smtp_crypto' => "tls",
    'mailtype' => 'text/plan',
    'smtp_timeout' => '4',
    'charset' => 'utf-8',
    'wordwrap' => TRUE,
    'crlf'    => "\r\n",
    'newline' => "\r\n"
);