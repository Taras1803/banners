<?php

require APPPATH . '/modules/adm/controllers/Adm.php';

class Boards extends Adm {

    var $autoload = array(
        'model' => array('BoardsModel', 'files_model', 'location', 'SeoModel'),
    );

    function __construct() {
        parent::__construct();
        $this->checkAuth();
        
        $this->load->helper('myform');
    }

    function index() {
        
        $output = [
            
            'boards'    => $this->BoardsModel->getList(),
            'companies' => $this->db->get('companies')->result(),
            'types'     => $this->db->get('board_types')->result()
        
        ];
        

        $this->showView('boards/list', $output);
    }

    
    function props(){
        
        $post = $this->input->post();
        
        if( $post ){
            
            foreach( $post['prop'] as $prop ){
                
                if( !empty($prop['name']) && !empty($prop['code']) ){
                    
                    $row = [

                        'name'    	  => $prop['name'],
                        'xlsx_column' => $prop['xlsx_column'],
                        
                        'show'        => isset($prop['show']) ? 1 : 0,

                    ];

                    if( !empty( $prop['id'] ) ) {
                         
                        $property = $this->BoardsModel->getProperty($prop['id']);
                        
                        //обновляем значения, если изменился код
                            
                        if( $property->code != $prop['code'] ){

                            //проверяем есть ли свойство с таким кодом

                            $checkcode = $this->BoardsModel->getProperty($prop['code']);
                            
                            if( !$checkcode ){

                                $row['code'] = $prop['code'];

                                $this->db->update('board_prop_vals', array('code' => $row['code']), ['code' => $property->code]);

                            }

                            $this->db->set($row);
                            $this->db->where('id', $prop['id']);
                            $this->db->update('board_props');

                        }
                        
                        
                    } else {
                        
                        //проверяем существует ли свойство с таким же кодом

                        $checkcode = $this->BoardsModel->getProperty($prop['code']);

                        if( !$checkcode ){

                            $row['code'] = $prop['code'];

                            $this->db->set($row);
                            $this->db->insert('board_props');
                            
                        }

                    }
                
                }
                
            }
			
			redirect(ADMIN_PAGE_PATH . 'boards/props/');
            
        }
		
		$this->db->from('board_props');
		
		$this->db->order_by('xlsx_column');
        
        $result['props'] = $this->db->get()->result();
        
        $result['types'] = [
        
            'string' => 'Строка',
            'text' => 'Текст',
            'file' => 'Файл',
            'checkbox' => 'Чекбокс',
            'select' => 'Выбор',
        
        ];
        
        $this->load->view('header', ['page' => 'buildings']);
        $this->load->view('boards/props', $result);
        $this->load->view('footer');
        
    }
    
    
    function remove_prop($id){
        
        $prop = $this->db->get_where('board_props', ['id' => $id])->first_row();
        
        if( $prop ){
            
            $this->db->delete('board_props',  ['id'   => $id]);
            $this->db->delete('props_values', ['code' => $prop->code]);
            
        }
        
    }
    
    function types(){
        
        $post = $this->input->post();
        
        if(!empty( $_GET['recount'] ) ){
            
            $this->BoardsModel->type_recount();   
            
        }
        
        if( $post ){
            
            foreach( $post['type'] as $type ){
                
                if( !empty($type['name']) ){
                    
                    $row = [
                        'name'    	  => $type['name'],
                        'color'    	  => $type['color'],
                        'count'    	  => $type['count'],
                    ];

                    if( !empty( $type['id'] ) ) {

                        $this->db->set($row);
                        $this->db->where('id', $type['id']);
                        $this->db->update('board_types');
                        
                    } else {
                        
                        $this->db->set($row);
                        $this->db->insert('board_types');

                    }
                
                }
                
            }
			
			redirect(ADMIN_PAGE_PATH . 'boards/types/');
            
        }
		
		$this->db->from('board_types');
		
		$this->db->order_by('count DESC');
        
        $result['types'] = $this->db->get()->result();
        
        $this->load->view('header', ['page' => 'buildings']);
        $this->load->view('boards/types', $result);
        $this->load->view('footer');
        
    }
    
    
    function remove_type($id){
        
        $this->db->delete('board_types',  ['id' => $id]);
        
        $this->db->update('boards', ['type' => 0], ['type' => $id]);
        
    }
	
