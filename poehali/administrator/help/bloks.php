<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Блоки';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Блоки</h1>'.
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
			'<div class="help_titles_wrap">'.	
			'<div class="help_titles_group"><h2 class="help_h2">Что такое блоки</h2>'.
			'<div>Блок представляет собой базовую информационную часть сайта. Традиционное понятие шаблона — на Топ.сайт — отсутствует. Вы больше не привязаны ни к каким шаблонам. Вы выбираете готовые блоки и расставляете их в нужном порядке. Это новое решение, разработанное нашей компанией.</div>'.	
			'</div>'.	
			'<div class="help_titles_group"><h2 class="help_h2">Назначение</h2>'.
			'<div>Блоки решают задачи отображения необходимой информации на сайте - разделяя контент по смыслу за счет правильной типографики, цветовой гаммы, визуально-графических вставок, интерактивных элементов.</div>'.	
			'</div>'.	
			'<div class="help_titles_group"><h2 class="help_h2">Виды блоков</h2>'.
				'<div>'.	
					'<ol style="column-count: 2;">'.
					'<li><a href="/admin/help/blocks/text">Текст</a></li>'.
					'<li><a href="/admin/help/blocks/image">Изображение</a></li>'.
					'<li><a href="/admin/help/blocks/photogallery">Фотогалерея</a></li>'.
					'<li><a href="/admin/help/blocks/slider">Слайдер</a></li>'.
					'<li><a href="/admin/help/blocks/video">Видео YouTube</a></li>'.
					'<li><a href="/admin/help/blocks/form">Форма</a></li>'.
					'<li><a href="/admin/help/blocks/packages">Пакеты предложений</a></li>'.
					'<li><a href="/admin/help/blocks/case">Кейсы 1</a></li>'.
					'<li><a href="/admin/help/blocks/case_2">Кейсы 2</a></li>'.
					'<li><a href="/admin/help/blocks/site_portfolio">Портфолио для сайтов</a></li>'.
					'<li><a href="/admin/help/blocks/scrolling_vertical">Вертикальный скроллер</a></li>'.
					'<li><a href="/admin/help/blocks/icon">Иконки</a></li>'.
					'<li><a href="/admin/help/blocks/mapsyandex">Карта</a></li>'.
					'<li><a href="/admin/help/blocks/contacts">Контакты</a></li>'.
					'<li><a href="/admin/help/blocks/menu">Меню</a></li>'.
					'<li><a href="/admin/help/blocks/callback">Обратный звонок</a></li>'.
					'<li><a href="/admin/help/blocks/buttonup">Наверх</a></li>'.
					'<li><a href="/admin/help/blocks/virtual_tour">Панорама 360</a></li>'.
					'<li><a href="/admin/help/blocks/image_360">Изображение 360</a></li>'.
					'<li><a href="/admin/help/blocks/catalog">Каталог</a></li>'.
					'<li><a href="/admin/help/blocks/code">Html, js код</a></li>'.
					'<li><a href="/admin/help/blocks/php_code">Php код</a></li>'.
					'</ol>'.
				'</div>'.	
			'</div>'.
			'<div class="help_titles_group"><h2 class="help_h2">Функции</h2>'.
			'<div>Вставка текста, таблиц (имеется встроенный визуальный редактор ckeditor). Загрузка изображений (создание фотогалереи, слайдера). Вставка видео YouTube по ссылке. Создание форм обратной связи, иконок преимуществ, пакетов предложений, кейсов, изображений и панорам 360°. Быстрая вставка контактных данных. Имеется возможность вставки своего html, js, php кода.</div>'.
			'</div>'.
			'<div class="help_titles_group"><h2 class="help_h2">Варианты отображения</h2>'.
			'<div>Каждый блок имеет несколько предустановленных вариантов отображения, каждый из которых быстро и легко редактируется и настраивается под Ваши требования. Предустановленные блоки служат для сокращения времени разработки сайта.<br><br><details><summary>Еще</summary>Готовые блоки разработаны нами на профессиональном уровне и с помощью технологии flex уже учитывают поведение элементов на различных устройствах — от широкоэкранных мониторов и телевизоров до смартфонов. Вам не надо заботиться о том, как сайт будет выглядеть на планшете или телефоне — система всё сделает сама. Адаптивное поведение элементов — прописано в каждом блоке.<br><br>Имея большой опыт создания коммерческих сайтов мы позаботились о том, что бы блоки были максимально заточены под продажи товаров и услуг — четкое и понятное доведение информации, отсутствие информационного мусора, выделение доминанты внимания и ненавязчивая работа вспомогательных элементов.<br><br>В частности, что бы избавиться от информационной перегрузки — многие элементы содержат эффекты микровзаимодействия. Например в блоках «фотогалерея» и «пакеты предложений» дополнительная информация появляется при наведении курсора на элемент.</details></div>'.
			'</div>'.
			'<div class="help_titles_group"><h2 class="help_h2">Настройки</h2>'.	
			'<div> Все блоки быстро и легко редактируются, перемещаются между собой, отлично смотрятся на всех современных медиа-устройствах. В настройках можно изменить цвет, шрифт, максимальную ширину, отступы, загрузить фоновое изображение или выбрать цвет подложки.</div></div>'.	
				'</div>'.
				'</div>'.
			'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.				
				'<div class="dan_youtube help_video"><iframe width="560" height="315" src="https://www.youtube.com/embed/dT_KE40MbVI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
				'<img alt="" src="/administrator/help/template/images/1.webp" style="width:370px">'.
			'</div>'.	
	'</div>';

?>