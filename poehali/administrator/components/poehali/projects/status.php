<?php
defined('AUTH') or die('Restricted access');

include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/classes/AdminPoehali.php';
$POEHALI = new AdminPoehali();

$status_arr = ['inactive' => 0, 'active' => 1, 'completed' => 2];
$status = $status_arr[$SITE->url_arr[4]];

$data = array('id' => $SITE->url_arr[5], 'status' => $status);
$POEHALI->projectSetStatus($data);

header('location: /admin/com/poehali/projects');