    function add() {
		
        $this->db->insert('boards', ['type' => 1]);
        
        $id = $this->db->insert_id();
        
        //увеличиваем количество конструкций у типа
        $this->db->query('UPDATE board_types SET count = count + 1 WHERE id = 1');
        
        Header('Location: '.ADMIN_PAGE_PATH.'boards/edit/' . $id);
        
    }
	
    function addside($board_id) {
		
		$board = $this->db->get_where('boards', ['id' => $board_id])->first_row();
		
		if( $board ){

			$this->db->insert('board_sides', [
				'board_id' => $board_id
			]);

			$side_id = $this->db->insert_id();

			Header('Location: '.ADMIN_PAGE_PATH.'boards/edit/' . $board_id . '/#tab_side_' . $side_id);
			
		}
        
    }
    
    function edit($id) {

        $board = $this->BoardsModel->getByID($id);
        
        if (!$board) show_404();

        $output = [
			
            'board'      => $board,
			'types'      => $this->db->get('board_types')->result(),
            'props'      => $this->db->get('board_props')->result(),
			'regions'    => $this->db->get('regions')->result(),
			'companies'  => $this->db->get('companies')->result(),
			'districts'  => $this->db->get('districts')->result(),
			'towns'      => $this->db->get('towns')->result(),
			'roads'      => $this->db->get('roads')->result(),
			
			'sides'      => $this->BoardsModel->getSides($id)

        ];
        
        $this->load->view('header');
        $this->load->view('boards/edit_board', $output);
        $this->load->view('footer');
        
        
    }
    
    function save($id) {
        
        $post = $this->input->post();

        if ( $post ) {
            
            $props = !empty($post['props']) ? $post['props'] : [];
            
            $this->BoardsModel->updateBoard($id, $post['board'], $props);
            
            if( !empty( $post['sides'] ) ){
			
                foreach ( $post['sides'] as $side_id => $fields ){

                    //загружаем изображения

                    if (!empty($_FILES['sides']['tmp_name'][$side_id]['image_id'])) {

                        $upload_result = $this->files_model->uploadFile( $_FILES['sides']['tmp_name'][$side_id]['image_id'] );

                        $fields['image_id'] = $upload_result['id'];

                    } elseif ( isset($fields['image_id']) ) {

                        $fields['image_id'] = null;

                    }

                    $this->BoardsModel->updateSide($side_id, $fields);

                }
                
            }
            
        }
        
        Header('Location: ' . ADMIN_PAGE_PATH . 'boards/edit/' . $id . '/');
    }
    
    function remove($entity, $id){
		
		switch ($entity) {
				
			case 'board': 
				
				$this->BoardsModel->removeBoard($id);
				
				redirect(ADMIN_PAGE_PATH . 'boards/');
				
				break;
				
			case 'side':
				
				$side = $this->BoardsModel->removeSide($id);
				
				redirect(ADMIN_PAGE_PATH . 'boards/edit/' . $side->board_id . '/');
				
				break;
		}
        
    }
    
