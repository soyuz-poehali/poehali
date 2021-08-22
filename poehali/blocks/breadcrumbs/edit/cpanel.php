<?php
defined('AUTH') or die('Restricted access');

$content = 
'<div class="e_cpanel_additional_items" data-type="breadcrumbs" data-style="1">'.	
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/breadcrumbs/edit/template/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Путь по сайту</div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));

?>