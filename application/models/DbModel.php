<?php


class DbModel extends CI_Model {

    function getPlaces(){
        $districts = $this->db->select('code,name')->from('districts')->get()->result();
        $towns = $this->db->select('code,name')->from('towns')->get()->result();
        $roads = $this->db->select('code,name,id')->from('roads')->get()->result();

        $out = [
            'roads' => ['name' => 'Шоссе', 'items' => $roads],
            'towns' => ['name' => 'Города', 'items' => $towns],
            'districts' => ['name' => 'Районы', 'items' => $districts],
        ];

        return $out;
    }

    public function rewriteurls(){
        $roads = $this->db->select('code,name,id')->from('roads')->get()->result();
        $towns = $this->db->select('code,name,id')->from('towns')->get()->result();
        $districts = $this->db->select('code,name,id')->from('districts')->get()->result();
        foreach ($roads as $key => $road){
            $url = $this->str2url($road->code);
            $this->db->set('code', $url);
            $this->db->where('id', $road->id);
            $this->db->update('roads');
        }
        foreach ($towns as $key => $town){
            $url = $this->str2url($town->code);
            $this->db->set('code', $url);
            $this->db->where('id', $town->id);
            $this->db->update('towns');
        }
        foreach ($districts as $key => $district){
            $url = $this->str2url($district->code);
            $this->db->set('code', $url);
            $this->db->where('id', $district->id);
            $this->db->update('districts');
        }


    }


    public function str2url($string)
    {
        $string = strtolower($string);
        $string = str_replace(' ', '-', $string);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
        $string = str_replace('-----', '-', $string);
        $string = str_replace('----', '-', $string);
        $string = str_replace('---', '-', $string);
        $string = str_replace('--', '-', $string);

        if(substr($string, -1) == '-'){
            $string = substr($string, 0, -1);
        }
        return $string;

    }


    function placeExist($table, $item){

        $is_exist = $this->db->select(['id','name','code'])->from($table)->where('code', $item)->get()->first_row();

        return $is_exist;

    }

    function getObjects($by_what, $id){

        $objs = [];

        $this->db->select(['b.*','t.name'])->from('boards as b');
        $this->db->join('board_types t', 'b.type = t.id');
        $this->db->where('b.'.$by_what, $id);
        $res = $this->db->get()->result();

        foreach($res as $item){
            if (isset($objs[$item->name])){
                $objs[$item->name][] = $item;
            } else {
                $objs[$item->name] = [$item];
            }
        }

        return $objs;
    }

}
