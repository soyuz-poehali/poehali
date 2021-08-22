<?php
defined('AUTH') or die('Restricted access');
$SITE->setHeadFile('/blocks/catalog/catalog/basket/1/template/form.css');

$hash = $_POST['hash'];
$coupon = isset($_POST['coupon']) ? $_POST['coupon'] : '';
$order = $CATALOG->orderGetByHash(array(
	'catalog_id' => $data['content']['catalog_id'], 
	'hash' => $_COOKIE['shop_order_hash'],
	'status' => 0
));

foreach ($_POST['quantity'] as $id => $quantity) {
	$d = array(
		'catalog_id' => $data['content']['catalog_id'],
		'id' => $id,
		'quantity' => $quantity
	);
	$CATALOG->orderUpdateItemQuantity($d);

	if ($coupon != '') {
		$d = array(
			'catalog_id' => $data['content']['catalog_id'],
			'coupon' => $coupon,
			'id' => $order['id']
		);
		$CATALOG->orderUpdateCoupon($d);
	}
}

$catalog['catalog_html'] = 
'<div class="dan_flex_row">'.
	'<form class="block_catalog_basket_1_form" method="POST" action="/'.$catalog['url'].'/basket/send">
		<div itemscope itemtype="http://schema.org/Product">
			<h1 class="block_catalog_basket_1_title">Ваши данные:</h1>
			<div class="block_catalog_basket_1_wrap">
				<div class="block_catalog_basket_1_text">Ваше имя</div>
				<div class="block_catalog_basket_1_input_wrap"><input class="dan_input" name="name" type="text" required></div>
			</div>
			<div class="block_catalog_basket_1_wrap">
				<div class="block_catalog_basket_1_text">Телефон</div>
				<div class="block_catalog_basket_1_input_wrap"><input class="dan_input" type="tel" name="phone" value="+7" required></div>
			</div>
			<div class="block_catalog_basket_1_wrap">
				<div class="block_catalog_basket_1_text">Email</div>
				<div class="block_catalog_basket_1_input_wrap"><input class="dan_input" type="email" name="email" required></div>
			</div>
			<div class="block_catalog_basket_1_wrap">
				<div class="block_catalog_basket_1_text">Адрес</div>
				<div class="block_catalog_basket_1_input_wrap"><textarea class="dan_input" name="address" required></textarea></div>
			</div>
			<div class="block_catalog_basket_1_wrap">
				<div class="block_catalog_basket_1_text">Комментарии</div>
				<div class="block_catalog_basket_1_input_wrap"><textarea class="dan_input" rows="5" name="comments"></textarea></div>
			</div>
			<div class="block_catalog_basket_1_personal_information_wrap">
				<input required="" checked="" title="Вы должны дать согласие перед отправкой" type="checkbox">
				Я согласен на <a href="/personal_information" target="_blank">обработку персональных данных</a>
			</div>
			<input id="block_catalog_basket_1_button" class="block_catalog_basket_1_button" value="Отправить" type="submit">
			<input type="hidden" name="hash" value="'.$hash.'">
		</div>
	</form>'.
'</div>';