    function export() {
        
        $post = $this->input->post();
        
        
        $this->db->select([
        
            'boards.id',
            'boards.address',
            'boards.coordinates',
            'boards.GID',
            'regions.name as region',
            'districts.name as district',
            'towns.name as town',
            'roads.name as road',
            'companies.name as owner',
            'board_types.name as type',
        
        ]);
        
        $this->db->from('boards');
        
        $this->db->where_in('owner', $post['company']);
        $this->db->where_in('type', $post['type']);
        
        $this->db->join('regions',   'regions.id   = boards.region_id', 'left');
        $this->db->join('districts', 'districts.id = boards.district_id', 'left');
        
        $this->db->join('towns', 'towns.id = boards.town_id', 'left');
        $this->db->join('roads', 'roads.id = boards.road_id', 'left');
        
        $this->db->join('companies',   'companies.id   = boards.owner', 'left');
        $this->db->join('board_types', 'board_types.id = boards.type', 'left');
        
        $boards = $this->db->get()->result();
        
        $rows = [];
        
        foreach ($boards as $board){
            
            $props = $this->db->get('board_props')->result();
            
            $prop_vals = $this->BoardsModel->getProps($board->id, 1);
            
            $sides = $this->BoardsModel->getSides($board->id);
            
            foreach ($sides as $side){
                
                $row[0] = '-';
                $row[1] = $board->region;
                $row[2] = $board->district;
                $row[3] = $board->town;
                $row[4] = $board->road;
                $row[5] = $board->owner;
                
                $row[6] = $side->direction == 1 ? "Из Москвы" : "В Москву";
                
                $row[7] = $board->address;
                $row[8] = $board->type;
                
                $row[10] = $board->GID;
                $row[11] = $side->code;
                
                $row[12] = 'http://vmoutdoor.ru' . $side->image_full_path;
                
                $row[13] = 'http://vmoutdoor.ru/boards/detail/' . $board->GID . '/' . $side->code . '/';
                
                $row[14] = $board->coordinates;
                $row[23] = $side->price;
                
                $row[24] = $side->status == 0 ? 'Да' : 'Нет';
                
                foreach($props as $prop){
                    
                    $row[$prop->xlsx_column] = isset($prop_vals[$prop->code]) ? $prop_vals[$prop->code] : '';
                    
                }
                
                $rows[] = $row;
                
            }
            
        }
        
        
        //добавляем названия колонок первой строкой
        
        array_unshift($rows, [
            'Округ Москвы', 'Регион', 'Район','Город','Трасса','Собственник','Направление', 'Адрес',
            'Тип конструкции'/*, 'Размер конструкции'*/, 'GID',	'Cторона','Cсылка на фото','Cсылка на объект','Координаты','Цена печати','Цена монтажа','GRP',
            'OTS','Свет','ESPAR','Табличка', 'Материал','Прайс','Статус установки','GID партнера',
        ]);
        
        //создаём elsx файл
        
        $this->load->library('Excel');
        
        $data = $this->excel->setExportLayout("template/admin/xlsx_layout.xlsx");
    
        $data = $this->excel->export($rows);
        
        //отдаём файл браузеру
        
        $file_name = 'boards_' . date('Y-m-d-H-i');
        
        header( "Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf8" );
        header( "Content-Disposition: inline; filename=$file_name.xlsx" );
        
        echo $data;
        
    }
	
	function upload_xlsx(){
		
		$response = array('error' => false);
		
		if( !empty($_FILES['xlsx']) ){

			$import_file = $_FILES['xlsx']['tmp_name'];

			$this->load->library('Excel');

			$data = $this->excel->import($import_file, ['offset' => 1]);


			if( is_array($data) ){
                
                
                $default_cells = 16; //колличество ячеек по умолчанию
                
                $prop_cells = count( $this->db->get('board_props')->result() ); //колличество дополнительных полей
                
                if( count($data[1]) >= $default_cells + $prop_cells) {

                    $import = serialize($data);

                    //сохраняем массив в файл

                    $file = fopen('tmp/xlsx_import', 'w');

                    fwrite($file, $import);

                    fclose($file);

                    //отправляем колличество файлов

                    $response['boards'] = count( $data );
                   
                } else {
                
                    $response['error'] = "Количество колонок меньше ожидаемого";
                
                }

			} else {

				$response['error'] = $data;

			}

		} else {
			
			$response['error'] = "Файл не выбран";
			
		}
		
		echo json_encode( $response );
		
	}
    
