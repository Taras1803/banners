<?php


class FavoritesModel extends CI_Model {
	
    
    function getList() {
        
        $items = $this->session->items;
        
        if( !empty( $items ) ){

            $this->db->select([

                'side.code',
                'side.id',
                'side.image_id',
                'boards.address',
                'boards.coordinates',
                'boards.GID',
                'type.name as type',
                'type.color as color',
                'type.name as name',
                'img.small as medium',
                'img.small'

            ]);

            $this->db->from('board_sides side');
            $this->db->where_in('side.id', $items);

            $this->db->join('boards', 'boards.id = side.board_id', 'left');
            $this->db->join('board_types type', 'boards.type = type.id', 'left');
            $this->db->join('files img','img.id = side.image_id', 'left');

            return $this->db->get()->result();
            
        }
        
        return [];
        
    }
    
    function getById($id = 0){
        
        $this->db->select([

            'side.code',
            'side.id',
            'boards.address',
            'boards.GID',
            'type.name as type'

        ]);

        $this->db->from('board_sides side');
        $this->db->where('side.id', $id);

        $this->db->join('boards', 'boards.id = side.board_id', 'left');
        $this->db->join('board_types type', 'boards.type = type.id', 'left');

        return $this->db->get()->first_row();
        
    }
    
    function add($id){
     
        if( $id ){
    
            $items = empty( $this->session->items ) ? [] : $this->session->items;

            if( !in_array($id, $items) ){
                
                $side = $this->FavoritesModel->getById($id);
                
                if($side) {

                    $items[] = $side->id;

                    $this->session->set_userdata('items', $items);
                    
                }

            }
            
        }
        
        
    }
    
    function getSummary(){
        
        //пересчитываем и выводим избранное

        $sorted = [];

        $favorites = $this->getList();
        
        if($favorites){

            foreach( $favorites as $item ){

                if( !isset( $sorted[$item->type]) ){

                    $sorted[$item->type] = 1;

                } else {

                    $sorted[$item->type]++;

                }

            }
        
        }
        
        return ['total' => count($favorites), 'sorted' => $sorted];
        
    }
    
    function clear(){
        
        $this->session->set_userdata('items', []);
        
    }

}
