<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Каталог';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Каталог</h1>'.		
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
		'<div class="help_titles_wrap">'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Назначение Каталога</h2>'.
				'<div>Каталог предназначен для размещения в нем разделов и элементов. Каталог требуется для реализации на сайте интернет-магазина, раздела статей/новостей или любого другого типа каталога.</div>'.	
			'</div>'.
			'<div class="help_titles_group">'.
				'<h2 class="help_h2">Принцип работы каталога</h2>'.
				'<div>При открытии страницы с типом каталог все вложенные url адреса будут принадлежать данному каталогу.</div>'.	
			'</div>'.			
			'<div class="help_titles_group"><h2 class="help_h2">Создание каталога</h2>'.
				'<div>'.
				'<p>Создайте свой каталог во вкладке каталоги. Для этого перейдите на вкладку каталог и нажмите на "Добавить каталог"</p>'.
				'<p>Здесь вы:</p>'.				
				'<ol>'.				
				'<li>Даёте название своему каталогу</li>'.
				'<li>По необходимости задаёте URl адрес каталога</li>'.
				'<li>Вписываете заголовок своему каталогу</li>'.
				'<li>По необходимости прописываете description</li>'.
				'<li>Изменяете тип каталога, но по умолчанию он всегда будет, как "Интернет-магазин"</li>'.
				'<li>Включаете или отключаете ваш каталог</li>'.
				'<li>По необходимости поставьте номер порядка следования</li>'.
				'</ol>'.
				'</div>'.
				'</div>'.				
			'</div>'.
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<img class="img_bxsh" alt="" src="/administrator/help/template/images/6.webp" style="width:100%;margin-bottom: 20px;">'.
			'<img class="img_bxsh"alt="" src="/administrator/help/template/images/5.webp" style="width:100%;">'.
		'</div>'.
	'</div>';
