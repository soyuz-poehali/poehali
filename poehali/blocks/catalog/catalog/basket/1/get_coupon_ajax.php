<?php
defined('AUTH') or die('Restricted access');


$cod = trim(htmlspecialchars(strip_tags($_POST['cod'])));
$d = array(
	'catalog_id' => $data['content']['catalog_id'],
	'code' => $cod
);

$discount = $CATALOG->couponsGet($d);

$message = '';

if ($discount == 0) {
	$message = 'Промо код не найден';
	$discount = '';
} 

echo json_encode(array('answer' => 'success', 'message' => $message, 'discount' => $discount));
exit();