<?php
defined('AUTH') or die('Restricted access');

include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/personal_information/classes/PersonalInformation.php';

$PI = new PersonalInformation();
$PI->updateText($_POST['editor1']);

header('location: /admin');