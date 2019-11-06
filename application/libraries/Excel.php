<?php

    /* 
    
        Export and Import XLSX
        
        Author: Anton Gavrilov
        Version: 2.1 (for Smotridom)
        
        Discription:
        
        Lightweight library for export and import from simple XLSX files to array, 
        works with string and numeric values. Created for using in different projects,
        can be changed and improved. This version was altered to use in
        project Smotridom

    */

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Excel {
        
        public $layout;
        
        function setExportLayout($path){
            
            $this->layout = $path;   
            
        }

        function import( $file = null, $options = array() ) {
            
            if( !$file ) return "файл не существует";
            
            //opening archive

            $zip = new ZipArchive;

            if ($zip->open( $file ) === TRUE) {

                //retrieving string values

                $strs = $zip->getFromName('xl/sharedStrings.xml');
                
                if(!$strs) return "Неверный формат файла";

                $xml = simplexml_load_string($strs);

                $sharedStrings = array();

                foreach ($xml->children() as $item) {
                    
                    if ( !empty( $options['charset'] ) ){
                        
                        $val = iconv('utf-8', $options['charset'], (string)$item->t );
                        
                    } else {
                        
                        $val = (string)$item->t;
                        
                    }
                    
                    $sharedStrings[] = $val;

                }

                //retireving cell scheme

                $sheet = $zip->getFromName('xl/worksheets/sheet1.xml');

                $xml = simplexml_load_string($sheet);

                $out = array();
                
                $row = 0;
                
                $max_col = count( $xml->sheetData->row[0] );

                foreach ($xml->sheetData->row as $item) {
                        
                    //set offset

                    if( !empty($options['offset']) && $row < $options['offset'] ) {

                        $row++;

                        continue;

                    }

                    if( !empty($options['limit']) && $row > $options['limit'] ) break;


                    for($i = 0; $i < $max_col; $i++){

                        $cellName = $this->cellName($i, $row);

                        //echo $cellName;

                        $child = null;

                        foreach( $item->c as $cell ){

                            if($cell['r'] == $cellName){

                                $child = $cell;

                                break;

                            }

                        }

                        if( $child ){

                            $attrs = $child->attributes();

                        }

                        $value = isset($child->v) ? (string) $child->v : null;

                        $out[$row][$i] = !isset($attrs['t']) || !isset($value) ? $value : $sharedStrings[$value];

                    }

                    $row++;

                }

                $zip->close();
				
				if( count($out) > 0 ){
                
                	return $out;
					
				} else {
					
					return "Неверный формат файла или файл пуст";	
					
				}

            } else {

                return "Неверный формат файла";

            }

        }
        
        function importCSV( $file, $columns = 0 ) {
            
            $csv = [];
            
            $handle = fopen($file, "r");
            
            while (($data = fgetcsv($handle, 6000, ",")) !== FALSE) {
                
                $csv[] = $data;
                 
            }

            fclose($handle);
            
            //если первая строка - названия колонок, то меняем ключи в массиве на ассоциативные
            
            if( $columns ){
            
                $columns = $csv[0];
                
                unset($csv[0]);
                
                foreach( $csv as &$row ){
                    
                    $row = array_combine($columns, $row);   
                    
                }
                
            }
            
            return $csv;
            
        }
        
		function export( $array, $columns = 0 ) {
            
            $tmp = tempnam('tmp/', 'xlsx_export_');
            
            file_put_contents($tmp, file_get_contents($this->layout) );
            
            $zip = new ZipArchive;

            if ($zip->open( $tmp ) === TRUE) {
			
                if($array){

                    $arStrings = [];
                    
                    //получаем содержимое файла листа и переводим его в xml
                    
                    $sheetXML = $zip->getFromName('xl/worksheets/sheet1.xml');

                    $sheet = simplexml_load_string($sheetXML);
                    
                    //тоже самое со строковыми значениями
                    
                    $stringsXML = $zip->getFromName('xl/sharedStrings.xml');

                    $strings = simplexml_load_string($stringsXML);
                    

                    foreach ($array as $num => $row){

                        $xml_row = $sheet->sheetData->addChild('row');
                        
                        $xml_row->addAttribute('r', $num + 1);
                        
                        $letter = 0;

                        foreach($row as $value){

                            $cellName = $this->cellName($letter, $num);

                            $cell = $xml_row->addChild('c');

                            $cell->addAttribute('r', $cellName);

                            if($num == 0){

                                $cell->addAttribute('s', 1);

                            }

                            if( !is_numeric($value) ){

                                $cell->addAttribute('t', 's');

                                if( !in_array($value, $arStrings) ){

                                    $key = count($arStrings);

                                    $arStrings[$key] = htmlspecialchars($value);

                                    $value = $key;

                                } else {

                                    $value = array_search($value, $arStrings);

                                }

                            }

                            $cell->addChild('v', $value);

                            $letter++;

                        }

                    }

                    $count = count($arStrings);
                    
                    $strings['count'] = $count;
                    $strings['uniqueCount'] = $count;
                    
                    foreach ( $arStrings as $string ){
                        
                        $strings->addChild('si')->addChild('t', $string);

                    }
                    
                    $zip->addFromString('xl/sharedStrings.xml', $strings->asXML() );
                    $zip->addFromString('xl/worksheets/sheet1.xml', $sheet->asXML() );
                    
                    $zip->close();
                    
                    $xlsx = file_get_contents($tmp);
                    
                    unlink($tmp);
                    
                    return $xlsx;


                }
                
            }
			
		}
        
        
        function cellName($index, $row = null){
            
            $alphabeth = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
            
            $max = count($alphabeth);
            
            //адреса ячеек типа АА, AB, BC
            
            if( isset($alphabeth[$index]) ){
                
                $name = $alphabeth[$index];
                
            } else {
                
                $a = floor($index / $max);
                
                $b = $index - $a * 26;
                
                $c = ( $a > $max ) ? $this->cellName($a - 1) : $alphabeth[$a - 1];
                
                $name = $c . $alphabeth[$b];
                
            }
            
            if( isset($row) ) $name .= $row + 1;
            
            return $name;
            
        }

    }
    
?>
