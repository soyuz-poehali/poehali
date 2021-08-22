<?php
defined('AUTH') or die('Restricted access');

$content = 
'<div class="e_cpanel_additional_items" data-type="form" data-style="1">'.	
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/form/edit/template/1/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Стандартная форма</div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));

?>