<?php
defined('AUTH') or die('Restricted access');

class AdminPoehali
{
	public $themes_arr = array(
		0 => 'Природные объекты',
		1 => 'Исторические места',
		2 => 'Памятники архитектуры',
		3 => 'Объекты культуры',
		4 => 'События, фестивали',
		5 => 'Научные объекты',
		6 => 'Промышленные объекты',
		7 => 'Прочее'
	);
	
	public $date_arr = array(
		'sn_url' => array(
			'youtube' => '',
			'instagram' => '',
			'tiktok' => '',
			'vkontakte' => '',
			'facebook' => '',
			'site' => ''
		)
	);

	// ======= БЛОГЕРЫ =======
	public function blogerGetBlogers()
	{
		global $db;

		$stmt = $db->query("SELECT id, fio, image, themes, sn, date_reg, date_last, status FROM com_poehali_blogers ORDER BY ordering");
		return $stmt->fetchAll();
	}
	
	public function blogerGet($id)
	{
		global $db;
		
		$stmt = $db->prepare("SELECT * FROM com_poehali_blogers WHERE id = :id");
		$stmt->execute(array('id' => $id));
		$arr = $stmt->fetch();
		$arr['data'] = unserialize($arr['data']);
		return $arr; 
	}

	public function blogerGetMaxOrdering()
	{
		global $db;

		$query = $db->query("SELECT MAX(ordering) FROM com_poehali_blogers");
		return $query->fetchColumn();
	}
	
