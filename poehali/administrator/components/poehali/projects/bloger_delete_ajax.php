<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/classes/AdminPoehali.php';
$POEHALI = new AdminPoehali();

$id = $_POST['id'];
$POEHALI->projectBlogerDelete($id);

echo json_encode(array('answer' => 'success'));
exit();
