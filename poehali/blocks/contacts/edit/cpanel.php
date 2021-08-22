<?php
defined('AUTH') or die('Restricted access');

$content = 
'<div class="e_cpanel_additional_items" data-type="contacts" data-style="1">'.	
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/contacts/edit/template/1/preview.jpg"></div>'.
	'<div class="e_cpanel_additional_title">Стандартный вариант</div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));

?>