	public function blogerInsert($data) 
	{
		global $db;
		
		$stmt = $db->prepare("
			INSERT INTO com_poehali_blogers SET 
			fio = :fio,
			image = :image,
			text = :text,
			email = :email,
			themes = :themes,
			sn = :sn,
			date_birth = :date_birth,
			date_reg = NOW(),
			date_last = NOW(),
			data = :data,
			status = :status,
			ordering = :ordering
		");

		$stmt->execute(array(
			'fio' => $data['fio'],
			'image' => $data['image'],
			'text' => $data['text'],
			'email' => $data['email'],
			'themes' => $data['themes'],
			'sn' => $data['sn'],
			'date_birth' => $data['date_birth'],
			'data' => serialize($data['data']),
			'status' => $data['status'],
			'ordering' => $data['ordering']
		));
	}
	
	public function blogerUpdate($data) 
	{
		global $db;
		
		$stmt = $db->prepare("
			UPDATE com_poehali_blogers SET 
			fio = :fio,
			image = :image,
			text = :text,
			themes = :themes,
			sn = :sn,
			date_birth = :date_birth,
			date_last = NOW(),
			data = :data,
			status = :status,
			ordering = :ordering
			WHERE id = :id
		");

		$stmt->execute(array(
			'fio' => $data['fio'],
			'image' => $data['image'],
			'text' => $data['text'],
			'themes' => $data['themes'],
			'sn' => $data['sn'],
			'date_birth' => $data['date_birth'],
			'data' => serialize($data['data']),
			'status' => $data['status'],
			'ordering' => $data['ordering'],
			'id' => $data['id']
		));
	}
	
	public function blogerDelete($id)
	{
		global $db;
		
		$stmt = $db->prepare("DELETE FROM com_poehali_blogers WHERE id = :id");
		$stmt->execute(array('id' => $id));

		$stmt = $db->prepare("DELETE FROM com_poehali_projects_blogers WHERE bloger_id = :bloger_id");
		$stmt->execute(array('bloger_id' => $id));	
	}
	
	public function blogerSetOrdering($data)
	{    
		# АЛГОРИТМ РАБОТЫ
	    # 1. Создаём массив list_id c id и находим порядковый индекс нашего элемента - n
	    # 2. Если тип UP - ставим - меняем местами с предыдущим id
	    # 3. Если тип DOWN - меняем местами с последующим id
	    # Записываем id в БД
		global $db;	

		$id = $data['id'];
		$act = $data['act'];

	    $rows = $this->blogerGetBlogers();
	    $list_id = [];
	    $i = $n = 0;

	    # 1. Создаём новый список list_id
	    foreach ($rows as $row) {
	    	$list_id[] = $row['id'];
	    	if ($row['id'] == $id)
	    		$n = $i;
	    	$i++;
	    }

        # 2. Если тип UP
        if ($act == 'up') {
            if ($n > 0) {
                $prev = $list_id[$n-1];
                $list_id[$n-1] = $id;
                $list_id[$n] = $prev;
            }
        }

        # 3. Если тип DOWN
        if ($act == 'down') {
            if ($n < count($list_id) - 1) {
                $next = $list_id[$n + 1];
                $list_id[$n + 1] = $id;
                $list_id[$n] = $next;
            }
        }

        for ($i = 0; $i < count($list_id); $i++) {
        	$stmt = $db->prepare("UPDATE com_poehali_blogers SET ordering = :ordering WHERE id = :id");
        	$stmt->execute(array('ordering' => $i, 'id' => $list_id[$i]));
        }
	}

	public function blogerSetStatus($data)
	{
		global $db;
		$stmt = $db->prepare('UPDATE com_poehali_blogers SET status = :status WHERE id = :id');
		$stmt->execute(array('id' => $data['id'], 'status' => intval($data['status'])));
	}


	// ======= PROJECTS =======
	public function projectGetProjects()
	{
		global $db;

		$stmt = $db->query("SELECT * FROM com_poehali_projects ORDER BY ordering");
		return $stmt->fetchAll();
	}

	public function projectGet($id)
	{
		global $db;
		
		$stmt = $db->prepare("SELECT * FROM com_poehali_projects WHERE id = :id");
		$stmt->execute(array('id' => $id));
		$arr = $stmt->fetch();
		$arr['data'] = unserialize($arr['data']);
		return $arr; 
	}

	public function projectGetMaxOrdering()
	{
		global $db;

		$query = $db->query("SELECT MAX(ordering) FROM com_poehali_projects");
		return $query->fetchColumn();
	}

	public function projectInsert($data) 
	{
		global $db;
		
		$stmt = $db->prepare("
			INSERT INTO com_poehali_projects SET 
			name = :name,
			text = :text,
			themes = :themes,
			coordinates = :coordinates,
			date = :date,
			data = :data,
			status = :status,
			ordering = :ordering
		");

		$stmt->execute(array(
			'name' => $data['name'],
			'text' => $data['text'],
			'themes' => $data['themes'],
			'coordinates' => $data['coordinates'],
			'date' => $data['date'],
			'data' => serialize($data['data']),
			'status' => $data['status'],
			'ordering' => $data['ordering']
		));
	}
	
	public function projectBlogersGetMaxOrdering($project_id)
	{
		global $db;

		$stmt = $db->prepare("SELECT MAX(ordering) FROM com_poehali_projects_blogers WHERE project_id = :project_id");
		$stmt->execute(array('project_id' => $project_id));
		return $stmt->fetchColumn();
	}
	
	public function projectBlogersGet($project_id)
	{
		global $db;

		$stmt = $db->prepare("
			SELECT pb.id pb_id, pb.date pb_date, pb.status pb_status, b.id b_id, b.fio b_fio, b.image b_image 
			FROM com_poehali_projects_blogers pb
			JOIN com_poehali_blogers b
			ON b.id = pb.bloger_id
			WHERE pb.project_id = :project_id 
			ORDER BY pb.ordering
		");
		$stmt->execute(array('project_id' => $project_id));
		return $stmt->fetchAll();
	}
	
	public function projectBlogerInsert($data) 
	{
		global $db;
		
		$ordering = $this->projectBlogersGetMaxOrdering($data['project_id']) + 1;
		
		$stmt = $db->prepare("
			INSERT INTO com_poehali_projects_blogers SET 
			project_id = :project_id,
			bloger_id = :bloger_id,
			date = NOW(),
			data = :data,
			status = :status,
			ordering = :ordering
		");

		$stmt->execute(array(
			'project_id' => $data['project_id'],
			'bloger_id' => $data['bloger_id'],
			'data' => serialize($data['data']),
			'status' => 1,
			'ordering' => $ordering
		));
	}
	
	public function projectBlogerDelete($bloger_id)
	{
		global $db;
		
		$stmt = $db->prepare("DELETE FROM com_poehali_projects_blogers WHERE bloger_id = :bloger_id");
		$stmt->execute(array('bloger_id' => $bloger_id));	
	}

	public function projectUpdate($data) 
	{
		global $db;
		
		$stmt = $db->prepare("
			UPDATE com_poehali_projects SET 
			name = :name,
			text = :text,
			themes = :themes,
			coordinates = :coordinates,
			date = :date,
			data = :data,
			status = :status,
			ordering = :ordering
			WHERE id = :id
		");

		$stmt->execute(array(
			'name' => $data['name'],
			'text' => $data['text'],
			'themes' => $data['themes'],
			'coordinates' => $data['coordinates'],
			'date' => $data['date'],
			'data' => serialize($data['data']),
			'status' => $data['status'],
			'ordering' => $data['ordering'],
			'id' => $data['id']
		));
	}
	
	public function projectDelete($id)
	{
		global $db;
		
		$stmt = $db->prepare("DELETE FROM com_poehali_projects WHERE id = :id");
		$stmt->execute(array('id' => $id));
		
		$stmt = $db->prepare("DELETE FROM com_poehali_projects_blogers WHERE project_id = :project_id");
		$stmt->execute(array('project_id' => $id));	
	}
	
	public function projectSetOrdering($data)
	{    
		# АЛГОРИТМ РАБОТЫ
	    # 1. Создаём массив list_id c id и находим порядковый индекс нашего элемента - n
	    # 2. Если тип UP - ставим - меняем местами с предыдущим id
	    # 3. Если тип DOWN - меняем местами с последующим id
	    # Записываем id в БД
		global $db;	

		$id = $data['id'];
		$act = $data['act'];

	    $rows = $this->projectGetProjects();
	    $list_id = [];
	    $i = $n = 0;

	    # 1. Создаём новый список list_id
	    foreach ($rows as $row) {
	    	$list_id[] = $row['id'];
	    	if ($row['id'] == $id)
	    		$n = $i;
	    	$i++;
	    }

        # 2. Если тип UP
        if ($act == 'up') {
            if ($n > 0) {
                $prev = $list_id[$n-1];
                $list_id[$n-1] = $id;
                $list_id[$n] = $prev;
            }
        }

        # 3. Если тип DOWN
        if ($act == 'down') {
            if ($n < count($list_id) - 1) {
                $next = $list_id[$n + 1];
                $list_id[$n + 1] = $id;
                $list_id[$n] = $next;
            }
        }

        for ($i = 0; $i < count($list_id); $i++) {
        	$stmt = $db->prepare("UPDATE com_poehali_projects SET ordering = :ordering WHERE id = :id");
        	$stmt->execute(array('ordering' => $i, 'id' => $list_id[$i]));
        }
	}
	
	public function projectSetStatus($data)
	{
		global $db;
		$stmt = $db->prepare('UPDATE com_poehali_projects SET status = :status WHERE id = :id');
		$stmt->execute(array('id' => $data['id'], 'status' => intval($data['status'])));
	}
}

?>