<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/blocks/menu/frontend/1/BLOCK.menu.css');
$SITE->setHeadFile('/blocks/menu/frontend/1/BLOCK.menu.js');

$catalog_id = $content['basket']['catalog_id'];

$area_logo = $area_logo_text = $area_right = $area_phone_1 = $area_phone_2 = $area_sn = $area_right_text = $area_basket = '';

// Область слева
if ($content['logo']['pub'] == '1') {
	$area_logo = '<a href="/" class="block_menu_top_logo"><img src="/files/pages/0/menu/'.$content['logo']['logo'].'" alt="logo"></a>';
}

$area_logo_text = '<div class="block_menu_top_logo_text">'.$content['logo_text'].'</div>';

// --- Область справа ---
if ($content['phone_1']['pub'] == '1') {
	$phone_number = preg_replace('/[^0-9]/', '', $content['phone_1']['phone']);
	$phone_number_plus = $phone_number[0] == 7 ? '+'.$phone_number : $phone_number;

	$area_phone_1_phone = '<a href="tel:'.$phone_number_plus.'" style="color:'.$content['phone_1']['color'].'">'.$content['phone_1']['phone'].'</a>';
	$area_phone_1_whatsapp = $content['phone_1']['whatsapp'] == 1 ? '<a href="whatsapp://send?phone='.$phone_number_plus.'" title="WhatsApp"><svg class="svg_whatsapp"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#whatsapp"></use></svg></a>' : '';
	$area_phone_1_viber = $content['phone_1']['viber'] == 1 ? '<a href="viber://add?number='.$phone_number.'" title="Viber"><svg class="svg_viber"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#viber"></use></svg></a>' : '';

	$area_phone_1 = '<div>'.$area_phone_1_phone.$area_phone_1_whatsapp.$area_phone_1_viber.'</div>';
}

if ($content['phone_2']['pub'] == '1') {
	$phone_number = preg_replace('/[^0-9]/', '', $content['phone_2']['phone']);
	$phone_number_plus = $phone_number[0] == 7 ? '+'.$phone_number : $phone_number;

	$area_phone_2_phone = '<a href="tel:'.$phone_number_plus.'" style="color:'.$content['phone_2']['color'].'">'.$content['phone_2']['phone'].'</a>';
	$area_phone_2_whatsapp = $content['phone_2']['whatsapp'] == 1 ? '<a href="whatsapp://send?phone='.$phone_number_plus.'" title="WhatsApp"><svg class="svg_whatsapp"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#whatsapp"></use></svg></a>' : '';
	$area_phone_2_viber = $content['phone_2']['viber'] == 1 ? '<a href="viber://add?number='.$phone_number.'" title="Viber"><svg class="svg_viber"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#viber"></use></svg></a>' : '';

	$area_phone_2 = '<div>'.$area_phone_2_phone.$area_phone_2_whatsapp.$area_phone_2_viber.'</div>';
}

if ($content['sn']['pub'] == '1') {
	$area_sn_vk = $content['sn']['vk'] != '' ? '<a href="'.$content['sn']['vk'].'" target="_blank"><svg class="svg_vk"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#vk"></use></svg></a>' : '';
	$area_sn_fb = $content['sn']['fb'] != '' ? '<a href="'.$content['sn']['fb'].'" target="_blank"><svg class="svg_fb"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#fb"></use></svg></a>' : '';
	$area_sn_youtube = $content['sn']['youtube'] != '' ? '<a href="'.$content['sn']['youtube'].'" target="_blank"><svg class="svg_youtube"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#youtube"></use></svg></a>' : '';
	$area_sn_instagram = $content['sn']['instagramm'] != '' ? '<a href="'.$content['sn']['instagramm'].'" target="_blank"><svg class="svg_instagram"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#instagram"></use></svg></a>' : '';
	$area_sn = '<div class="block_menu_top_sn">'.$area_sn_vk.$area_sn_fb.$area_sn_youtube.$area_sn_instagram.'</div>';
}

$area_right_text = '<div class="e_block_modal_menu_area_right_text">'.$content['right_text'].'</div>';