    function import($index = null){
		
		$response = ['error' => false];
		
		//декодируем файл импорта из Excel в массив
		
		$data = unserialize( file_get_contents('tmp/xlsx_import') );
        
        $props = $this->db->get('board_props')->result();
		
		if( !empty( $data ) && $index != null){

			$row = $data[$index];
			$gid = $row[10];
            
            $type = $this->BoardsModel->addType($row[8]);
			
			//если нет конструкции с GID, то добавляем ее
			$board = $this->db->get_where('boards', ['GID' => $gid])->first_row();
			
			if( !$board ){
				$this->db->insert('boards', ['GID' => $gid]);
				$board_id = $this->db->insert_id();

                //увеличиваем количество конструкций у типа
                $this->BoardsModel->type_recount($type);
			}
            else {
				$board_id = $board->id;
			}
			
			//формируем поля для конструкции, проверям расположение и добавляем, если не существуют
            
            $region_id = $this->location->addLocation('regions', $row[1]);
			
			$fields = [
				
				'type'  => $type,
				'address'      => $row[7],
				'coordinates'  => $row[14],
				'owner'  => $this->BoardsModel->getCompanyByName($row[5]),
				
			];

            $region_id ? $fields['region_id'] = $region_id : '';
            $row[2] ? $fields['district_id'] = $this->location->addLocation('districts', $row[2], $region_id) : '';
            $row[3] ? $fields['town_id'] = $this->location->addLocation('towns', $row[3], $region_id) : '';
			$row[4] ? $fields['road_id'] = $this->location->addLocation('roads', $row[4], $region_id) : '';
			
			//импортируем поля свойств, в БД указаны номера колонок в Excel
			
			$prop_values = [];
			
			foreach( $props as $prop ){
				$prop_values[$prop->code] = $row[$prop->xlsx_column];
			}
			
			//обновляем конструкцию
			$this->BoardsModel->updateBoard($board_id, $fields, $prop_values);
			
			//добавляем и обновляем стороны конструкции
			$side_code = $row[11];
			
			$status = (mb_strtolower($row[24]) == 'да') ? 1 : 0;
			
			$direction = (mb_strtolower($row[6]) == 'из москвы') ? 1 : 2;

            $is_changing = isset($row[26]) ? $row[26] : '';
			
			$side_fields = [
				'board_id'  => $board_id,
				'code'      => $side_code,
				'status'    => $status,
				'direction' => $direction,
				'price'     => $row[23],
                'is_changing' => $is_changing,
			];
			
			$image_src = $row[12];
			
			//импортируем изображения
			if( !empty($_POST['import_image']) && !empty($image_src) ){
				$side_fields['image_id'] = $this->files_model->importImage($image_src);
			}

			$side = $this->db->get_where('board_sides', ['code' => $side_code, 'board_id' => $board_id])->first_row();

			if( !$side )
				$this->db->insert('board_sides', $side_fields);
            else
				$this->BoardsModel->updateSide($side->id, $side_fields);

			$response['name'] = $gid . '_' . $side_code;

		} else {
            
            $response['error'] = "Не возможно считать строку " . $index;
            
        }
		
		echo json_encode($response);
        
    }
    
    function toggle() {

        $post = $this->input->post();

        $checked = ($post['checked'] == 'true') ? 1 : 0;

        $this->db->set([ $post['col'] => $checked]);

        $this->db->where('id', $post['id']);
        $this->db->update('boards');

    }

    function uploadCsvSeo(){
        /*
        $val = $this->SeoModel->getItems();
        echo '<pre>';
        print_r($val);
        echo '</pre>';
        return;
        */

        $post = $this->input->post();
        $items = $this->SeoModel->getItems();

        if (empty($post) || !$post['seo']) {
            $this->showView('boards/upload_csv', ['items' => $items]);
            return;
        }

        $seo = explode("\n",$post['seo']);
        $data_arr = [];

        foreach($seo as $data){
            $data = explode('|', $data);
            $data_arr[] = [
                'table' => (isset($data[0])) ? $data[0] : '',
                'code' => (isset($data[1])) ? $data[1] : '',
                'h1' => (isset($data[2])) ? $data[2] : '',
                'title' => (isset($data[3])) ? $data[3] : '',
                'description' => (isset($data[4])) ? $data[4] : '',
                'text' => (isset($data[5])) ? $data[5] : '',
            ];
        }

        if (empty($data_arr)) return;

        $res = $this->SeoModel->uploadMapSeo($data_arr);

        $res_str = 'Обновлено SEO-записей '.$res[1].' из '.$res[0];

        $this->showView('boards/upload_csv', ['res' => $res_str, 'items' => $items]);

    }

    function getDbCsv(){
        $towns = $this->db->select('name')->get('towns')->result();
        $districts = $this->db->select('name')->get('districts')->result();
        $roads = $this->db->select('name')->get('roads')->result();
        $types = $this->db->select('name')->get('board_types')->result();

        foreach($types as $type)
            echo $type->name."<br>";
    }
    

}
