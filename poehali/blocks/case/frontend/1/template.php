<?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/blocks/case/frontend/1/BLOCK.case_1.css');
$SITE->setHeadFile('/blocks/case/frontend/1/BLOCK.case_1.js');

function block_case_1_1($data)
{
	global $SITE;
	$content = $data['content'];

	// Изображения
	$images_out = '';
	$num = 1;
	if (count($content['images']) > 0) {
		foreach ($content['images'] as $image) {
			$src = '/files/pages/'.$SITE->page['id'].'/case/'.$image;
			$images_out .= 
			'<div class="block_case_1_images_wrap_w e_block_item">'.
				'<img class="block_case_1_images_wrap_img" src="'.$src.'" alt="">'.
			'</div>';

			$num++;
		}		
	}

	// Кнопка
	if ($content['button']['on'] == 1) {
		$button_style = $content['button']['style'] == 'border' 
			? 'border:solid 2px '.$content['button']['bg_color'].';color:'.$content['button']['bg_color'].';'
			: 'color:'.$content['button']['text_color'].';background-color:'.$content['button']['bg_color'].';';

		$border_radius = $content['button']['radius'] > 0 ? 'border-radius:'.$content['button']['radius'].'px;' : '';
		$button_out = '<div class="block_case_1_button_wrap"><div onclick="BLOCK.case_1.form('.$data['id'].',\''.$content['button']['text'].'\');" class="block_case_1_button" style="'.$button_style.$border_radius.'">'.$content['button']['text'].'</div></div>';
	} else
		$button_out = '';


	$padding = $content['padding'] == 0 ? '' : 'style="padding:'.$content['padding'].'px"';

	$out = 
	'<div id="block_case_1_images_wrap_'.$data['id'].'" class="block_case_1_images_wrap">'.
		$images_out.
	'</div>'.
	'<div class="block_case_1_text_wrap" '.$padding.'>'.
		'<div>'.$content['text'].'</div>'.
		$button_out.
	'</div>'.
	'<script>DAN.show("block_case_1_images_wrap_img", "block_case_container_'.$data['id'].'")</script>';

	return $out;
}

?>