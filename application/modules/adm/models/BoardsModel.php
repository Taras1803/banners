<?php

class BoardsModel extends CI_Model {
    
    
    function getList() {
        
        $this->db->select([
            'boards.*',
            'type.name as type'
        ]);
        
        $this->db->from('boards');
        
        $this->db->join('board_types type','type.id = boards.type', 'left');
        
        $this->db->order_by('GID', 'DESC');
        
        return $this->db->get()->result();
    }
    
    
    function getByID ($id) {
        
        $this->db->select( [
            
            'board.*'
        
        ]);
        
        $this->db->from('boards board');
        $this->db->where('board.id', $id);
    
        $board = $this->db->get()->first_row();
		
		if( $board ) {

			$board->props = $this->getProps($id, 1);
			
			return $board;

		}
			
        
    }
	
    function getSides($id) {

        $this->db->select([

            'side.*',
            'img.small as image_path',
            'img.original as image_full_path',

        ]);

        $this->db->from('board_sides side');

        $this->db->join('files img','img.id = side.image_id', 'left');

        $this->db->where('side.board_id', $id);

        $sides = $this->db->get()->result();

        foreach($sides as $side){
            $this->db->select('id,small');
            $this->db->from('extra_images img');
            $this->db->where('img.side_id', $side->id);
            $side->extra_imgs = $this->db->get()->result();
        }

        return $sides;
        
    }

    function getProps($board_id, $sort = 0){
		
		$this->db->from('board_prop_vals');

		$this->db->where('board_id', $board_id);
        
        $props = $this->db->get()->result();
        
        if( $sort ){
            
			$props_sorted = [];

			foreach( $props as $prop ){

				$props_sorted[ $prop->code ] = $prop->value;	

			}

            return $props_sorted;
            
        } else {

            return $props;
            
        }
		
	}
    
    function getProperty($id){
        
        $this->db->where("id", $id);
        $this->db->or_where("code", $id);
        
        return $this->db->get('board_props')->first_row();
        
    }
    
    function updateBoard($id, $fields, $props) {

        
        $board = $this->db->select('type')->where('id', $id)->get('boards')->first_row();
		
		//обновляем конструкцию

        $this->db->set($fields);
        $this->db->where('id', $id);
        $this->db->update('boards');
        
        //проверям изменился ли тип и переидексируем типы
        
        if( $board->type != $fields['type'] ){
        
            $this->type_recount([$fields['type'], $board->type]);
            
        }
		
		//сохраняем свойства

		foreach( $props as $code => $value ){

			$prop = $this->db->get_where('board_prop_vals', ['board_id' => $id, 'code' => $code])->first_row();

			if( $prop ) {

				if( !empty( $value != '' ) ){

					$this->db->set(['value' => $value]);
					$this->db->where('id', $prop->id);
					$this->db->update('board_prop_vals');

				} else {

					$this->db->delete('board_prop_vals', ['id' => $prop->id]);

				}


			} elseif( $value != '' ) {

				$this->db->insert('board_prop_vals', [

					'board_id' => $id,
					'code'    => $code,
					'value'   => $value

				]);

			}

		}
        
    }
	
	function updateSide($side_id, $fields) {
	
		//сохраняем стороны

		$this->db->where('id', $side_id);
		$this->db->update('board_sides', $fields);
		
	}
	
	function removeBoard($board_id){
        
        $board = $this->db->get_where('boards', ['id' => $board_id])->first_row();
        
        if( $board ){
        
            //переиндексируем колличество конструкций у типа

            $this->type_recount($board->type);

            $this->db->delete('board_sides', ['board_id' => $board_id]);

            $this->db->delete('board_prop_vals', ['board_id' => $board_id]);

            $this->db->delete('boards', ['id' => $board_id]);
            
        }
		
	}
	
	function removeSide($side_id){
		
		$side = $this->db->get_where('board_sides', ['id' => $side_id])->first_row();
		
		if( $side ){

			$this->db->delete('board_sides', ['id' => $side_id]);
			
		}
		
		return $side;
		
	}
	
    function addType($name) {
        
        if( !empty( $name ) ) {
        
            $name = trim($name);

            $exists = $this->db->get_where('board_types', ['name' => $name])->first_row();

            if( $exists ) {

                return $exists->id;

            } else {

                $this->db->insert('board_types', ['name' => $name, 'code' => $this->translate($name)]);

                return $this->db->insert_id();

            }
            
        }
        
    }
    
    function type_recount($ids = null){
        
        $this->db->from('board_types');
        
        $this->db->where_in('id', $ids);
        
        $types = $this->db->get()->result();
        
        foreach ( $types as $type ){
            
            $this->db->select('count(id) as count');
            $this->db->from('boards');
            $this->db->where('type', $type->id);
            
            $count = $this->db->count_all_results();
            
            $this->db->update('board_types', ['count' => $count], ['id' => $type->id]);
            
        }
        
    }
	
    function getCompanyByName($name) {
        
        if( !empty( $name ) ) {
        
            $name = trim($name);

            $exists = $this->db->get_where('companies', ['name' => $name])->first_row();

            if( $exists ) {

                return $exists->id;

            } else {

                $this->db->insert('companies', ['name' => $name]);

                return $this->db->insert_id();

            }
            
        }
        
    }



    protected function translate($string) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'x',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '',    'ы' => 'y',   'ъ' => '',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '',    'Ы' => 'Y',   'Ъ' => '',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',

            ' ' => '_', '"' => '', "'" => '', '/' => '_',
            ',' => '.'
        );
        return strtr($string, $converter);
    }
    
    
    
}