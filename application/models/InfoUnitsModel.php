<?php

class InfoUnitsModel extends CI_Model {
    
    
    public $cats_tree = [];
    
    public $total;
    public $on_page = 5;
    
    function get($id) {
        
        return $this->db->get_where('infounits', ['id' => $id])->first_row();
        
    }

    function getItems($args) {

        $this->db->select([

            'SQL_CALC_FOUND_ROWS null as rows',
            'item.id',
            'item.url',
            'item.name',
            'item.preview',
            'item.content',
            'item.category',
            'item.date_created',
            'cat.name as category_name',
            'file.medium as image',
            'file.large as image_large',
            'file.original as image_full'

        ], false);
        
        $this->db->from('infounits_items item');
        
        $this->db->join('infounits_categories cat', 'cat.id = item.category', 'left');
        
        if( !empty( $args['infounit_id'] ) ){
        
            $this->db->where('item.infounit_id', $args['infounit_id']);
            
        }
        
        if( !empty( $args['category'] ) ){
        
            $this->db->where('item.category', $args['category']);
            
        }
        
        if( !empty( $args['page'] ) && is_numeric( $args['page'] ) ){
            
            //добавляем limit и получаем результаты на странице

            $offset = ($args['page'] - 1) * $this->on_page;

            $this->db->limit($this->on_page, $offset);   
            
        }
        
        $this->db->join('files file', 'file.id = item.image', 'left');
        
        $this->db->order_by('date_created', 'DESC');

        $items = $this->db->get()->result();
        
        $this->total = $this->db->query('SELECT FOUND_ROWS() count;')->row()->count;
        
        if( !empty( $args['props'] ) ){
            
            foreach ($items as &$item){
                
                $item->props = $this->getItemProps($item->id);
                
            }
            
        }
        
        return $items;
        
    }
    
    //получаем элемент по id или url, в случае с url нужно уточнить инфоблок
    
    function getItem($id, $infounit_id = null, $category = null) {

        $this->db->select([
        
            'item.*',
            'file.original as image'
            
        ]);
        
        $this->db->from('infounits_items item');
        
        $this->db->join('files file', 'file.id = item.image', 'left');
        
        if( !empty($infounit_id) ){
        
            $this->db->where("item.infounit_id = $infounit_id");
            
        }
        
        if( !empty($category) ){
        
            $this->db->where("item.category = $category");
            
        }
        
        $this->db->where("item.id = '$id' or item.url = '$id'");
        
        $IU_Item = $this->db->get()->first_row();
        
        return $IU_Item;
    }
    
    function getProps($infounit_id){
        
        return $this->db->get_where('infounits_props', ['infounit_id' => $infounit_id])->result();
        
    }
    
    //получает одно свойство по id ли коду
    
    function getProperty($id, $infounit_id){
        
        $this->db->where("infounit_id = $infounit_id and (id = '$id' or code = '$id')");
        
        return $this->db->get('infounits_props')->first_row();
        
    }
    
    function getItemProps($item_id, $sort = 1){
        
        $this->db->select();
        $this->db->where('item_id', $item_id);
        
        $props = $this->db->get('infounits_props_values')->result();
        
        $sorted = [];
        
        if( $sort ){
         
            foreach( $props as $prop ){
                
                $sorted[$prop->code] = $prop->value;
                
            }
            
            return $sorted;
            
        }
        
        return $props;
        
    }

    function getCategory($id, $infounit_id = null, $parent = null) {

        $this->db->select([
         
            'cat.*',
            'file.original as image'
            
        ]);
        
        $this->db->from('infounits_categories cat');
        
        $this->db->join('files file', 'file.id = cat.image', 'left');
        
        if( !empty($infounit_id) ){
        
            $this->db->where("cat.infounit_id = $infounit_id");
            
        }if( !empty($parent) ){
        
            $this->db->where("cat.parent = $parent");
            
        }
        
        $this->db->where("cat.id = '$id' or cat.url = '$id'");
        
        return $this->db->get()->first_row();
    }
    
    //получает категории, сортирует и добавляет уровень вложенности
    
    function getCategoriesTree($infounit_id, $parent = 0, $exclude = [], $level = 0) {

        $this->db->select();
        
        $this->db->from('infounits_categories cat');
        
        $this->db->where('cat.infounit_id', $infounit_id);
        $this->db->where('cat.parent', $parent);
        
        if( !empty( $exclude ) ){
         
            $this->db->where_not_in('cat.id', $exclude);
            
        }
        
        $cats = $this->db->get()->result();
        
        foreach( $cats as $cat ){
            
            $cat->level = $level;
            
            $this->cats_tree[] = $cat;
            
            $this->getCategoriesTree($infounit_id, $cat->id, $exclude, $level + 1);
            
        }
        
        return $this->cats_tree;
        
    }
    
    //проверяет уникальность ЧПУ элемента в таблице, добавляет номер в конец, если не уникально
    
    function uniqueUrl($url, $exclude, $table = 'infounits_items'){
        
        $this->db->select('url');
        
        $this->db->where('url', $url);
        $this->db->where("id != $exclude");
        
        $exists = $this->db->get($table)->result();
        
        if( $exists ){
        
            $matches = [];

            if( preg_match('/-[0-9]+$/', $url, $matches) ){

                $num = substr($matches[0], 1) + 1;

                $newUrl = preg_replace('/[0-9]+$/', $num, $url);

            } else {

                $newUrl = $url . '-1';

            }
            
            return $this->uniqueUrl($newUrl, $exclude, $table);
            
        } else {
         
            return $url;   
            
        }
        
    }

}
