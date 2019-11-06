<?php


class SeoModel extends CI_Model{

    function getSeoByParams($get){
        $seo = [];
        $table = '';

        if (isset($get['type'])) { $seo[] = $get['type']; $table = 'board_types'; }
        if (isset($get['road'])) { $seo[] = $get['road']; $table = 'roads'; }
        if (isset($get['town'])) { $seo[] = $get['town']; $table = 'towns'; }
        if (isset($get['district'])) { $seo[] = $get['district']; $table = 'districts'; }

        if (count($seo) != 1) return []; // Не возвращаем ничего если не 1 GET-параметра

        $seo = $seo[0];

        if ( count( explode(',',$seo) ) > 1 ) return []; // Не возвращаем ничего если больше 1 объекта в GET-параметре

        $this->db->select('seo.*')->from("$table t");
        $this->db->join('map_filters_seo seo', "seo.item_id = t.id AND seo.linked_table = '$table'", 'left');
        $this->db->where('t.code', $seo);
        $res = $this->db->get()->first_row();

        return $res;
    }




    function getSeoByParamsPost($post){
        $seo = [];
        $table = '';

        if (isset($post['type'])) { $seo[] = $post['type']; $table = 'board_types'; }
        if (isset($post['road'])) { $seo[] = $post['road']; $table = 'roads'; }
        if (isset($post['town'])) { $seo[] = $post['town']; $table = 'towns'; }
        if (isset($post['district'])) { $seo[] = $post['district']; $table = 'districts'; }

        if (count($seo) != 1) return []; // Не возвращаем ничего если не 1 POST-параметр

        $seo = $seo[0];

        if ( count($seo) > 1 ) return []; // Не возвращаем ничего если больше 1 объекта в POST-параметре

        $seo = $seo[0];

        $this->db->select('seo.h1,seo.title,seo.description,seo.text')->from("$table t");
        $this->db->join('map_filters_seo seo', "seo.item_id = t.id AND seo.linked_table = '$table'", 'left');
        $this->db->where('t.code', $seo);
        $res = $this->db->get()->first_row();

        return $res;
    }




    function getSeoLinks($get){
        $seo = [];
        $table = '';

        if (isset($get['type'])) return [];
        if (isset($get['road'])) { $seo['road'] = $get['road']; $table = 'roads'; }
        if (isset($get['town'])) { $seo['town'] = $get['town']; $table = 'towns'; }
        if (isset($get['district'])) { $seo['district'] = $get['district']; $table = 'districts'; }

        $where_key = key($seo);

        if (count($seo) != 1) return [];
        if (count( explode(',',$seo[$where_key]) ) != 1) return [];

        $this->db->select('b.code as b_code,b.name as b_name,t.name as t_name, t.code as t_code')->from('board_types as b');
        $this->db->join("$table t", 't.code = "'.$seo[$where_key].'"', 'left');
        $types = $this->db->get()->result();

        return ['types' => $types, 'where_key' => $where_key];
    }



    // $get - GET параметры
    // $output - список существующих фильтров (из базы)
    // Сопоставляем их, для удаления лишних параметров в canonical
    function getCanonical($get, $output){
        if (empty($get)) return '/boards/';

        $canon = '/boards/?';
        $extra_url = '';

        $params = [
            'types' => (isset($get['type'])) ? explode(',',$get['type']) : [],
            'districts' => (isset($get['district'])) ? explode(',',$get['district']) : [],
            'towns' => (isset($get['town'])) ? explode(',',$get['town']) : [],
            'roads' => (isset($get['road'])) ? explode(',',$get['road']) : [],
        ];

        foreach($params as $key => $val){
            // Если параметр пуст, то удаляем его и пропускаем итерацию
            if ( empty($val) ){
                unset($params[$key]);
                continue;
            }

            foreach($val as $num => $elem){
                // Если в базе нет таких фильтров - удаляем из списка
                if (!$this->valid($output[$key], $elem))
                    unset($params[$key][$num]);
            }

            if (!empty($params[$key]))
                $extra_url .= '&' . substr($key, 0, strlen($key) - 1) . '=' . join(',',$params[$key]); // &road=Vnukovskoe_shosse
        }

        if (!$extra_url) return '/boards/';

        return $canon . substr($extra_url, 1);
    }


    // Ищет в массиве элементов $ar такой элемент, 'code' которого будет равен $code
    private function valid(&$ar,$code){
        $is_valid = false;

        foreach($ar as $filter) {
            if ($filter->code == $code){
                $is_valid = true;
                break;
            }
        }

        return $is_valid;
    }

}