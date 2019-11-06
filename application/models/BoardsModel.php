<?php

class BoardsModel extends CI_Model {
    
    
    function getList() {
        
        $this->db->select([
            'boards.*',
        ]);
        $this->db->from('boards');
        
        $this->db->order_by('id', 'DESC');
        
        return $this->db->get()->result();
    }
    
    
    function getByID ($id) {
        
        $this->db->select(['board.*']);
        
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


    // Ищем по строке, либо GID объекта, либо название дороги/города/района
    function getHints($str){

        if (is_numeric($str)){

            $this->db->select('GID as name')->from('boards');

            return $this->db->like('GID', $str, 'after')->limit(5)->order_by('GID', 'asc')->get()->result();

        } else {

            $esc = $this->db->escape_like_str($str);

            $sql = "SELECT name FROM roads WHERE name LIKE '%".$esc."%'
                    UNION
                    SELECT name FROM towns WHERE name LIKE '%".$esc."%'
                    UNION
                    SELECT name FROM districts WHERE name LIKE '%".$esc."%' LIMIT 5";

            $res = $this->db->query($sql)->result();

            return $res;

        }

    }


    function getExtraImages(&$board){
        $this->db->select('large');
        $this->db->from('extra_images img');
        $this->db->where('img.side_id', $board->side_id);
        $extra_imgs = $this->db->get()->result();

        if (count($extra_imgs) > 0){

            $board->image = [$board->image];

            foreach($extra_imgs as $img){
                $board->image[] = $img->large;
            }
        }
    }


    // Набираем объекты по такому-же городу/району/дороге, пока не наберем 4 штуки
    function getExtraObjs(&$board){
        $count = 4;
        $cols = ['b.GID', 'b.address', 't.name', 'f.medium'];

        $this->db->select($cols)->from('boards as b');
        $this->db->join('board_types t', 't.id = b.type');
        $this->db->join('board_sides as side', 'side.board_id = b.id');
        $this->db->join('files as f', 'f.id = side.image_id');
        $this->db->where('b.town_id', $board->town_id)->where('b.id !=', $board->id)->order_by('rand()')->limit($count);
        $res = $this->db->get()->result();

        if ($count == count($res)) return $res;


        $this->db->select($cols)->from('boards as b');
        $this->db->join('board_types t', 't.id = b.type');
        $this->db->join('board_sides as side', 'side.board_id = b.id');
        $this->db->join('files as f', 'f.id = side.image_id');
        $this->db->where('b.district_id', $board->district_id)->where('b.id !=', $board->id)->order_by('rand()')->limit($count - count($res));
        $res = array_merge($res, $this->db->get()->result());

        if ($count == count($res)) return $res;


        $this->db->select($cols)->from('boards as b');
        $this->db->join('board_types t', 't.id = b.type');
        $this->db->join('board_sides as side', 'side.board_id = b.id');
        $this->db->join('files as f', 'f.id = side.image_id');
        $this->db->where('b.road_id', $board->road_id)->where('b.id !=', $board->id)->order_by('rand()')->limit($count - count($res));
        $res = array_merge($res, $this->db->get()->result());

        return $res;
    }



    function getBackLink(){
        $link = '/boards/';

        if (isset($_SERVER['HTTP_REFERER'])){
            preg_match('/\/\/vmoutdoor.ru\/boards\/\?/', $_SERVER['HTTP_REFERER'], $matches);
            if (count($matches)) $link = $_SERVER['HTTP_REFERER'];
        }

        return $link;
    }

    
    
}