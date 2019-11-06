<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Files_model extends CI_Model {

    function getByID($ID) {

        $this->db->where('id', $ID);
        return $this->db->get('files')->first_row();
    }

    function get_path($ID) {

        $this->db->select('original');
        $this->db->where('id', $ID);
        $arFile = $this->db->get('files')->row_array();
        return $arFile['path'];
    }

    function add($arFields) {
        
        $exists = $this->db->get_where('files', ['hash' => $arFields['hash'] ])->first_row();
        
        if( $exists ){
            
            $this->update($exists->id, $arFields);
            
            return $exists->id;
            
        } else {

            $this->db->set($arFields);
            $this->db->insert('files');

            return $this->db->insert_id();
            
        }
        
    }
    
    function update($id, $arFields) {
        
        $this->db->set($arFields);
        $this->db->where('id', $id);
        $this->db->update('files');
        
    }
    
    function getFrame($id, $frameNum = 1){
        
            
        $video = $this->files_model->getById($id);
        
        $large = $medium = $small = null;
        
        $width = $height = 0;
        
        if ( !$video ) return false;

        if( extension_loaded ( 'ffmpeg' )){
            
            $dir = $this->hash_to_path( $video->hash );

            $framePath  =  $dir . $video->hash . '.jpg';

            $jpgOutputPath  =  $_SERVER['DOCUMENT_ROOT'] . '/' . $framePath;

            $path = $_SERVER['DOCUMENT_ROOT'] . $video->original;

            $movie = new ffmpeg_movie($path); 
            
            $width = $movie->getFrameWidth();
            $height = $movie->getFrameHeight();

            $image = imagecreatetruecolor( $width, $height );

            $frame = new ffmpeg_frame($image); 

            $frameImg = $movie->GetFrame($frameNum);


            if($frameImg) {
                
                if( $width > 1280 || $height > 720 ) {

                    $frameImg->resize(1280, 720); 
                    
                }

                $image = $frameImg->toGDImage();

                imagejpeg($image, $jpgOutputPath, 100);

                $large = '/' . $framePath;
                
                $medium = $this->image_resize($framePath, 500, 500, 'medium');
                $small  = $this->image_resize($framePath, 150, 150, 'small');

            }

        }
        
        $this->update($id, [

            'large'  => $large,
            'medium' => $medium,
            'small'  => $small,
            'frame'  => $frameNum,
            'height' => $height,
            'width'  => $width,

        ]);
        
        return $medium;
        
    }
    
    //функция получает md5 имя файла и создаёт папки
    
    public function file_path($path) {

        list($type, $ext) = explode('/', mime_content_type ($path) );
        
        //$md5 = md5_file($path);
        $md5 = md5($path.rand());
        
        $levels = 4;
        
        $newpath = 'upload/';
                       
        for($i = 0; $i < $levels * 2; $i += 2) {
            
            $dir = substr($md5, $i, 2);
            
            $newpath .= $dir . '/';
            
            if( !is_dir( $newpath ) ) {
                
                mkdir( $newpath );
                
            }
            
        }
        
        $name = $md5 . '.' . $ext;
        
        $newpath .= $name;

        return ['full_path' => $newpath, 'name' => $name, 'md5' => $md5];
    
    }
    
    public function hash_to_path($hash) {
        
        $levels = 4;
        $path = 'upload/';
        
        for($i = 0; $i < $levels * 2; $i += 2) {
            
            $dir = substr($hash, $i, 2);
            
            $path .= $dir . '/';
            
        }
        
        return $path;
        
    }
    
    
    public function image_resize($path, $max_width = 1000, $min_height = 1000, $prefix = 0){
        
        list($type, $ext) = explode('/', mime_content_type($path) );
        
        $imagecreate  = 'imagecreatefrom' . $ext;
        $imagesave    = 'image' . $ext;
        
        $image = $imagecreate($path);
        
        $width  = imagesx($image); 
        $height = imagesy($image);
        
        if ($width > $max_width) {
            
            // Вычисление пропорций

            $ratio = $height / $width;

            $new_width = $max_width;
            $new_height = round( $max_width * $ratio );
            
            //если получившаяся высота меньше min_height, то ставим высоту равной min_height и делаем длину пропорционально ей.
            
            if( $new_height < $min_height ) {
                
                $new_height = $min_height;
                $new_width = round( $new_height / $ratio );
                
            }
            
            //добавляем префикс в виде ДхШ или значения переменной prefix если не пусто
            
            $name = basename($path);
            
            $new_name = ( !empty($prefix) ) ? $prefix . '_' . $name : $new_width . 'x' . $new_height . '_' . $name;
            
            $newpath = str_replace($name, $new_name, $path);
            
            //сохраняем новое изображение

            $new_image = imagecreatetruecolor($new_width, $new_height);

            imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            
            imageinterlace($new_image, true); //прогрессивный JPEG
            
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);

            $imagesave($new_image, $newpath);

            imagedestroy($new_image);
            
        } else {
            
            $newpath = $path;
            
        }
            
        imagedestroy($image);
        
        return '/' . $newpath;
    
    }
    
    function uploadFile($tmp_file) {
        
        if( !is_file( $tmp_file ) ) {
            
            if( !empty( $_FILES[$tmp_file]['tmp_name'] ) ) {
                
                $tmp_file = $_FILES[$tmp_file]['tmp_name'];
                
            } else {
             
                return false;
                
            }
            
        }
        
        $path = $this->file_path($tmp_file);
        
        $errors = [];
        
        if( rename( $tmp_file, $path['full_path']) ) {
            
            chmod($path['full_path'], 0644);
            
            $mime = mime_content_type ( $path['full_path'] );
            
            list($type, $ext) = explode('/', $mime );

            $fields = [

                'original' => '/' . $path['full_path'],
                'name' => $path['name'],
                'type' => $mime,
                'hash' => $path['md5']

            ];

            $result = [
                
                'result' => 'OK', 
                'type'   => $type, 
                'name'   => $path['name'],
                'path'   => '/' . $path['full_path']
                
            ];

            switch ( $type ){

                case 'image':
                    
                    $fields['large']   = $this->image_resize($path['full_path'], 700, 700, 'large');
                    $fields['medium']  = $this->image_resize($path['full_path'], 300, 300, 'medium');
                    $fields['small']   = $this->image_resize($path['full_path'], 150, 150, 'small');
                    
                    list($width, $height, $type) = getimagesize ( $path['full_path'] );
                    
                    $fields['width']   = $width;
                    $fields['height']  = $height;
                    
                    $result['id']      = $this->files_model->add($fields);
                    $result['preview'] = $fields['small'];

                break;

                case 'video':

                    $video_info = $this->videoInfo( $path['full_path'] );

                    $fields['frame_rate'] = $video_info['frame_rate'];
                    $fields['duration']   = $video_info['duration'];

                    $result['id'] = $this->add($fields);

                    $result['preview'] = $this->getFrame( $result['id'] );

                break;
                    
                default:
                    
                    $result['id'] = $this->add($fields);
                
                break;

            }

            return $result;
            
        } else {

            return [
                
                'message' => "Неудалось переместить файл",
                'result'  => 0,
                
            ];
            
        }
        
    }
	
	//импортирует картинки с YandexDisk и сохраняет их в tmp
	
	function YaDiskImport($url){
		
		$doc = new DOMDocument();
		@$doc->loadHTMLFile($url);
		$xpath = new DOMXpath($doc);

		$attributes = $xpath->query(".//img[@class='content__image-preview']/@src"); //$xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' preview-resource__image ')]/@src");

        if (!is_object($attributes->item(0))){
            print_r($attributes);
        }
		
		$src = $attributes->item(0)->value;
		
		if( !empty($src) ){
		
			$ch = curl_init($src);
			
			$tmp_name = 'tmp/' . md5($src);
			
			$fp = fopen($_SERVER['DOCUMENT_ROOT'] . '/' . $tmp_name, 'wb');
			
			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_exec($ch);
			curl_close($ch);
			
			fclose($fp);
			
			return $tmp_name;
			
		}
		
	}
	
	function importImage($src){

		if( strpos($src, 'yadi.sk') !== false ){
			
			$tmp = $this->YaDiskImport($src);
			
			$upload = $this->uploadFile($tmp);
			
			return $upload['id'];
			
		}
		
	}

}
