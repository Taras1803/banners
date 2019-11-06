<?php

class CategoryModel extends CI_Model{

    // Соотношение названия таблиц и их колонок в таблице boards
    public static $colname = [
        'board_types' => 'type',
        'towns' => 'town_id',
        'roads' => 'road_id',
        'districts' => 'district_id'
    ];

    function getFullCategoryData($id){
        $category = $this->db->select('*')->from('categories')->where('id', $id)->get()->row();

        // Собираем фильтры в формате:
        // [
        //   ['filter_table' => 'board_types', 'filters_id' => '8,5']
        // ]
        $filters = $this->db->select(['r.filter_table', 'group_concat(r.filter_id) as filters_ids'])
            ->from('categories-filter-relation r')
            ->where('r.category_id', $category->id)
            ->group_by(['r.filter_table'])
            ->get()->result();

        // Ищем объекты по этим фильтрам
        $this->db->select(['*'])->from('boards');

        // Типы конструкций работают как логическое И
        $board_filter = $this->findForTypeFilter($filters);
        if ($board_filter)
            $this->db->where_in(self::$colname[$board_filter->filter_table], $board_filter->filters_ids);


        $sortByPlaces = $board_filter && count($filters);

        // Остальные фильтры группируются и работают как логическое ИЛИ
        if ($sortByPlaces) {
            $this->db->group_start();
            foreach ($filters as $index => $filter) {
                $filter_col = self::$colname[$filter->filter_table];
                if ($index === 0)
                    $this->db->where_in($filter_col, $filter->filters_ids);
                else
                    $this->db->or_where_in($filter_col, $filter->filters_ids);
            }
            $this->db->group_end();
        }

        // Results
        $category->items = $this->db->get()->result();
        return $category;
    }


    private function findForTypeFilter(&$array){
        foreach($array as $key => $struct) {
            if ($struct->filter_table == 'board_types') {
                unset($array[$key]);
                return $struct;
            }
        }
        return null;
    }
}