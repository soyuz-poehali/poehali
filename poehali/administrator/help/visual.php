<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/help/template/style.css');

include $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';

$breadcrumbs_arr['/admin/help'] = 'Помощь';
$breadcrumbs_arr[''] = 'Режим визуального редактирования';
$breadcrumbs = breadcrumbs($breadcrumbs_arr);


$SITE->content = 
	$breadcrumbs.
	'<h1 class="help_h1">Режим визуального редактирования</h1>'.
	'<div class="dan_flex_row help_overflow_unset">'.
		'<div class="help_flex_50">'.
			'<div class="help_titles_wrap">'.
				'<div class="help_titles_group">'.
					'<h2 class="help_h2">Назначение режима визуального редактирования</h2>'.
					'<div>Данный режим предназначен для добавления и редактирования содержимого страниц.</div>'.	
				'</div>'.
				'<div class="help_titles_group">'.
					'<h2 class="help_h2">Функционал и возможности</h2>'.
					'<div>'.
						'<div>Все страницы сайта строятся на блоках, поэтому возможности редактирования сайта зависят от конкретного блока.</div>'.	
						'<ol>'.
							'<li>Добавить блок</li>'.
							'<li>Копировать блок</li>'.
							'<li>Переместить блок выше/ниже</li>'.
							'<li>Удалить блок</li>'.
						'</ol>'.
					'</div>'.
				'</div>'.
				'<div class="help_titles_group">'.
					'<h2 class="help_h2">Как редактировать сайт</h2>'.
					'<div>'.
						'<div>Чтобы перейти к редактированию сайта Вам нужно нажать кнопку "Ред." в верхней части экрана, для открытия режима визуального редактирования.</div>'.	
						'<div>В левой части экрана нажмите на шестеренку и выберете необходимый блок.</div>'.	
					'</div>'.
				'</div>'.
			'</div>'.
		'</div>'.
		'<div class="help_flex_50 help_p20_40 dan_flex_row help_flex_right">'.		
			'<div class="dan_youtube help_video"><iframe width="100%" height="580" src="https://www.youtube.com/embed/CWg5mXU04AU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'<img alt="" src="/blocks/virtual_tour/edit/help/images/1.webp" style="width:100%">'.
		'</div>'.
	'</div>';
