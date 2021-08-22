<?php
defined('AUTH') or die('Restricted access');

$content = 
'<div class="e_cpanel_additional_items" data-type="photogallery" data-style="1">'.	
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/photogallery/edit/template/1/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Фотогалерея с текстом внизу</div>'.
'</div>'.
'<div class="e_cpanel_additional_items" data-type="photogallery" data-style="2">'.
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/photogallery/edit/template/2/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Фотогалерея с затемнением</div>'.
'</div>'.
'<div class="e_cpanel_additional_items" data-type="photogallery" data-style="3">'.	
	'<div class="e_cpanel_additional_wrap"><img src="/blocks/photogallery/edit/template/3/preview.png"></div>'.
	'<div class="e_cpanel_additional_title">Фотогалерея с засветлением</div>'.
'</div>';

echo json_encode(array('answer' => 'success', 'content' => $content));

?>