<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/classes/AdminPoehali.php';
$POEHALI = new AdminPoehali();

if ($SITE->url_arr[4] == 'pub')
	$status = 1;
else
	$status = 0;

$data = array('id' => $SITE->url_arr[5], 'status' => $status);
$POEHALI->blogerSetStatus($data);

header('location: /admin/com/poehali/blogers');
