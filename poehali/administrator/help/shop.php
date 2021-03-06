<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Интернет-магазин';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Интернет-магазин</h1>'.		
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
			'<div class="help_titles_wrap">'.
				'<div class="help_titles_group">'.
					'<h2 class="help_h2">Назначение Интернет-магазина</h2>'.
					'<div>Каталог предназначен для размещения в нем разделов и элементов. Каталог требуется для реализации на сайте интернет-магазина, раздела статей/новостей или любого другого типа каталога.</div>'.	
				'</div>'.
				'<div class="help_titles_group">'.				
					'<h2 class="help_h2">Создание раздела для товаров</h2>'.
					'<div>'.
					'<div>После того, как вы создали и указали нужные настройки своему каталогу, заходим в него и перед вами появляется множество возможностей, которые можно использовать для размещения вашего товара.<br><br></div>'.
					'<div>Чтобы добавить ваш товар вам нужно создать раздел для него. Для этого зайдите в Ваш каталог и нажмите на вкладку "Создать раздел". Перед вами открывается некоторые пункты, которые нужно обязательно заполнить:</div>'.						
					'<ol>'.				
					'<li>Дайте название своему разделу например:шины</li>'.
					'<li>Задайте родительский раздел т.е от какой страницы он будет  главным</li>'.
					'<li>Добавьте изображение (при необходимости)</li>'.
					'<li>Включите или отключите раздел (при необходимости)</li>'.
					'<li>При необходимости поставьте порядок следования</li>'.
					'<li>Включаете или отключаете ваш каталог</li>'.
					'<li>По необходимости поставьте номер порядка следования</li>'.
					'</ol>'.
					'</div>'.
				'</div>'.			
				'<div class="help_titles_group"><h2 class="help_h2">Добавление товаров в раздел</h2>'.
					'<div>'.
					'<p>После добавления нужных вам разделов заходите в него. Здесь вы можете добавлять ваш товар в неограниченном количестве.</p>'.
					'<p>В данном разделе вы можете заполнить следующие функции создаваемого товара: </p>'.				
					'<ol>'.				
					'<li>Дайте название вашему товару</li>'.
					'<li>Выбрать раздел в котором будет располагаться Ваш товар, для одного товара может быть несколько разделов.</li>'.
					'<li>Добавление цен: розничная, диллерскую, оптовою и т.д</li>'.
					'<li>Добавьте изображение</li>'.
					'<li>Добавить текст или характеристику товару</li>'.
					'<li>Включить или выключить товар</li>'.
					'<li>По необходимости поставьте номер порядка следования</li>'.
					'</ol>'.				
					'</div>'.				
				'</div>'.
			'</div>'.	
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<img class="img_bxsh" alt="" src="/administrator/help/template/images/7.webp" style="width:100%;margin-bottom: 20px;">'.
			'<img class="img_bxsh"alt="" src="/administrator/help/template/images/8.webp" style="width:400px;">'.
		'</div>'.
	'</div>';
