<?php
defined('AUTH') or die('Restricted access');

$chars_html = '';
if (isset($_POST['char'])) {
	foreach ($_POST['char'] as $char_id => $char_value) {
		$d = array(
			'catalog_id' => $data['content']['catalog_id'],
			'id' => $char_id
		);
		$char_name = $CATALOG->charsGetName($d);
		$chars_html .= $char_name.': '.$char_value.';';
	}
}

$quantity = 1;

$d['catalog_id'] = $data['content']['catalog_id'];
$d['item_id'] = intval($_POST['item_id']);
$d['user_id'] = 0;
$d['description'] = '';
$d['sum'] = 0;
$d['payment_system'] = '';
$d['status'] = 0;
$d['chars'] = $chars_html;
$d['quantity'] = $quantity;

if (isset($_COOKIE['shop_order_hash'])) {  // Найден открытый заказ
	$order = $CATALOG->orderGetByHash(array(
		'catalog_id' => $data['content']['catalog_id'], 
		'hash' => $_COOKIE['shop_order_hash'],
		'status' => 0
	));
	$hash = $_COOKIE['shop_order_hash'];
	$d['hash'] = $hash;

	if ($order) 
		$d['order_id'] = $order['id'];
	else
		$d['order_id'] = $CATALOG->orderNew($d);
} else {  // Заказ не найден, добавляем товары в заказ
	$rand = time().mt_rand(0, 999999);
	$hash = hash("sha256", 'shop_order_hash'.$rand);
	setcookie('shop_order_hash', $hash, (time() + 60*60*24*365), '/', '.'.$SITE->domain, False, True);

	$d['hash'] = $hash;
	$d['order_id'] = $CATALOG->orderNew($d);
}

$CATALOG->orderAddItem($d);

echo json_encode(array('answer' => 'success'));
exit();