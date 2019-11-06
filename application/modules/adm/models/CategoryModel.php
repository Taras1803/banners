<?php

class CategoryModel extends CI_Model{

    // Соотношение названия таблиц и их колонок в таблице boards
    public static $colname = [
        'board_types' => 'type',
        'towns' => 'town_id',
        'roads' => 'road_id',
        'districts' => 'district_id'
    ];

    function getList(){
        return $this->db->select(['id', 'code', 'h1', 'seo'])
            ->from('categories')
            ->get()->result();
    }

    function add($category){
        if (!$category['code'] || !$category['h1']) die('0');

        $this->db->insert('categories', [
            'code' => $category['code'],
            'h1' => $category['h1'],
            'seo'  => $category['seo'],
            'title' => $category['title'],
            'description' => $category['description']
        ]);
        $new_category_id = $this->db->insert_id();

        $this->db->where('category_id', $new_category_id)->delete('categories-filter-relation');

        $relations = [];
        foreach(self::$colname as $filter_table => $v){
            if (!isset($category[$filter_table])) continue;

            foreach($category[$filter_table] as $filter_id){
                $relations[] = [
                    'category_id' => $new_category_id,
                    'filter_id' => $filter_id,
                    'filter_table' => $filter_table
                ];
            }
        }

        if (count($relations))
            $this->db->insert_batch('categories-filter-relation', $relations);

        return 1;
    }

    function remove($category_id){
        $this->db->where('id', $category_id)->delete('categories');
        $this->db->where('category_id', $category_id)->delete('categories-filter-relation');
    }

    function update($category){
        $this->db->where('id', $category['id'])
        ->update('categories', [
            'code' => $category['code'],
            'h1' => $category['h1'],
            'title' => $category['title'],
            'description' => $category['description'],
            'seo' => $category['seo'],
        ]);

        $this->db->where('category_id', $category['id'])->delete('categories-filter-relation');

        $relations = [];
        foreach(self::$colname as $filter_table => $v){
            if (!isset($category[$filter_table]) || !count($category[$filter_table])) continue;

            foreach($category[$filter_table] as $filter_id){
                $relations[] = [
                    'category_id' => $category['id'],
                    'filter_id' => $filter_id,
                    'filter_table' => $filter_table
                ];
            }
        }

        if (count($relations))
            $this->db->insert_batch('categories-filter-relation', $relations);

        return '1';
    }

    function getCategory($category_id){
        $category = $this->db->select('*')->from('categories')->where('id', $category_id)->get()->row();

        foreach (self::$colname as $table => $v) {
            $category->$table =
                $this->db->select(['group_concat(f.id) as ids'])->from('categories-filter-relation r')
                ->where('category_id', $category->id)
                ->join("$table f", "r.filter_table = '$table' && f.id = r.filter_id")
                ->get()->result();

            $category->$table = explode(',', $category->$table[0]->ids);
        }

        return $category;
    }

    function getAllFilters(){
        $filters = [];
        $fields = ['id', 'name'];

        foreach(self::$colname as $table => $v)
            $filters[$table] = $this->db->select($fields)->from($table)->get()->result();

        return $filters;
    }
}