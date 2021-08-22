<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/administrator/plugins/ckeditor_textarea/ckeditor.js');

include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/breadcrumbs.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/personal_information/classes/PersonalInformation.php';

$breadcrumbs_arr = array(
	'' => 'Политика конфиденциальности'
);

$PI = new PersonalInformation();
$text = $PI->getText();


$SITE->content = 
	breadcrumbs($breadcrumbs_arr).
	'<h1>Политика конфиденциальности</h1>'.
	'<form method="post" action="/admin/personal_information/update" enctype="multipart/form-data">'.
		'<div class="dan_flex_grow">'.
			'<textarea name="editor1">'.$text.'</textarea>'.
		'</div>'.
		'<script>'.
			'let e_editor_1 = CKEDITOR.replace("editor1", {'.
				'height: "400px",'.
				'filebrowserBrowseUrl : "/administrator/plugins/browser/dan_browser.php",'.
			'});'.
		'</script>'.
		'<div class="dan_flex_row p_20">'.
			'<div class="tc_l"><input id="button_submit" class="button_submit" type="submit" name="submit" value="Сохранить"></div>'.
			'<div class="tc_r dan_flex_grow"><a href="/admin" class="button_cancel">Отменить</a></div>'.
		'</div>'.
	'</form>';

