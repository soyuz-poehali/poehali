<?php
defined('AUTH') or die('Restricted access');

include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/classes/AdminPoehali.php';
$POEHALI = new AdminPoehali();

$id = $SITE->url_arr[5];

$POEHALI->projectDelete($id);

header('location: /admin/com/poehali/projects');
exit;