if ($area_phone_1.$area_phone_2.$area_sn.$area_right_text != '') {
	$area_right = '<div class="block_menu_top_right">'.$area_phone_1.$area_phone_2.$area_sn.$area_right_text.'</div>';
}


// --- Корзина ---
if ($content['basket']['pub'] == '1' && !($SITE->page['type'] == 'catalog' && $SITE->url_arr[1] == 'basket')) {  // Не показываем в интерфейсе корзины каталога
	$SITE->setHeadFile('/lib/DAN/popup/popup.js');
	$SITE->setHeadFile('/lib/DAN/popup/popup.css');	
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/classes/BlockCatalog.php';
	$CATALOG = new BlockCatalog;

	$hash = isset($_COOKIE['shop_order_hash']) ? $_COOKIE['shop_order_hash'] : '';
	$catalog = $CATALOG->getCatalog($catalog_id);

	if ($catalog) {
		$order = $CATALOG->orderGetByHash(array(
			'catalog_id' => $catalog_id, 
			'hash' => $hash,
			'status' => 0
		));
		
		$d = array(
			'catalog_id' => $catalog_id, 
			'order_id' => $order['id']
		);
		$order_items = $CATALOG->orderGetList($d);

		$price = $price_sale = 0;
		$sum = 0;
		$quantity = 0;

		// --- Идентификатор цены со скидкой ---
		$price_sale_type_id = $CATALOG->priceGetTypeIdByName(array(  // Получаем идентификатор цены со скидкой
			'catalog_id' => $catalog_id, 
			'name' => 'Цена со скидкой'
		));

		if ($order_items != '' && count($order_items) > 0) {
			foreach ($order_items as $order_item) {
				// --- Цена со скидкой ---
				if ($price_sale_type_id) {
					$price_sale = $CATALOG->priceGetValueByItemId(array(
						'catalog_id' => $catalog_id,
						'price_type_id' => $price_sale_type_id,
						'item_id' => $order_item['item_id']
					));
				}

				$price = $price_sale && $price_sale > 0 ? $price_sale : $order_item['price'];
				$quantity += $order_item['quantity'];
				$sum += $order_item['quantity'] * $price;
			}
			$round_style = '';
		} else {
			$round_style = 'style="display:none;"';
		}

		$order_items_html = '<div id="block_menu_basket_round" class="block_menu_basket_round" '.$round_style.'>'.$quantity.'</div>';

		$sum_style = $sum > 0 ? '' : 'style="display:none;"';
		$sum_html = 
		'<div id="block_menu_basket_sum_container" class="block_menu_basket_sum" '.$sum_style.'>'.
			'<span id="block_menu_basket_sum">'.number_format($sum, 0, '', ' ').'</span> '.
			'<span class="block_menu_basket_currency">'.$catalog['settings']['shop_currency'].'</span>'.
		'</div>';

		$area_basket = 
		'<div id="block_menu_basket" class="block_menu_basket" data-cu="'.$catalog['url'].'" data-hash="'.$hash.'">'.
			$order_items_html.
			'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 3l-.743 2h-1.929l-3.474 12h-13.239l-4.615-11h16.812l-.564 2h-13.24l2.937 7h10.428l3.432-12h4.195zm-15.5 15c-.828 0-1.5.672-1.5 1.5 0 .829.672 1.5 1.5 1.5s1.5-.671 1.5-1.5c0-.828-.672-1.5-1.5-1.5zm6.9-7-1.9 7c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5 1.5-.671 1.5-1.5c0-.828-.672-1.5-1.5-1.5z"/></svg>'.
			$sum_html.
		'</div>';
	}
}

// Меню
$MENU = new Menu;
$menu_arr = $MENU->getMenu('top');

$area_menu = '<div class="block_menu_top_wrap">'.tree($SITE, $MENU, $menu_arr, 0, 1).'</div>';

$out =
'<div id="block_'.$data['id'].'" class="block block_menu">'.
	'<div class="dan_flex_between block_menu_wrap">'.
		$area_logo.
		$area_logo_text.
		'<div id="block_menu_top_ico"><span></span></div>'.
		$area_menu.
		$area_right.
		$area_basket.
	'</div>'.
'</div>';