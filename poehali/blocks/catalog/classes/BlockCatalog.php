<?php
defined('AUTH') or die('Restricted access');

class BlockCatalog
{
	public $catalog = false;
	public $section = false;
	public $sections_tree = false;
	public $order = false;
	public $order_items = false;
	public $price_type_id = false;  // false - массив не установлен


	// ======= КАТАЛОГ =======
	public function getCatalog($id)
	{
		global $db;
		
		if ($this->catalog)
			return $this->catalog;
		
		$stmt = $db->prepare("SELECT id, component, name, url, type, settings, status, ordering FROM components WHERE id = :id");
		$stmt->execute(array('id' => $id));
		if ($stmt->rowCount() > 0) {
			$catalog = $stmt->fetch();
			$catalog['settings'] = unserialize($catalog['settings']);
			$this->catalog = $catalog;
			return $this->catalog;		
		} else
			return false;
	}

	public function getCatalogByUrl($url)
	{
		global $db;
		
		if ($this->catalog)
			return $this->catalog;
		
		$stmt = $db->prepare("SELECT id, component, name, url, type, settings, status, ordering FROM components WHERE url = :url");
		$stmt->execute(array('url' => $url));
		if ($stmt->rowCount() > 0) {
			$catalog = $stmt->fetch();
			$catalog['settings'] = unserialize($catalog['settings']);
			$this->catalog = $catalog;
			return $this->catalog;		
		} else
			return false;
	}



