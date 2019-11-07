<?php

class CategoryModel extends CI_Model{

    // Соотношение названия таблиц и их колонок в таблице boards
    public static $colname = [
        'board_types' => 'type',
        'towns' => 'town_id',
        'roads' => 'road_id',
        'districts' => 'district_id'
    ];

    public static $sort_fields = ['popularity'];

    function getFullCategoryData($code){
        $category = $this->db->select('*')->from('categories')->where('code', $code)->get()->row();

        if (!$category) return null;

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
        $this->db->select([
            'b.id', 'b.GID', 'b.address', 'b.coordinates',
            't.name', 't.single_name',
            'f.medium file',
        ])->from('boards b')->group_by('b.id');

        // Типы конструкций работают как логическое И
        $board_filter = $this->findForTypeFilter($filters);
        if ($board_filter)
            $this->db->where_in('b.'.self::$colname[$board_filter->filter_table], $board_filter->filters_ids);

        // Остальные фильтры группируются и работают как логическое ИЛИ
        if (count($filters)) {
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

        // Подтягиваем название типа объекта и фотографию
        $this->db->join('board_types t', 't.id = b.type', 'left');
        $this->db->join('board_sides s', 's.board_id = b.id', 'left');
        $this->db->join('files f', 'f.id = s.image_id', 'left');

        // Sorting
        if (
            isset($_GET['sort']) &&
            isset($_GET['sort_type']) &&
            in_array($_GET['sort'], self::$sort_fields) &&
            ($_GET['sort_type'] == 'asc' || $_GET['sort_type'] == 'desc')
        ){
            $this->db->order_by($_GET['sort'], $_GET['sort_type']);
        } else {
            // Default sort
            $this->db->order_by('popularity', 'desc');
        }

        // Results
        $category->items = $this->db->get()->result();
        return $category;
    }


    function getSeoLinks(){
        return [
            'type' => $this->db->where('count > 0')->order_by('count DESC')->get('board_types')->result(),
            'road' => $this->db->order_by('name')->get('roads')->result(),
            'district' => $this->db->order_by('name')->get('districts')->result(),
            'town' => $this->db->order_by('name')->get('towns')->result(),
        ];
    }


    function getPagableItems($items, $perPage, $page = 1){
        return array_slice($items, ($page - 1) * $perPage, $perPage);
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