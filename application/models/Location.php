<?php


class Location extends CI_Model {
	
    
    //добавляет новое местоположение, если существует, то возвращает ID
    
    function addLocation($table, $name, $region_id = null) {
        
        if( !empty( $name ) ) {
        
            $name = trim($name);

            $exists = $this->db->get_where($table, ['name' => $name])->first_row();

            if( $exists ) {

                return $exists->id;

            } else {
                
                $fields = ['name' => $name];

                if ($table != 'regions') $fields['code'] = $this->translate($name);
                
                if( !empty( $region_id ) ){
                    
                    $fields['region_id'] = $region_id;
                    
                }

                $this->db->insert($table, $fields);

                return $this->db->insert_id();

            }
            
        }
        
    }

    protected function translate($string) {
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
