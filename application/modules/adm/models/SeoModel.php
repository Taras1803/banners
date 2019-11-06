<?php

class SeoModel extends CI_Model {

    function getItems(){
        $select = 's.id, s.linked_table, s.item_id, s.h1, s.title, s.description, s.text, e.name, e.code';

        $types = $this->db
            ->select($select)->from('map_filters_seo s')
            ->join('board_types e', 's.linked_table = "board_types" AND s.item_id = e.id')
            ->get()->result();
        $roads = $this->db
            ->select($select)->from('map_filters_seo s')
            ->join('roads e', 's.linked_table = "roads" AND s.item_id = e.id')
            ->get()->result();
        $districts = $this->db
            ->select($select)->from('map_filters_seo s')
            ->join('districts e', 's.linked_table = "districts" AND s.item_id = e.id')
            ->get()->result();
        $towns = $this->db
            ->select($select)->from('map_filters_seo s')
            ->join('towns e', 's.linked_table = "towns" AND s.item_id = e.id')
            ->get()->result();

        $data = array_merge($types, $roads, $districts, $towns);
        usort($data, function($a, $b){
            return $a->id > $b->id;
        });

        return $data;
    }

    function uploadMapSeo($data_arr){
        $count = count($data_arr);
        $i = 0;

        foreach ($data_arr as $seo) {
            if (!$seo['table']) continue; // Пропускаем если не указан тип
            if ($seo['table'] != 'board_types' && $seo['table'] != 'towns' && $seo['table'] != 'districts' && $seo['table'] != 'roads') continue; // Пропускаем если не известный нам тип
            if (!$seo['code']) continue; // Пропускаем если не задан CODE элемента


            $item = $this->db->select('id')->from($seo['table'])->where('code', $seo['code'])->get()->first_row();

            if (!$item || !$item->id) continue; // Пропускаем если с таким CODE нет элементов в базе

            $finished_data = [
                'linked_table' => $seo['table'],
                'item_id' => $item->id
            ];

            if ($seo['h1']) $finished_data['h1'] = $seo['h1'];
            if ($seo['title']) $finished_data['title'] = $seo['title'];
            if ($seo['description']) $finished_data['description'] = $seo['description'];
            if ($seo['text']) $finished_data['text'] = $seo['text'];


            $seo_item = $this->db->select('id')->from('map_filters_seo')->where([
                'item_id' => $item->id,
                'linked_table' => $seo['table']
            ])->get()->first_row();

            if ($seo_item && $seo_item->id) {

                $this->db->where('id', $seo_item->id);
                $this->db->update('map_filters_seo', $finished_data);

            } else {

                $this->db->insert('map_filters_seo', $finished_data);

            }

            $i++;
        }

        return [$count, $i];

    }

}