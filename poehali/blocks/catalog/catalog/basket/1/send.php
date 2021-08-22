<?php
defined('AUTH') or die('Restricted access');

include_once $_SERVER['DOCUMENT_ROOT'].'/classes/Mail/Mail.php';

$hash = $_POST['hash'];
$name = f_input('name');
$phone = f_input('phone');
$email = f_input('email');
$address = f_input('address');
$comments = f_input('comments');

$d = array(
	'catalog_id' => $data['content']['catalog_id'],
	'hash' => $hash,
	'status' => 0
);

// Получаем содержимое номер заказа
$order = $CATALOG->orderGetByHash($d);

// Получаем список покупок
$d = array('catalog_id' => $data['content']['catalog_id'], 'order_id' => $order['id']);
$order_items = $CATALOG->orderGetList($d);

if ($order_items == '') {
	Header ("Location: /".$catalog['url']."/basket/list"); 
	exit;	
}


$tr_html = $tr_mail_html = $order_items_html = '';
$sum = $sum_html = 0;
foreach ($order_items as $order_item) {
	$chars = str_replace(';', ';<br>', $order_item['chars']);

	$quantity = $order_item['quantity'] == intval($order_item['quantity']) ? intval($order_item['quantity']) : $order_item['quantity'];
	$item_sum = $order_item['price'] * $order_item['quantity'];
	$item_price_html  = number_format($order_item['price'], 0, '', ' ');	
	$item_sum_html  = number_format($item_sum, 0, '', ' ');

	// Для admin
	$order_items_html .= 
	'<div>'.
		'<a  href="//'.$SITE->domain.'/'.$catalog['url'].'/'.$order_item['section_url'].'/'.$order_item['item_url'].'" target="_blank">'.$order_item['name'].'</a>'.
		'<br><span style="font-size:14px;color:#999;">'.$chars.'</span>'.
	'</div>';

	// Для email
	$tr_html .= 
	'<tr>'.
		'<td style="text-align:center;">'.
			'<div style="text-align:left;">'.$order_item['name'].'</div>'.
			'<div style="text-align:left;font-size:14px;color:#999;">'.$chars.'</div>'.
		'</td>'.
		'<td style="text-align:center;">'.$quantity.'</td>'.
		'<td style="text-align:center;">'.$item_price_html.' <span style="font-size:14px;color:#999;;">'.$catalog['settings']['shop_currency'].'</span></td>'.
		'<td style="text-align:center;">'.$item_sum_html.' <span style="font-size:14px;color:#999;;">'.$catalog['settings']['shop_currency'].'</span></td>'.
	'</tr>';

	$sum += $item_sum;
	$sum_html  = number_format($sum , 0, '', ' ');
}

$itogo_sum = $sum;

// Если поле купона не пустое - ищем купон и скидку.
$email_discount_html = '';
if ($order['coupon'] != '') {
	$d = array(
		'catalog_id' => $data['content']['catalog_id'],
		'code' => $order['coupon']
	);

	$discount = $CATALOG->couponsGet($d);

	$itogo_sum = ((100 - $discount) / 100) * $sum;
	$itogo_sum_html  = number_format($itogo_sum, 0, '', ' ');

	if ($discount > 0) {
		$discount_sum = $discount * $itogo_sum /100;
		$discount_sum_html = number_format($discount_sum, 0, '', ' ');

		// Для admin
		$order_items_html .=
		'<div>'.
			'<span style="font-size:14px;color:#999;">Купон:</span> <b>'.$order['coupon'].'</b>, '.
			'<span style="font-size:14px;color:#999;">cкидка:</span> <b>'.$discount.' %</b>, '.
			'<b>- '.$discount_sum_html.'</b> <span style="font-size:14px;color:#999;;">'.$catalog['settings']['shop_currency'].'</span>'.
		'</div>';


		// Для email
		$email_discount_html =
		'<tr>'.
			'<td colspan="2"><span style="font-size:14px;color:#999;">Купон:</span> <b>'.$order['coupon'].'</b></td>'.
			'<td style="text-align:center;"><span style="font-size:14px;color:#999;">Скидка:</span> <b>'.$discount.' %</b></td>'.
			'<td style="text-align:center;"><b>- '.$discount_sum_html.'</b> <span style="font-size:14px;color:#999;;">'.$catalog['settings']['shop_currency'].'</span></td>'.
		'</tr>'.
		'<tr>'.
			'<td colspan="2"></td>'.
			'<td style="text-align:center;"><b>Итого, <br>со скидкой:</b></td>'.
			'<td style="text-align:center;"><b style="font-size:32px;">'.$itogo_sum_html.'</b> <span style="font-size:14px;color:#999;;">'.$catalog['settings']['shop_currency'].'</span></td>'.
		'</tr>';
	}
}

$email_html = 
	'<div style="font-family: \'Open Sans\', sans-serif;">'.
		'<div style="margin:20px;">'.
			'<div><span style="font-size:14px;color:#999;">ФИО:</span> <b>'.$name.'</b></div>'.
			'<div><span style="font-size:14px;color:#999;">email:</span> <b>'.$email.'</b></div>'.
			'<div><span style="font-size:14px;color:#999;">Телефон:</span> <b>'.$phone.'</b></div>'.
			'<div><span style="font-size:14px;color:#999;">Адрес:</span> <b>'.$address.'</b></div>'.
			'<div><span style="font-size:14px;color:#999;">Комментарии:</span> <b>'.$comments.'</b></div>'.
		'</div>'.
		'<table border="1" cellpadding="10" cellspacing="0" style="min-width: 600px;">'.
			'<tr>'.
				'<th>Наимерование</th>'.
				'<th style="width:100px;">Кол-во</th>'.
				'<th style="width:100px;">Цена</th>'.
				'<th style="width:100px;">Сумма</th>'.				
			'</tr>'.
			$tr_html.
			'<tr>'.
				'<td colspan="2"></td>'.
				'<td style="text-align:center;"><b>Итого:</b></td>'.
				'<td style="text-align:center;"><b>'.$sum_html.'</b> <span style="font-size:14px;color:#999;;">'.$catalog['settings']['shop_currency'].'</span></td>'.
			'</tr>'.
			$email_discount_html.
		'</table>'.
	'</div>';

$d = array(
	'catalog_id' => $data['content']['catalog_id'],
	'description' => $order_items_html,
	'data' => '',
	'sum' => $itogo_sum,
	'fio' => $name,
	'phone' => $phone,
	'email' => $email,
	'address' => $address,
	'comments' => $comments,
	'order_id' => $order['id']
);

$CATALOG->orderComplete($d);


// ------- ОТПРАВКА НА EMAIL -------
$dmn = empty($SITE->domain_idn) ? $SITE->domain : $SITE->domain_idn;
$subject = 'Заказ из интернет-магазина '.$SITE->domain;

$MAIL = new Mail;
$MAIL->send($SITE->email, $dmn, $subject, $email_html);


$catalog_html .= 
'<div style="width:100%;">'.
	'<h1 class="block_catalog_basket_1_title">Ваш заказ отправлен</h1>'.
	'<div>В ближайшее время мы свяжемся с Вами для уточнения деталей.</div>'.
'</div>';


function f_input($name) {
	return trim(htmlspecialchars(strip_tags($_POST[$name])));
}