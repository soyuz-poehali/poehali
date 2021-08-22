 <?php
defined('AUTH') or die('Restricted access');

$SITE->setHeadFile('/blocks/mapsyandex/frontend/BLOCK.mapsyandex.js');
$SITE->setHeadFile('/blocks/contacts/frontend/BLOCK.contacts.css');

$_SESSION['contacts_time'] = time();  // Для форм, проверяем время отправки

function block_contacts($data)
{
	global $SITE;
	$content = $data['content'];

	// --- ТИПЫ 1 ---
	if ($content['style'] == 1) {
		switch($content['bg_type']) {
			case '1': $container_css = 'background-color: var(--color-1);'; break;
			case '2': $container_css = 'background-color: var(--color-2);'; break;
			case '3': $container_css = 'background-color: var(--color-3);'; break;
			case 'c': $container_css = 'background-color: '.$content['bg_color'].';'; break;
			case 'i':
				$container_css =
					'background-image: url(\'/files/pages/'.$SITE->page_id.'/contacts/background/'.$content['bg_image'].'\');'.
					'background-position: 50% 50%;';
					if ($content['bg_image_size'] == 'cover')
						$container_css .= 'background-size: cover;';
				break;
			default: $container_css = '';
		}

		if ($content['font_size']) {
			if($content['font_size'] == 'var(--font-size)')	
				$container_css .= 'font-size:'.$content['font_size'].';';
			else 
				$container_css .= 'font-size:'.$content['font_size'].'px;';
		}

		$container_css .= $content['color'] ? 'color:'.$content['color'].';' : '';
		$container_css .= !$content['line_height'] || $content['line_height'] == 1.2 ? '' : 'line-height:'.$content['line_height'].';';

		$wrap_css = $content['max_width'] && $content['max_width'] != 100 ? 'max-width:'.$content['max_width'].'px;' : '';
		$wrap_css .= $content['margin'] != 0 ? 'margin:'.$content['margin'].'px auto;' : '';
		$wrap_css .= $content['padding'] != 0 ? 'padding:'.$content['padding'].'px;' : '';

		if ($content['wrap_bg_opacity'] == 1) {
			$wrap_css .= $content['wrap_bg_color'] ? 'background-color:'.$content['wrap_bg_color'].';' : '';
		} else {
			// RGB
			list($R, $G, $B) = sscanf($content['wrap_bg_color'], "#%02x%02x%02x");
			$wrap_css .= 'background-color: rgba('.$R.', '.$G.', '.$B.', '.$content['wrap_bg_opacity'].');';
		}

		$style_container = $container_css != '' ? 'style="'.$container_css.'"' : '';
		$wrap_style = $wrap_css != '' ? 'style="'.$wrap_css.'"' : '';

		$fields_left_out = $fields_right_out = $fields_left = $fields_right = '';

		$num = 1;
		foreach ($content['fields'] as $field) {
			switch ($field['type']) {
				case 'address':
					$fields_left .=
						'<div class="block_contacts_left_fields e_block_item">'.
							'<div class="block_contacts_ico"><svg class="block_contacts_svg" style="fill:'.$content['color'].'"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#home"></use></svg></div>'.
							'<div>'.$field['content'].'</div>'.
						'</div>';
					break;
				
				case 'phone':
					$phone_number = preg_replace('/[^0-9]/', '', $field['content']);
					if($phone_number[0] == 7) 
						$phone_number = '+'.$phone_number;
					$fields_left .=
						'<div class="block_contacts_left_fields e_block_item">'.
							'<a class="block_contacts_ico" href="tel:'.$phone_number.'"><svg class="block_contacts_svg" style="fill:'.$content['color'].'"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#phone"></use></svg></a>'.
							'<div><a href="tel:'.$phone_number.'" style="color:'.$content['color'].'">'.$field['content'].'</a></div>'.
						'</div>';
					break;

				case 'viber':
					$phone_number = preg_replace('/[^0-9]/', '', $field['content']);
					$fields_left .=
						'<div class="block_contacts_left_fields e_block_item">'.
							'<a href="viber://add?number='.$phone_number.'" class="block_contacts_ico"><svg class="block_contacts_svg" style="fill:'.$content['color'].'"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#viber"></use></svg></a>'.
							'<div><a href="viber://add?number='.$phone_number.'" style="color:'.$content['color'].'">'.$field['content'].'</a></div>'.
						'</div>';	
					break;
				
				case 'whatsapp':
					$phone_number = preg_replace('/[^0-9]/', '', $field['content']);
					if($phone_number[0] == 7) 
						$phone_number = '+'.$phone_number;
					$fields_left .=
						'<div class="block_contacts_left_fields e_block_item">'.
							'<a href="whatsapp://send?phone='.$phone_number.'" class="block_contacts_ico"><svg class="block_contacts_svg" style="fill:'.$content['color'].'"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#whatsapp"></use></svg></a>'.
							'<div><a href="whatsapp://send?phone='.$phone_number.'" style="color:'.$content['color'].'">'.$field['content'].'</a></div>'.
						'</div>';
					break;

				case 'skype':
					$fields_left .=
						'<div class="block_contacts_left_fields e_block_item">'.
							'<a href="skype:'.$field['content'].'?call" class="block_contacts_ico"><svg class="block_contacts_svg" style="fill:'.$content['color'].'"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#skype"></use></svg></a>'.
							'<div><a href="skype:'.$field['content'].'?call" style="color:'.$content['color'].'">'.$field['content'].'</a></div>'.
						'</div>';	
					break;

				case 'email':
					$fields_left .=
						'<div class="block_contacts_left_fields e_block_item">'.
							'<a href="mailto:'.$field['content'].'" class="block_contacts_ico"><svg class="block_contacts_svg" style="fill:'.$content['color'].'"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#email"></use></svg></a>'.
							'<div><a href="mailto:'.$field['content'].'" style="color:'.$content['color'].'">'.$field['content'].'</a></div>'.
						'</div>';
					break;

				case 'youtube':
					$fields_left .=
						'<div class="block_contacts_left_fields e_block_item">'.
							'<a target="_blank" href="'.$field['content'].'" class="block_contacts_ico"><svg class="block_contacts_svg" style="fill:'.$content['color'].'"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#youtube"></use></svg></a>'.
							'<div><a href="'.$field['content'].'" target="_blank" style="color:'.$content['color'].'">'.$field['content'].'</a></div>'.
						'</div>';	
					break;
				
				case 'instagram':
					$fields_left .=
						'<div class="block_contacts_left_fields e_block_item">'.
							'<a target="_blank" href="'.$field['content'].'" class="block_contacts_ico"><svg class="block_contacts_svg" style="fill:'.$content['color'].'"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#instagram"></use></svg></a>'.
							'<div><a href="'.$field['content'].'" target="_blank" style="color:'.$content['color'].'">'.$field['content'].'</a></div>'.
						'</div>';
					break;

				case 'vk':
					$fields_left .=
						'<div class="block_contacts_left_fields e_block_item">'.
							'<a target="_blank" href="'.$field['content'].'" class="block_contacts_ico"><svg class="block_contacts_svg" style="fill:'.$content['color'].'"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#vk"></use></svg></a>'.
							'<div><a href="'.$field['content'].'" target="_blank" style="color:'.$content['color'].'">'.$field['content'].'</a></div>'.
						'</div>';	
					break;

				case 'fb':
					$fields_left .=
						'<div class="block_contacts_left_fields e_block_item">'.
							'<a target="_blank" href="'.$field['content'].'" class="block_contacts_ico"><svg class="block_contacts_svg" style="fill:'.$content['color'].'"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#fb"></use></svg></a>'.
							'<div><a href="'.$field['content'].'" target="_blank" style="color:'.$content['color'].'">'.$field['content'].'</a></div>'.
						'</div>';	
					break;


				case 'telegram':
					$fields_left .=
						'<div class="block_contacts_left_fields e_block_item">'.
							'<a target="_blank" href="'.$field['content'].'" class="block_contacts_ico"><svg class="block_contacts_svg" style="fill:'.$content['color'].'"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#telegram"></use></svg></a>'.
							'<div><a href="'.$field['content'].'" target="_blank" style="color:'.$content['color'].'">'.$field['content'].'</a></div>'.
						'</div>';	
					break;

				case 'working_hours':
					$fields_left .=
						'<div class="block_contacts_left_fields e_block_item">'.
							'<div class="block_contacts_ico"><svg class="block_contacts_svg" style="fill:'.$content['color'].'"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/lib/svg/sprite.svg#time"></use></svg></div>'.
							'<div>'.$field['content'].'</div>'.
						'</div>';	
					break;

				case 'html':
					$fields_left .=
						'<div class="block_contacts_left_fields e_block_item" data-block="contacts">'.
							'<div>'.$field['content'].'</div>'.
						'</div>';
					break;

				case 'code':
					$fields_right .=
						'<div class="block_contacts_right_fields e_block_item e_block_contacts_code">'.
							$field['content'].
						'</div>';	
					break;

				case 'mapyandex':
					$SITE->setHeadCode('<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>');

					// Точки на карте
					if (isset($field['points']) && is_array($field['points'])) 
						$points_arr = 'var points_arr = '.json_encode($field['points']).';';
					else 
						$points_arr = 'var points_arr = false;';

					$fields_right .=
						'<div class="block_contacts_right_fields block_contacts_mapyandex e_block_item">'.
							'<div id="block_contacts_mapyandex_'.$data['id'].'" class="block_contacts_mapyandex"></div>'.
						'</div>'.
						'<script>'.
							$points_arr.
							'var coordinate = ['.$field['coordinate'][0].', '.$field['coordinate'][1].'];'.
							'BLOCK.mapsyandex.run("block_contacts_mapyandex_'.$data['id'].'", coordinate, '.$field['zoom'].', points_arr);'.
						'</script>';	
					break;

				case 'form':
					$fields_right .=
						'<div class="block_contacts_right_fields e_block_item">'.
						'<form method="post" action="/block/contacts/send">'.
							'<h3>'.$field['content'].'</h3>'.
							'<div><input class="dan_input" type="text" name="name" placeholder="Ваше имя" required><input class="dan_input" type="text" name="phone" placeholder="Ваш телефон" required></div>'.
							'<div><textarea class="dan_input" name="message" required placeholder="Ваше ообщение"></textarea></div>'.
							'<div class="block_contacts_personal_information">'.
								'<input required="" checked="" title="Вы должны дать согласие перед отправкой" type="checkbox">'.
								'Я согласен на <a href="/personal_information" target="_blank">обработку персональных данных</a>'.
							'</div>'.
							'<div><input class="input block_contacts_submit" style="background-color:var(--color-3);" type="submit" name="submit" value="Отправить"></div>'.
						'</form>'.
						'</div>';	
					break;				
			}

			$num++;
		}

		if ($fields_left != '') {
			$fields_left_out =
				'<div id="block_contacts_left_container_'.$data['id'].'" class="block_contacts_left_container">'.
					$fields_left.
				'</div>';
		}

		if ($fields_right != '') {
			$fields_right_out = '<div id="block_contacts_right_container_'.$data['id'].'" class="block_contacts_right_container">'.$fields_right.'</div>';
		}

		$out =
		'<div id="block_'.$data['id'].'" class="block block_contacts" '.$style_container.'>'.
			'<div class="block_contacts_container" '.$wrap_style.'>'.
				$fields_left_out.
				$fields_right_out.
			'</div>'.
		'</div>';
	}

	return $out;
}

?>