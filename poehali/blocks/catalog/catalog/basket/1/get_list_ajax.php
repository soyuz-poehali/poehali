<?php
defined('AUTH') or die('Restricted access');

$hash = $_COOKIE['shop_order_hash'];
$order = $CATALOG->orderGetByHash(array(
	'catalog_id' => $data['content']['catalog_id'], 
	'hash' => $hash,
	'status' => 0
));

$d = array('catalog_id' => $data['content']['catalog_id'], 'order_id' => $order['id']);
$order_items = $CATALOG->orderGetList($d);

$sum = 0;

if ($order_items == '' || count($order_items) == 0) {
	$html = '<div class="block_menu_basket_title">Корзина пуста</div>';
	echo json_encode(array('answer' => 'success', 'html' => $html));
	exit();
}


$html = '';
$item_html = '';
$tr_html = '';
$quantity_sum = '';
$sum = '';
foreach ($order_items as $order_item) {
	if ($order_item['images'] != '') {
		$images_arr = explode(';', $order_item['images']);
		$image_html = '<img class="block_menu_basket_item_image" src="/files/catalogs/'.$catalog['id'].'/items/'.$images_arr[0].'">';
	} else {
		$image_html = '<img class="block_menu_basket_item_image" src="/blocks/catalog/frontend/images/no_photo.png">';
	}

	$chars_html = str_replace(';', ';<br>', $order_item['chars']);
	$quantity = $order_item['quantity'] == intval($order_item['quantity']) ? intval($order_item['quantity']) : $order_item['quantity'];
	$quantity_sum += $quantity;
	$item_sum = $order_item['price'] * $quantity;
	$sum += $item_sum;

	$item_html .= 
	'<div id="block_menu_basket_item_'.$order_item['id'].'" class="block_menu_basket_item_container">'.
		'<div class="block_menu_basket_item_wrap_image">'.$image_html.'</div>'.
		'<div class="block_menu_basket_item_name">'.
			'<div>'.
				'<a class="block_menu_basket_item_a" href="/'.$catalog['url'].'/'.$order_item['section_url'].'/'.$order_item['item_url'].'" target="_blank">'.
					$order_item['name'].
				'</a>'.
				'<div class="block_menu_basket_item_chars">'.$chars_html.'</div>'.
				'<div class="block_menu_basket_item_sum">'.
					'<span class="block_menu_basket_item_price">'.number_format($order_item['price'], 0, '', ' ').'</span> '.
					$catalog['settings']['shop_currency'].' x '.
					'<span class="block_menu_basket_item_price">'.$quantity.'</span> шт.'.					
				'</div>'.
			'</div>'.
		'</div>'.
		'<div class="block_menu_basket_item_delete">'.
			'<img class="block_menu_basket_delete" src="/blocks/catalog/frontend/images/delete.png" border="0" alt="" data-id="'.$order_item['id'].'" data-hash="'.$hash.'">'.
		'</div>'.
	'</div>';
}

$html = 
	'<div class="block_menu_basket_list_quantity">Товаров: <b>'.$quantity_sum.'</b> шт.</div>'.
	'<div class="block_menu_basket_list_sum">На сумму: <b>'.number_format($sum, 0, '', ' ').'</b> '.$catalog['settings']['shop_currency'].'</div>'.
	$item_html.
	'<div class="block_menu_basket_wrap_button"><a href="/'.$catalog['url'].'/basket/list" class="block_menu_basket_button">Оформить заказ</a></div>';

echo json_encode(array('answer' => 'success', 'html' => $html, 'quantity' => $quantity_sum, 'sum' => $sum, 'sum_html' => number_format($sum, 0, '', ' ')));
exit();