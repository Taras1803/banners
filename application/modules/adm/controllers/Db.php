<?php

require APPPATH . '/modules/adm/controllers/Adm.php';

class Db extends Adm {

    var $autoload = array(
        'model' => array('BoardsModel'),
    );

    function __construct() {
        parent::__construct();
        $this->checkAuth();

        $this->load->helper('myform');
    }

    function index(){
        $this->db->from('board_types');
        $items = $this->db->get()->result();

        echo '<pre>';
        print_r($items);
        /*foreach($items as $item){
            $this->db->set('code', '"'.$this->trans($item->name).'"', FALSE);
            $this->db->where('id', $item->id);
            $this->db->update('board_types');
        }*/
    }




    function trans($string) {
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

            ' ' => '_', '"' => '', "'" => '', /*',' => '.'*/
        );
        return strtr($string, $converter);
    }
}