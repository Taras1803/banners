<?php
require APPPATH.'/modules/adm/controllers/Adm.php';

class InfoUnits extends Adm {
    
    var $autoload = array(
        'model' => array('InfoUnitsModel', 'files_model'),
        'helper' => array('lang_helper', 'myform_helper')
    );
    
    
    function __construct() {
        
        parent::__construct();
        
        $this->checkAuth();
        
    }
    
    function index(){
        
        $query = $this->input->get();
        
        if( !empty($query['infounit_id']) ){
            
            $infounit = $this->InfoUnitsModel->get($query['infounit_id']);
            
            if( !$infounit ) show_404();

            $output = [
                
                'items'      => $this->InfoUnitsModel->getItems($query), 
                'categories' => $this->InfoUnitsModel->getCategoriesTree($infounit->id), 
                
                'infounit'  => $infounit,
                'current_category' => $this->input->get('category')
                
            ];

            $this->showView('infounits/items', $output);
            
            
        } else {
            
            show_404();   
            
        }
        
    }
    
    //добавляет новый инфоблок
    
    function add() {
        
        $this->db->insert('infounits', ['name' => 'Новый инфоблок']);

        $id = $this->db->insert_id();

        redirect(ADMIN_PAGE_PATH . 'infounits/settings/' . $id . '/');
        
    }
    
    function add_item($infounit_id) {
        
        $this->db->insert('infounits_items', ['name' => 'Новый элемент', 'infounit_id' => $infounit_id]);

        $id = $this->db->insert_id();

        redirect(ADMIN_PAGE_PATH . 'infounits/edit_item/' . $id . '/');
        
    }
    
    function add_category($infounit_id) {
        
        $this->db->insert('infounits_categories', ['name' => 'Новая категория', 'infounit_id' => $infounit_id]);

        $id = $this->db->insert_id();

        redirect(ADMIN_PAGE_PATH . 'infounits/edit_category/' . $id . '/');
        
    }
    
    function delete($id) {
        
        $item = $this->InfoUnitsModel->getItem($id);
        
        if( $item ){
            
            $tables = ['infounits_props_values'];
            
            foreach( $tables as $table ){
        
                $this->db->delete($table, ['item_id' => $id]);
                
            }
            
            $this->db->delete('infounits_items', ['id' => $id]);

            redirect(ADMIN_PAGE_PATH . 'infounits/?infounit_id=' . $item->infounit_id);
            
        }
        
    }
    
    function delete_unit($id) {
        
        $IU = $this->InfoUnitsModel->get($id);
        
        if( $IU ){
            
            $tables = ['infounits_items', 'infounits_categories', 'infounits_props', 'infounits_props_values'];
            
            foreach( $tables as $table ){
        
                $this->db->delete($table, ['infounit_id' => $id]);
                
            }
            
            $this->db->delete('infounits', ['id' => $id]);
            
            redirect(ADMIN_PAGE_PATH);
            
        }
        
    }
    
    function delete_category($id) {
        
        $category = $this->InfoUnitsModel->getCategory($id);
        
        if( $category ){
        
            $this->db->delete('infounits_categories', ['id' => $id]);
            
            //перемещаем элементы в родительскую категорию
            
            $this->db->update('infounits_categories', ['parent' => $category->parent], ['parent' => $category->id]);
            $this->db->update('infounits_items', ['category' => $category->parent], ['category' => $category->id]);
            

            redirect(ADMIN_PAGE_PATH . 'infounits/settings/' . $category->infounit_id . '/#tab_categories');
            
        }
        
    }
    
    function delete_prop($id){
        
        $prop = $this->db->get_where('infounits_props', ['id' => $id])->first_row();
        
        if( $prop ){
            
            $this->db->delete('infounits_props',  ['id'   => $id]);
            $this->db->delete('infounits_props_values', ['code' => $prop->code]);
            
        }
        
    }
    
    function settings($infounit_id){
        
        $infounit = $this->InfoUnitsModel->get($infounit_id);
        
        if( $infounit ){
            
            $post = $this->input->post();
            
            if( $post ){
                
                $name = htmlspecialchars( trim($post['name']) );
                
                $url = !empty($post['url']) ? $post['url'] : translit($name);
            
                $url = $this->InfoUnitsModel->uniqueUrl($url, $infounit_id, 'infounits');
                
                $fields = [
                    
                    'name' => $name,
                    'url' => $url,
                    
                ];
                
                $this->db->update('infounits', $fields, ['id' => $infounit_id]);
                
                //сохраняем свойства
                
                foreach( $post['props'] as $prop ){

                    if( !empty($prop['name']) && !empty($prop['code']) ){

                        $row = [

                            'name'        => $prop['name'],
                            'infounit_id' => $infounit_id,

                        ];

                        if( !empty( $prop['id'] ) ) {
                            
                            $property = $this->InfoUnitsModel->getProperty($prop['id'], $infounit_id);
                            
                            //обновляем значения, если изменился код
                            
                            if( $property->code != $prop['code'] ){
                                
                                //проверяем есть ли свойство с таким кодом
                                
                                $checkcode = $this->InfoUnitsModel->getProperty($prop['code'], $infounit_id);
                                
                                if( !$checkcode ){
                                
                                    $row['code'] = $prop['code'];

                                    $this->db->update('infounits_props_values', array('code' => $prop['code'], 'infounit_id' => $infounit_id), ['code' => $property->code]);
                                    
                                }
                                                                                                    
                            }
                            
                            $this->db->set($row);
                            $this->db->where('id', $prop['id']);
                            $this->db->update('infounits_props');


                        } else {
                            
                            //проверяем существует ли свойство с таким же кодом
                            
                            $checkcode = $this->InfoUnitsModel->getProperty($prop['code'], $infounit_id);
                            
                            if( !$checkcode ){
                                
                                $row['code'] = $prop['code'];

                                $this->db->set($row);
                                $this->db->insert('infounits_props');
                                
                            }

                        }

                    }

                }
                
                redirect(ADMIN_PAGE_PATH . 'infounits/settings/' . $infounit_id . '/');
                
            } else {
            
                $output = [

                    'categories' => $this->InfoUnitsModel->getCategoriesTree($infounit_id),
                    'properties' => $this->InfoUnitsModel->getProps($infounit_id),
                    'infounit'   => $infounit

                ];

                $this->showView('infounits/settings', $output);
                
            }
            
        } else {
         
            show_404();
            
        }
        
    }
    
