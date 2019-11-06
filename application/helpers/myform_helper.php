<?php


function set_selected_get($name, $val) {
    
    if( isset($_GET[$name]) ){
        
        if( $_GET[$name] == $val ){
        
            return 'selected';
            
            
        }
        
    }
    
}


//удаляет пустые значения в массиве, и заменяет массивы с одним значением переменными

function remove_empty($params){
    
    $array = [];
    
    foreach( $params as $key => $value ){
        
        if( $value != '' ){
        
            if ( is_array($value) ) {

                if( count($value) > 1 ){

                    $array[$key] = remove_empty($value);
                    
                } else {
                    
                    if( is_array( current($value) ) || is_string( key($value)) ){
                    
                        $array[$key] = remove_empty($value);
                        
                    } else {
                        
                        $array[$key] = current($value);
                        
                    }
                    
                }
                
            }

            else {
                
                $array[$key] = $value;

            }	
            
        }
        
    }
    
    ksort($array);
    
    return $array;
    
}

//отличается от стандартной http_build_query тем что не заменяет специальные символы и кирилицу

function build_query($params, $key = ''){
    
    $uri_str = [];
        
    foreach($params as $k => $value){
        
        if( $key != '' ){
            
            $j = $key . "[$k]";
            
        } else {
            
            $j = $k;
            
        }
        
        if ( !is_array($value) ) {

            $value = str_replace(" ", "+", trim($value));

            $uri_str[] = $j . '=' . $value;

        }

        else {

            $uri_str[] = build_query($value, $j);

        }	
        
    }
    
    return implode('&', $uri_str);
    
}

function set_selected_val($var, &$val) {
    
    if( isset($val) ){
        
        if( $var == $val ){
        
            return 'selected';
               
        }
        
    }
    
}

function set_val_get($name) {
    
    if( isset($_GET[$name]) ){
        
            return $_GET[$name];
        
    }
    
}

//prints value if variable exists

function echo_isset(&$var) {
    
    if( isset($var) ){
        
            return $var;
        
    }
    
}

//проверяет существует ли переменная и возвращает checked если его значение равно параметру 2

function set_checked(&$var, $value) {
    
    if( isset($var) ){
        
        if( is_array($var) ){
            
            if( in_array($value, $var) ){
             
                return "checked";
                
            }
            
        } else {
        
            if( $var == $value  ){

                return "checked";

            }
            
        }

    }
    
}

//проверяет существует ли переменна $_GET и ставит значение по умолчанию если оно тоже существует

function set_checked_val($name, &$default) {
    
    if( !empty($_POST[$name]) ){
        
        return $_POST[$name];
        
    } elseif( !empty( $default ) ) {
        
        return $default;
        
    }
    
}
