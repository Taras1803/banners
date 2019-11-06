<?php

    //функция исправляет язык ввода в случае ошибки

    function input_lang($str){
        
        $keys = [
            
            "й" => "q", "ц" => "w", "у" => "e",
            "к" => "r", "е" => "t", "н" => "y",
            "г" => "u", "ш" => "i", "щ" => "o",
            "з" => "p", "х" => "[", "ъ" => "]",
            "ф" => "a", "ы" => "s", "в" => "d",
            "а" => "f", "п" => "g", "р" => "h",
            "о" => "j", "л" => "k", "д" => "l",
            "ж" => ";", "э" => "'", "я" => "z",
            "ч" => "x", "с" => "c", "м" => "v",
            "и" => "b", "т" => "n", "ь" => "m",
            "б" => ",", "ю" => "."
        ];
        
        $keys = array_merge( $keys, array_flip($keys) ); //меня ключи и значения местами и смешиваем полученные массивы
        
        return strtr($str, $keys);
    }

    function mb_ucfirst($str){
        
        mb_internal_encoding("UTF-8");
        
        return mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1);   
        
    }

    //транслитерация
        
    function translit($str){
        
        $str = trim($str);
        
        $lits = [
          
            "а" => "a",   "б" => "b",   "в" => "v",
            "г" => "g",   "д" => "d",   "е" => "e",
            "ё" => "e",   "ы" => "y",   "з" => "z",
            "и" => "i",   "й" => "j",   "к" => "k",
            "л" => "l",   "м" => "m",   "н" => "n",
            "о" => "o",   "п" => "p",   "р" => "r",
            "с" => "s",   "т" => "t",   "у" => "u",
            "ф" => "f",   "х" => "kh",  "ц" => "ts",
            "ч" => "ch",  "ш" => "sh",  "щ" => "shh",
            "ь" => "",    "ж" => "zh",  "ъ" => "",
            "э" => "e",   "ю" => "yu",  "я" => "ya",
            " " => "-"
            
        ];
            
        $str = mb_strtolower($str);
        
        //заменяем кирилицу на латиницу
        
        $str = strtr($str, $lits);
        
        //удаляем все другие символы
        
        $str = preg_replace("/[^a-z0-9-]/", "", $str);
        
        return $str;
        
    }

    function month_year( $time ){
        
        if( !is_int( $time ) ) 
            
            $time = strtotime($time);
        
        $monthes = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
        
        $month = $monthes[ date('m', $time) - 1 ];
        
        echo $month . " " . date('Y', $time);
        
    }

    function rus_date($time, $print = 1){
        
        if( !is_int( $time ) ) 
            
            $time = strtotime($time);
        
        $monthes = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
        
        $day = date('j', $time);
        $month = $monthes[ date('m', $time) - 1 ];
        
        $date = $day . " " . $month . " " . date('Y', $time);
        
        if( $print ) echo $date; else return $date;
        
    }




