<?php
defined('AUTH') or die('Restricted access');
$SITE->setHeadFile('/blocks/catalog/catalog/basket/1/template/list.css');
$SITE->setHeadFile('/blocks/catalog/catalog/basket/1/template/list.js');

$hash = isset($_COOKIE['shop_order_hash']) ? $_COOKIE['shop_order_hash'] : '';
$order = $CATALOG->orderGetByHash(array(
	'catalog_id' => $data['content']['catalog_id'], 
	'hash' => $hash,
	'status' => 0
));

$d = array('catalog_id' => $data['content']['catalog_id'], 'order_id' => $order['id']);
$order_items = $CATALOG->orderGetList($d);

$sum = 0;

if ($order_items == '' || count($order_items) == 0) {
	$catalog_html .= '<h1 class="block_catalog_basket_1_title">Корзина пуста</h1>';
	return;
}

$item_html = '';
$tr_html = '';
foreach ($order_items as $order_item) {
	if ($order_item['images'] != '') {
		$images_arr = explode(';', $order_item['images']);
		$image_html = '<img class="block_catalog_basket_1_item_image" src="/files/catalogs/'.$catalog['id'].'/items/'.$images_arr[0].'">';
	} else {
		$image_html = '<img class="block_catalog_basket_1_item_image" src="/blocks/catalog/frontend/images/no_photo.png">';
	}

	$chars_html = str_replace(';', ';<br>', $order_item['chars']);

	if ($order_item['quantity'] == intval($order_item['quantity'])) {
		$quantity = 
		'<input name="quantity['.$order_item['id'].']" type="number" '.
		'class="block_catalog_basket_1_item_quantity" value="'.intval($order_item['quantity']).'" '.
		'min="1" max="1000" step="1" data-price="'.$order_item['price'].'">';		
	} else {
		$quantity = 
		'<input name="quantity['.$order_item['id'].']" type="number" '.
		'class="block_catalog_basket_1_item_quantity" value="'.$order_item['quantity'].'" '.
		'min="0.001" max="1000" step="0.001" data-price="'.$order_item['price'].'">';			
	}

	$item_sum = $order_item['price'] * $order_item['quantity'];
	$sum += $item_sum;
	$item_html .= 
	'<div id="block_catalog_basket_1_item_'.$order_item['id'].'" class="block_catalog_basket_1_item_container">'.
		'<div class="block_catalog_basket_1_item_wrap_image">'.$image_html.'</div>'.
		'<div class="block_catalog_basket_1_item_name">'.
			'<div>'.
				'<a class="block_catalog_basket_1_a" href="/'.$catalog['url'].'/'.$order_item['section_url'].'/'.$order_item['item_url'].'" target="_blank">'.
					$order_item['name'].
				'</a>'.
				'<div class="block_catalog_basket_1_chars">'.$chars_html.'</div>'.
			'</div>'.
		'</div>'.
		'<div class="block_catalog_basket_1_item_quantity_wrap">'.
			'<button class="block_catalog_basket_1_item_quantity_minus" type="button">-</button>'.
			$quantity.
			'<button class="block_catalog_basket_1_item_quantity_plus" type="button">+</button>'.
		'</div>'.
		'<div class="block_catalog_basket_1_item_price_wrap">'.
			'<span class="block_catalog_basket_1_item_price">'.$order_item['price'].'</span>'.
			'<span class="block_catalog_basket_1_item_price_currency">'.$catalog['settings']['shop_currency'].'</span>'.
		'</div>'.
		'<div class="block_catalog_basket_1_item_sum_wrap">'.
			'<span class="block_catalog_basket_1_item_sum">'.$item_sum.'</span>'.
			'<span class="block_catalog_basket_1_item_sum_currency">'.$catalog['settings']['shop_currency'].'</span>'.
		'</div>'.
		'<div class="block_catalog_basket_1_item_delete">'.
			'<img class="block_catalog_basket_1_delete" src="/blocks/catalog/frontend/images/delete.png" border="0" alt="" data-id="'.$order_item['id'].'" data-hash="'.$hash.'">'.
		'</div>'.
	'</div>';
}


// --- Купоны ---
$coupons_html = '';
$coupons_count = $CATALOG->couponsCount($data['content']['catalog_id']);

if (count($coupons_count) > 0) {
	$coupons_html = 
	'<div class="block_catalog_basket_1_coupons_container">'.
		'<div class="block_catalog_basket_1_coupons_text">Промо-код</div>'.
		'<div class="block_catalog_basket_1_coupons_wrap_input">'.
			'<input id="block_catalog_basket_1_coupons_cod" name="coupon" class="dan_input">'.
		'</div>'.
		'<div id="block_catalog_basket_1_coupons_buttton" class="block_catalog_basket_1_coupons_buttton">Применить</div>'.
		'<div id="block_catalog_basket_1_coupons_discount_wrap" class="block_catalog_basket_1_coupons_discount_wrap"></div>'.
		'<div id="block_catalog_basket_1_coupons_sum_wrap" class="block_catalog_basket_1_coupons_sum_wrap"></div>'.
	'</div>';
}


$catalog_html .= 
'<div class="dan_flex_row">'.
	'<form class="block_catalog_basket_1_form" method="POST" action="/'.$catalog['url'].'/basket/form">'.
		'<div itemscope itemtype="http://schema.org/Product">'.
			'<h1 class="block_catalog_basket_1_title">Корзина</h1>'.
			'<div class="dan_even_odd">'.
				$item_html.
			'</div>'.
			'<div class="block_catalog_basket_1_sum_wrap">Итого: <b id="block_catalog_basket_1_sum">'.
				$sum.'</b> <span id="block_catalog_basket_1_sum_currency" class="block_catalog_basket_1_sum_currency">'.$catalog['settings']['shop_currency'].'</span>'.
			'</div>'.
			$coupons_html.
			'<div class="block_catalog_basket_1_button_wrap">'.
				'<input id="block_catalog_basket_1_button" class="block_catalog_basket_1_button" value="Оформить" type="submit" data-cu="'.$catalog['url'].'">'.
			'</div>'.
			'<input type="hidden" name="hash" value="'.$hash.'">'.
		'</div>'.
	'</form>'.
'</div>';