	// ======= РАЗДЕЛЫ =======
	public function getSection($data)
	{
		global $db;
		
		if ($this->section)
			return $this->section;
		
		$sql = isset($data['full_request']) ? ', parent_id, name, url, settings, status, ordering' : '';

		$stmt = $db->prepare("
			SELECT id ".$sql." 
			FROM com_catalogs_".$data['catalog_id']."_sections 
			WHERE url = :url AND status = 1
		");
		
		$stmt->execute(array('url' => $data['url']));

		if ($stmt->rowCount() > 0) {
			$section = $stmt->fetch();
			if (isset($section['settings'])) {
				$section['settings'] = unserialize($section['settings']);
				$this->section = $section;
				return $this->section;	
			}
			return $section;
		}
		return false;
	}	

	
	public function getSections($catalog_id)
	{
		global $db;
		
		if ($this->sections_tree)
			return $this->sections_tree;

		$stmt = $db->query("
			SELECT id, parent_id, name, url, settings, status, ordering 
			FROM com_catalogs_".$catalog_id."_sections 
			WHERE status = 1
			ORDER BY ordering
		");

		if ($stmt->rowCount() > 0) {
			$sections = $stmt->fetchAll();
			$this->getSectionsTree($sections, 0, 0);
			return $this->sections_tree;
		}
			
		return false;
	}

	
	public function getSectionsTree($sections_arr, $parent_id=0, $level=0)
	{
		global $db;

		foreach ($sections_arr as $section) {
			if ($section['parent_id'] == $parent_id) {
				$this->sections_tree[] = array(
					'id' => $section['id'],
					'parent_id' => $section['parent_id'],
					'name' => $section['name'],
					'url' => $section['url'],
					'settings' => unserialize($section['settings']),
					'status' => $section['status'],
					'ordering' => $section['ordering'],
					'level' => $level
				);
				
				// Запускаем рекурсию
				$level++;
				$this->getSectionsTree($sections_arr, $section['id'], $level);
				$level--;
			}
		}
	}

	
	// ======= ЭЛЕМЕНТЫ =======
	public function getItem($data)
	{
		global $db;

		if (!$this->price_type_id) {  // Если нет указания типа цены  - берём первую цену
			$query = $db->query("SELECT id FROM com_catalogs_".$data['catalog_id']."_prices_type ORDER BY ordering LIMIT 1");
			$price_type_id = $query->fetchColumn();
		} else {
			$price_type_id = $this->price_type_id;
		}

		$data['catalog_id'] = intval($data['catalog_id']);
		$stmt = $db->prepare("
			SELECT i.id, i.name, i.images, i.text, i.settings, p.price
			FROM com_catalogs_".$data['catalog_id']."_items i
			JOIN com_catalogs_".$data['catalog_id']."_items_sections s
			ON i.id = s.item_id
			LEFT JOIN com_catalogs_".$data['catalog_id']."_prices_value p
			ON p.item_id = i.id	AND p.price_type_id IN (".$price_type_id.")
			WHERE s.section_id = :section_id AND i.url = :url AND i.status = 1
			ORDER BY i.ordering
		");
		
		$stmt->execute(array('section_id' => $data['section_id'], 'url' => $data['url']));

		if ($stmt->rowCount() > 0) {
			$item = $stmt->fetch();
			$item['settings'] = unserialize($item['settings']);
			return $item;
		}
		return false;
	}	

	
	public function getItems($data)
	{
		global $db;
		
		// Получаем идентификатор первой цены
		if (!$this->price_type_id) {  // Если нет указания типа цены  - берём первую цену
			$query = $db->query("SELECT id FROM com_catalogs_".$data['catalog_id']."_prices_type ORDER BY ordering LIMIT 1");
			$price_type_id = $query->fetchColumn();
		} else {
			$price_type_id = $this->price_type_id;
		}

		$data['catalog_id'] = intval($data['catalog_id']);
		$stmt = $db->prepare("
			SELECT i.id, i.name, i.url, i.images, i.text, i.settings, p.price
			FROM com_catalogs_".$data['catalog_id']."_items i
			JOIN com_catalogs_".$data['catalog_id']."_items_sections s
			ON i.id = s.item_id
			LEFT JOIN com_catalogs_".$data['catalog_id']."_prices_value p
			ON p.item_id = i.id	AND p.price_type_id IN (".$price_type_id.")
			WHERE s.section_id = :section_id AND i.status = 1
			ORDER BY i.ordering
		");
		
		$stmt->execute(array('section_id' => $data['section_id']));

		if ($stmt->rowCount() > 0)
			return $stmt->fetchAll();

		return false;
	}


	public function getItemChars($data)
	{
		global $db;
		
		$data['catalog_id'] = intval($data['catalog_id']);
		
		$sql_limit = isset($data['limit']) ? ' LIMIT '.intval($data['limit']) : '';

		$stmt = $db->prepare("
			SELECT v.name_id, v.value, v.options, n.name, n.unit
			FROM com_catalogs_".$data['catalog_id']."_chars_value v 
			JOIN com_catalogs_".$data['catalog_id']."_chars_name n
			ON n.id = v.name_id
			WHERE item_id = :item_id
			ORDER BY v.ordering ".$sql_limit."
		");

		$stmt->execute(array('item_id' => $data['item_id']));
		
		if ($stmt->rowCount() > 0)
			return $stmt->fetchAll();

		return false;		
	}


	public function getRelatedItems($data){
		global $db;

		$data['catalog_id'] = intval($data['catalog_id']);

		$stmt = $db->prepare("
			SELECT i.id, i.name, i.url, i.images, s.url section_url
			FROM com_catalogs_".$data['catalog_id']."_items i
			JOIN com_catalogs_".$data['catalog_id']."_related r
			ON i.id = r.related_id
			JOIN com_catalogs_".$data['catalog_id']."_items_sections i_s
			ON i_s.item_id = i.id
			JOIN com_catalogs_".$data['catalog_id']."_sections s
			ON s.id = i_s.section_id
			WHERE r.item_id = :item_id AND i.status = 1
			GROUP BY i.id
			ORDER BY r.ordering
		");

		$stmt->execute(array('item_id' => $data['item_id']));
		
		if ($stmt->rowCount() > 0)
			return $stmt->fetchAll();

		return false;		
	}


	// ======= ХАРАКТЕРИСТИКИ =======
	public function charsGetName($data) {
		global $db;
		$data['catalog_id'] = intval($data['catalog_id']);

		$stmt = $db->prepare("SELECT name FROM com_catalogs_".$data['catalog_id']."_chars_name WHERE id = :id");
		$stmt->execute(array('id' => $data['id']));	
		return $stmt->fetchColumn();
	}


	// ======= СТИКЕРЫ =======
	public function stickersGet($catalog_id) {
		global $db;
		$catalog_id = intval($catalog_id);

		$stmt = $db->query("SELECT id, name, color, bg_color FROM com_catalogs_".$catalog_id."_stickers ORDER BY ordering");
		return $stmt->fetchAll();
	}


	// ======= ЗАКАЗЫ =======
	public function orderGetByHash($data) {
		global $db;
	
		if ($this->order)
			return $this->order;

		$data['catalog_id'] = intval($data['catalog_id']);

		// Ищем открытый заказ в БД
		$stmt_hash = $db->prepare("
			SELECT id, user_id, description, `data`, coupon, sum, fio, phone, email, address, comments, status
			FROM com_catalogs_".$data['catalog_id']."_orders
			WHERE hash = :hash AND status = :status LIMIT 1
		");
		$stmt_hash->execute(array('hash' => $data['hash'], 'status' => $data['status']));
		
		if ($stmt_hash->rowCount() == 0)
			return false;

		$d = $stmt_hash->fetch();
		$d['data'] = unserialize($d['data']);
		
		$this->order = $d;
		return $this->order;
	}


	public function orderNew($data) {
		global $db;
		$data['catalog_id'] = intval($data['catalog_id']);

		$stmt = $db->prepare("
			INSERT INTO com_catalogs_".$data['catalog_id']."_orders SET
			user_id = :user_id,
			hash = :hash,
			description = '',
			data = '',
			coupon = '',
			sum = 0,
			payment_system = '',
			status = 0,
			date_order = NOW(),
			date_payment = NOW()
		");

		$stmt->execute(array(
			'user_id' => $data['user_id'],
			'hash' => $data['hash'],
		));

		return $db->lastInsertId();
	}


	public function orderUpdateCoupon($data) {
		global $db;
		$data['catalog_id'] = intval($data['catalog_id']);

		$stmt = $db->prepare("
			UPDATE com_catalogs_".$data['catalog_id']."_orders SET
			coupon = :coupon,
			date_order = NOW()
			WHERE id = :id
		");

		$stmt->execute(array(
			'coupon' => $data['coupon'],
			'id' => $data['id']
		));
	}


	public function orderAddItem($data) {
		global $db;
		$data['catalog_id'] = intval($data['catalog_id']);

		// Проверяем, есть ли товар уже в БД
		$item = $this->orderGetItemByItemId($data);

		if (!$item) {
			$this->orderInsertItem($data);
		}
		else {
			$d['catalog_id'] = $data['catalog_id'];
			$d['id'] = $item['id'];
			$d['quantity'] = $item['quantity'] + 1;
			$this->orderUpdateItemQuantity($d);
		}
	}


	public function orderGetItemByItemId($data) {
		global $db;
		$data['catalog_id'] = intval($data['catalog_id']);

		$stmt = $db->prepare("
			SELECT id, quantity 
			FROM com_catalogs_".$data['catalog_id']."_orders_items 
			WHERE order_id = :order_id AND item_id = :item_id AND chars = :chars");
		$stmt->execute(array('order_id' => $data['order_id'], 'item_id' => $data['item_id'], 'chars' => $data['chars']));

		return $stmt->fetch();	
	}


	public function orderInsertItem($data) {
		global $db;
		$data['catalog_id'] = intval($data['catalog_id']);

		// Добавляем товар к заказу
		$stmt = $db->prepare("
			INSERT INTO com_catalogs_".$data['catalog_id']."_orders_items SET
			order_id = :order_id,
			item_id = :item_id,
			quantity = :quantity,
			chars = :chars
		");

		$stmt->execute(array(
			'order_id' => $data['order_id'],
			'item_id' => $data['item_id'],
			'quantity' => $data['quantity'],
			'chars' => $data['chars']
		));

		return $db->lastInsertId();
	}


	public function orderUpdateItemQuantity($data) {
		global $db;

		$data['catalog_id'] = intval($data['catalog_id']);

		// Добавляем товар к заказу
		$stmt = $db->prepare("UPDATE com_catalogs_".$data['catalog_id']."_orders_items SET quantity = :quantity WHERE id = :id");

		$stmt->execute(array(
			'quantity' => $data['quantity'],
			'id' => $data['id'],
		));
	}


	public function orderGetList($data) {
		global $db;
		
		if ($this->order_items)
			return $this->order_items;

		$data['catalog_id'] = intval($data['catalog_id']);

		// Получаем идентификатор первой цены
		$query = $db->query("SELECT id FROM com_catalogs_".$data['catalog_id']."_prices_type ORDER BY ordering LIMIT 1");
		$price_type_id = $query->fetchColumn();

		$stmt = $db->prepare("
			SELECT o.id, o.item_id, o.quantity, o.chars, i.name, i.url item_url, i.images, p.price, s.url section_url FROM com_catalogs_".$data['catalog_id']."_orders_items o
			JOIN com_catalogs_".$data['catalog_id']."_items i
			ON i.id = o.item_id
			LEFT JOIN com_catalogs_".$data['catalog_id']."_prices_value p
			ON p.item_id = i.id	AND p.price_type_id = :price_type_id
			JOIN com_catalogs_".$data['catalog_id']."_items_sections i_s
			ON i_s.item_id = i.id
			JOIN com_catalogs_".$data['catalog_id']."_sections s
			ON s.id = i_s.section_id
			WHERE order_id = :order_id
			GROUP BY o.id
		");
		$stmt->execute(array('order_id' => $data['order_id'], 'price_type_id' => $price_type_id));
		
		if ($stmt->rowCount() == 0)
			return false;






		$this->order_items = $stmt->fetchAll();

		// --- Цена со скидкой ---
		// Идентификатор цены со скидкой 
		$price_sale_type_id = $this->priceGetTypeIdByName(array(
			'catalog_id' => $data['catalog_id'], 
			'name' => 'Цена со скидкой'
		));

		if (!$price_sale_type_id)
			return $this->order_items;

		for ($i = 0; $i < count($this->order_items); $i++) {
			$price_sale = $this->priceGetValueByItemId(array(
				'catalog_id' => $data['catalog_id'],
				'price_type_id' => $price_sale_type_id,
				'item_id' => $this->order_items[$i]['item_id']
			));

			if ($price_sale && $price_sale > 0 && $price_sale < $this->order_items[$i]['price']) {
				$this->order_items[$i]['price'] = $price_sale;
			}
		}

		return $this->order_items;
	}


	public function orderDeleteItem($data) {
		global $db;

		$data['catalog_id'] = intval($data['catalog_id']);

		// Получаем идентификатор первой цены
		$stmt = $db->prepare("DELETE FROM com_catalogs_".$data['catalog_id']."_orders_items WHERE id = :id");
		$stmt->execute(array('id' => $data['id']));
	}


	// Закрытие ордера с внесением данных
	public function orderComplete($data) {
		global $db;
		$data['catalog_id'] = intval($data['catalog_id']);

		$data = array_merge($data, array('status'  => 1));
		$this->orderUpdate($data);

		$stmt = $db->prepare("DELETE FROM com_catalogs_".$data['catalog_id']."_orders_items WHERE order_id = :order_id");
		$stmt->execute(array('order_id' => $data['order_id']));
	}


	// Закрытие ордера с изменением статуса
	public function orderCompleteStatus($data) {
		global $db;
		$data['catalog_id'] = intval($data['catalog_id']);

		$this->setStatus($data);

		$stmt = $db->prepare("DELETE FROM com_catalogs_".$data['catalog_id']."_orders_items WHERE order_id = :order_id");
		$stmt->execute(array('order_id' => $data['order_id']));
	}


	public function orderUpdate($data) {
		global $db;
		$data['catalog_id'] = intval($data['catalog_id']);	

		// Ищем открытый заказ в БД
		$stmt = $db->prepare("
			UPDATE com_catalogs_".$data['catalog_id']."_orders SET
			description = :description,
			data = :data,
			sum = :sum,
			fio = :fio,
			phone = :phone,
			email = :email,
			address = :address,
			comments = :comments,
			status = :status,
			date_order = NOW()
			WHERE id = :id
		");

		$stmt->execute(array(
			'description' => $data['description'],
			'data' => serialize($data['data']),
			'sum' => $data['sum'],
			'fio' => $data['fio'],
			'phone' => $data['phone'],
			'email' => $data['email'],
			'address' => $data['address'],
			'comments' => $data['comments'],
			'status' => $data['status'],
			'id' => $data['order_id']
		));
	}


	public function setStatus($data) {
		global $db;
		$data['catalog_id'] = intval($data['catalog_id']);	

		// Ищем открытый заказ в БД
		$stmt = $db->prepare("
			UPDATE com_catalogs_".$data['catalog_id']."_orders SET
			status = :status
			WHERE id = :id
		");

		$stmt->execute(array(
			'status' => $data['status'],
			'id' => $data['order_id']
		));

		if ($data['status'] == 1) {
			$stmt = $db->prepare("DELETE FROM com_catalogs_".$data['catalog_id']."_orders_items WHERE order_id = order_id");
			$stmt->execute(array('order_id' => $data['order_id']));			
		}
	}


	public function orderDelete($data) {
		global $db;

		$stmt = $db->prepare("DELETE FROM com_catalogs_".$data['catalog_id']."_orders WHERE id = id");
		$stmt->execute(array('id' => $data['id']));

		$stmt = $db->prepare("DELETE FROM com_catalogs_".$data['catalog_id']."_orders_items WHERE order_id = :order_id");
		$stmt->execute(array('order_id' => $data['id']));
	}


	// ======= КУПОНЫ =======
	public function couponsCount($catalog_id) {
		global $db;

		$stmt = $db->query("SELECT id FROM com_catalogs_".$catalog_id."_coupons");
		return $stmt->rowCount();
	}


	public function couponsGet($data) {
		global $db;
		$data['catalog_id'] = intval($data['catalog_id']);

		$stmt = $db->prepare("SELECT discount FROM com_catalogs_".$data['catalog_id']."_coupons WHERE code = :code");
		$stmt->execute(array('code' => $data['code']));

		if ($stmt->rowCount() == 0)
			return 0;

		return $stmt->fetchColumn();
	}


	// ======= PRICE =======
	public function priceTypeSetId($price_type_id) {
		$this->price_type_id = $price_type_id;
	}

	public function priceGetTypeIdByName($data) {
		global $db;
		$stmt = $db->prepare("SELECT id FROM com_catalogs_".$data['catalog_id']."_prices_type WHERE name = :name ORDER BY ordering LIMIT 1");
		$stmt->execute(array('name' => $data['name']));
		return $stmt->fetchColumn();
	}

	public function priceGetValueByItemId($data) {
		global $db;

		$stmt = $db->prepare("SELECT price FROM com_catalogs_".$data['catalog_id']."_prices_value WHERE price_type_id = :price_type_id AND item_id = :item_id LIMIT 1");
		$stmt->execute(array('price_type_id' => $data['price_type_id'], 'item_id' => $data['item_id']));

		return $stmt->fetchColumn();
	}
}