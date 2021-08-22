<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/classes/AdminPoehali.php';
$POEHALI = new AdminPoehali();

$id = $SITE->url_arr[5];
$bloger = $POEHALI->blogerGet($id);

$file = $_SERVER['DOCUMENT_ROOT'].'/files/poehali/blogers/'.$bloger['image'];

if (is_file($file))
	unlink($file);

$POEHALI->blogerDelete($id);

header('location: /admin/com/poehali/blogers');
exit;