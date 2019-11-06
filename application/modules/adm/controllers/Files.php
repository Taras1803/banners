<?php

require APPPATH . '/modules/adm/controllers/Adm.php';

class Files extends Adm {

    var $autoload = array(
        /*
        'model' => array('offers_model', 'files_model'),
        'language' => array('admin/buildings')*/

        'model' => array('files_model'),
        'language' => array()
    );

    function __construct() {
        parent::__construct();
        $this->checkAuth();
    }
    
    //собирает список неиспользуемых файлов и удаляем их через ajax

    function clean() {
        
        if( !empty( $_GET['id'] ) ){
            
            $file = $this->db->get_where('files', ['id' => $_GET['id']])->first_row();
            
            if ( $file ){
                
                $original = substr($file->original, 1);
            
                if( is_file($original) ){
                    
                   unlink($original);
                    
                }
                
                $small = substr($file->small, 1);
                
                if( is_file($small) ){
                    
                    unlink($small);
                    
                }
                
                $medium = substr($file->medium, 1);
                
                if( is_file($medium) ){
                    
                    unlink($medium);
                    
                }
                
                $large = substr($file->large, 1);
                
                if( is_file($large) ){
                    
                    unlink($large);
                    
                }
                
                $this->db->where('id', $file->id);
                $this->db->delete('files');
                
                echo $file->original;
                
            }
         
            die;
            
        }
        
        $this->db->select('id');

        $this->db->from('files');
        
        $files = $this->db->get()->result();
        
        $arFiles = [];
        
        $fields = [
            
            ['images', 'file'], ['buildings', 'logo'], ['companies', 'logo_picture_id'], ['offers', 'img'],
            ['buildings', 'picture'], ['new_items', 'detail_picture_id'], ['new_props', 'value']
                       
        ];
        
        foreach ( $files as $file ) {
            
            $used = false;
            
            foreach( $fields as $field ){
                
                $this->db->select('id');
                
                $this->db->from($field[0]);
                $this->db->where($field[1], $file->id);
                
                if( $this->db->get()->result() ){
                    
                    $used = true;
                    
                    continue 2;
                    
                }
                
            }
            
            if( !$used ) {
                
                $arFiles[] = $file->id;
                
            }
            
        }
        
        $this->load->view('header');

        $this->load->view('files/clean', [

            'files' => json_encode( $arFiles ),

        ]);

        $this->load->view('footer');
        
    }


    public function resize( $type = '' ) {

        $this->db->select('id');
        $this->db->from('files');
        
        switch ( $type ){
        
            case 'videos' :

                $this->db->where(['type' => 'video/mp4']);
                
                $type = "видео";
                
                break;

            case 'images' :

                $this->db->where_in('type', ['image/jpeg', 'image/png']);
                
                $type = "изображений";

                break;
                
            default :
                
                $type = "всех файлов";
                
                break;
                
        }
        
        $files = $this->db->get()->result_array();
        
        $this->load->view('header');
        
        $this->load->view('files/resize', [
            
            'files' => json_encode( $files ),
            'type' => $type
                                    
        ]);
        
        $this->load->view('footer');
        
    }
    
    //проставляет доступы 644 всем файлам
    
    public function access(){
        
        $files = $this->db->get('files')->result();
        
        foreach ( $files as $file ) {
            
            $path = substr( $file->large, 1 );
            
            chmod($path, 0644);
            
            $perms = substr(decoct(fileperms( $path )), -3);
            
            echo $file->name . ' - ' . $perms . "<br/>";
            
        }
        
    }
    
    
    //меняет размер изображений
    
    public function resizeFile() {
        
        $post = $this->input->post();
        
        $this->db->from('files');
        
        $this->db->where([ 'id' => $post['id'] ]);
        
        $file = $this->db->get()->first_row();
            
        $large = substr($file->large, 1);

        if( $file->large != $file->original && is_file($large) ) {

            unlink ( $large );

        }

        $medium = substr($file->medium, 1);

        if( $file->medium != $file->original && is_file($medium) ) {

            unlink ( $medium );

        }

        $small = substr($file->small, 1);

        if( $file->small != $file->original && is_file($small) ) {

            unlink ( $small );

        }

        $original = substr($file->original, 1);

        if( $file->type != "video/mp4" ) {

            $fields = [

                'large'  => $this->files_model->image_resize($original, 700, 700, 'large'),
                'medium' => $this->files_model->image_resize($original, 300, 300, 'medium'),
                'small'  => $this->files_model->image_resize($original, 150, 150, 'small'),
                'hash'   => $file->hash

            ];

            $this->files_model->update($file->id, $fields);

            echo json_encode ( $fields );

        } else {

            $result = $this->files_model->getFrame($file->id, $file->frame);

            echo json_encode ( $result );

        }

    }


    function uploadExtraImg($id){

        if (!$id) return;

        $file = $_FILES[0];
        $original = $file['tmp_name'];
        $upload_data = $this->files_model->file_path($original); // Создаем путь к картинкам вида /upload/44/0d/fc/f2/440dfcf2437b7476052d02e9f8201ee5.jpeg

        $uploadfile = $_SERVER['DOCUMENT_ROOT'].'/'.$upload_data['full_path'];

        move_uploaded_file($original, $uploadfile);

        $fields = [

            'name' => $upload_data['name'],
            'type' => explode('.', $upload_data['name'])[1],

            'original' => stristr($uploadfile, '/upload/'),
            'large'  => stristr($this->files_model->image_resize($uploadfile, 700, 700, 'large'), '/upload/'),
            'medium' => stristr($this->files_model->image_resize($uploadfile, 300, 300, 'medium'), '/upload/'),
            'small'  => stristr($this->files_model->image_resize($uploadfile, 150, 150, 'small'), '/upload/'),

            'hash'   => $upload_data['md5'],
            'side_id' => $id,

        ];

        $image_id = $this->db->insert('extra_images', $fields);

        $fields['image_id'] = $image_id;

        echo json_encode($fields);

    }
    

    // Удаляем экстра изображение по ID
    function deleteExtraImg(){

        $id = $this->input->post()['id'];

        $this->db->from('extra_images');
        $this->db->where('id = '.$id);
        $res = $this->db->get()->first_row();

        if (!$res || !$res->id) { echo 0; return; }

        // Удаляем файлы
        @unlink($_SERVER['DOCUMENT_ROOT'].$res->original);
        @unlink($_SERVER['DOCUMENT_ROOT'].$res->large);
        @unlink($_SERVER['DOCUMENT_ROOT'].$res->medium);
        @unlink($_SERVER['DOCUMENT_ROOT'].$res->small);

        $url = $res->original;

        // Удаляем 4 уровня папок выше, если они пусты
        for ($i = 0; $i < 4; $i++){
            $url_arr = explode('/', $url);
            $url = join('/',array_splice($url_arr, 0, -1));
            @rmdir($_SERVER['DOCUMENT_ROOT'].$url);
        }

        $this->db->delete('extra_images', array('id' => $res->id));

        echo 1;

    }


}
