<?php
defined('AUTH') or die('Restricted access');

$_SESSION['form_time'] = time();  // Для форм, проверяем время отправки

function block_form($data)
{
	global $SITE;

	// --- СТИЛЬ ---
	switch ($data['content']['style']) {
		case '1': 
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/form/frontend/1/template.php';
			$out = block_form_1($data);
			break;
		case '2': 
			include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/form/frontend/2/template.php';
			$out = block_form_2($data);
			break;
	}

	return $out;
}

?>