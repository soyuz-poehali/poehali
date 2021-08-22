<?php
defined('AUTH') or die('Restricted access');
$SITE->setHeadFile('/blocks/video/frontend/2/BLOCK.video_2.css');

function block_video_2($data)
{
	$content = $data['content'];
	$video_out = '';

	$i = 1;
	foreach ($content['videos'] as $video) {
		if ($video['ratio'] == 2) 
			$youtube_ratio_padding = 'style="padding-bottom:75%;"';
		else  
			$youtube_ratio_padding = '';

		if (!isset($video['text'])) 
			$video['text'] = '';
		
		$button_out = $button_1 = $button_2 = '';

		if (isset($video['button_1']) && $video['button_1']['on'] == 1) {
			$text_color = 'color:'.$video['button_1']['text_color'].';';
			
			if($video['button_1']['style'] == 'solid')
				$bg = 'background:'.$video['button_1']['bg_color'].';';
			
			if($video['button_1']['style'] == 'border')
				$bg = 'border:solid 2px '.$video['button_1']['bg_color'].';';
			
			$radius = $video['button_1']['radius'] > 0 ? 'border-radius:'.$video['button_1']['radius'].'px;' : '';
				
			$button_1 = '<a class="block_youtube_button_1" style="'.$text_color.$bg.$radius.'" href="'.$video['button_1']['link'].'">'.$video['button_1']['text'].'</a>';
		}
		
		if (isset($video['button_2']) && $video['button_2']['on'] == 1) {
			$text_color = 'color:'.$video['button_2']['text_color'].';';
			
			if($video['button_2']['style'] == 'solid')
				$bg = 'background:'.$video['button_2']['bg_color'].';';
			
			if($video['button_2']['style'] == 'border')
				$bg = 'border:solid 2px '.$video['button_2']['bg_color'].';';
			
			$radius = $video['button_2']['radius'] > 0 ? 'border-radius:'.$video['button_2']['radius'].'px;' : '';
				
			$button_2 = '<a class="block_youtube_button_2" style="'.$text_color.$bg.$radius.'" href="'.$video['button_2']['link'].'">'.$video['button_2']['text'].'</a>';
		}

		if ($button_1 != '' || $button_2 != '') 
			$button_out = '<div class="block_video_button_container">'.$button_1.$button_2.'</div>';

		$text_container_style = $content['padding'] != 0 ? 'style="padding:'.$content['padding'].'px;"' : '';


		$video_out .= 
		'<div class="flex_grow_1 e_block_item block_video_2_container">'.
			'<div class="block_video_text_container" '.$text_container_style.'>'.
				'<div class="block_video_text">'.
					$video['text'].
				'</div>'.
				$button_out.
			'</div>'.
			'<div class="block_youtube_wrap">'.
				'<div class="dan_youtube" '.$youtube_ratio_padding.'><iframe style="width:560px; height:315px;" src="'.$video['url'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'.
			'</div>'.
		'</div>';
		$i++;
	}

	return $video_out;
}
?>