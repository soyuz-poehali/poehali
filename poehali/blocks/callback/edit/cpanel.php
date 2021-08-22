<?php
defined('AUTH') or die('Restricted access');

$content = 
'<div class="e_cpanel_additional_items" data-type="callback" data-style="1">'.	
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/callback/edit/template/1/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Кнопка "Наверх"</div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));

?>