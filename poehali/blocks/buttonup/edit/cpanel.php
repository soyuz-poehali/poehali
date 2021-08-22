<?php
defined('AUTH') or die('Restricted access');

$content = 
'<div class="e_cpanel_additional_items" data-type="buttonup" data-style="1">'.	
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/buttonup/edit/template/1/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Кнопка "Наверх"</div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));

?>