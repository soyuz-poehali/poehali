<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/classes/AdminPoehali.php';
$POEHALI = new AdminPoehali();

$data['id'] = intval($SITE->url_arr[5]);
$data['act'] = $SITE->url_arr[4];

$POEHALI->blogerSetOrdering($data);

header('location: /admin/com/poehali/blogers');
exit;