    function edit_item($id) {
        
        $IU_Item = $this->InfoUnitsModel->getItem($id);

        if( empty($IU_Item) ) show_404();

        $post = $this->input->post();

        
        if ($post) {
            
            $minutes = $post['minutes'] > 60 ? '00' : $post['minutes'];
            $hours   = $post['hours']   > 60 ? '00' : $post['hours'];
            
            $timestamp = date('Y-m-d G:i:s', strtotime($post['date'] . ' ' . $hours . ':' . $minutes) );
            
            $name = htmlspecialchars( trim($post['name']) );
            
            //генерируем уникальный ЧПУ
            
//            $url = !empty($post['url']) ? $post['url'] : translit($name);
            $url =  translit($name);

            $url = $this->InfoUnitsModel->uniqueUrl($url, $id);
            
            $fields = [
                'name' => $name,
                'url' => $url,
                'content'  => $post['content'],
                'preview'  => $post['preview'],
                'category' => $post['category'],
                'date_created' => $timestamp,
            ];

            //загружаем и обновляем изображение
            
            if (!empty($_FILES['image']['tmp_name'])) {

                $upload_result = $this->files_model->uploadFile( $_FILES['image']['tmp_name'] );

                $fields['image'] = $upload_result['id'];

            } elseif ( isset($post['image']) ) {

                $fields['image'] = null;

            }
            
            $this->db->update('infounits_items', $fields, ['id' => $id]);
            
            
            //обновляем свойства информационного элемента
            
            if( !empty( $post['props'] ) ){
            
                foreach( $post['props'] as $code => $value ){

                    $table = 'infounits_props_values';

                    $prop = $this->db->get_where($table, ['item_id' => $id, 'code' => $code])->first_row();

                    //проверяем, если существует

                    if( $prop ) {

                        //обновляем или удаляем если пустое значение

                        if( !empty( $value != '' ) ){

                            $this->db->set(['value' => $value]);
                            $this->db->where('id', $prop->id);
                            $this->db->update($table);

                        } else {

                            $this->db->delete($table, ['id' => $prop->id]);

                        }


                    } elseif( $value != '' ) {

                        //добавляем, если не существует

                        $this->db->insert($table, [

                            'item_id' => $id,
                            'infounit_id' => $IU_Item->infounit_id,
                            'code'    => $code,
                            'value'   => $value

                        ]);

                    }

                }
                
            }
            
            redirect(ADMIN_PAGE_PATH.'infounits/edit_item/' . $id . '/');
            
        } else {
            
            $output = [
                
                'cats'      => $this->InfoUnitsModel->getCategoriesTree($IU_Item->infounit_id),
                'item'      => $IU_Item,
                'IU_Props'  => $this->InfoUnitsModel->getProps($IU_Item->infounit_id),
                'itemprops' => $this->InfoUnitsModel->getItemProps($id)
                
            ];

            $this->showView('infounits/edit_item', $output);
            
        }
        
    }
    
    function edit_category($id) {
        
        $category = $this->InfoUnitsModel->getCategory($id);

        if( empty($category) ) show_404();

        $post = $this->input->post();
        
        if ($post) {
            
            $name = htmlspecialchars( trim($post['name']) );
            
            //генерируем уникальный ЧПУ
            
            $url = !empty($post['url']) ? $post['url'] : translit($name);
            
            $url = $this->InfoUnitsModel->uniqueUrl($url, $id, 'infounits_categories');
            
            $fields = [
                
                'name' => $name,
                
                'url' => $url,
                
                'description'  => $post['description'],
                'parent'       => $post['parent'],
                
            ];
            
            if (!empty($_FILES['image']['tmp_name'])) {

                $upload_result = $this->files_model->uploadFile( $_FILES['image']['tmp_name'] );

                $fields['image'] = $upload_result['id'];

            } elseif ( isset($post['image']) ) {

                $fields['image'] = null;

            }
            
            $this->db->update('infounits_categories', $fields, ['id' => $id]);
            
            redirect(ADMIN_PAGE_PATH.'infounits/edit_category/' . $id . '/');
            
        } else {
            
            $cats = $this->InfoUnitsModel->getCategoriesTree($category->infounit_id, 0, $category->id);
            
            $this->showView('infounits/edit_category', ['category' => $category, 'cats' => $cats]);
            
        }
        
    }
    
}
