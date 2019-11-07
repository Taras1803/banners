<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/VM_Controller.php';

class Services extends VM_Controller {
    
    function __construct(){
     
        parent::__construct();
        
        $this->load->model('InfoUnitsModel');
        
    }

	function index(){

        $category_url = $this->uri->segment(2);
        $item_url     = $this->uri->segment(3);
    
        //выдаем 404 ошибку в корне, дизайна нет для данной страницы    
        
        if( !$category_url && !$item_url ) show_404();
        
        //проверяем если это страница или категория
        
        $page_url = !empty($item_url) ? $item_url : $category_url;
        
        $item = $this->InfoUnitsModel->getItem($page_url);
        
        $category = $this->InfoUnitsModel->getCategory($category_url);
        
        //выдаём 404 если не найдено ни страницы, ни категории
        
        if( !$category && !$item ) show_404();
        
        //если это страница существует, то выводим, иначе категория

        if (is_object($item) && $item->id == 253){

            if( empty($item->content) ) show_404();

            if( !$category ) $category = null;

            $this->view('infounits/services/zags-page', ['item' => $item, 'cat' => $category], ['title' => $item->name]);

            return;

        }
        
        if( $item || $item_url ){

            if( empty($item->content) ) show_404();
            
            if( !$category ) $category = null;

            $this->view('infounits/services/page', ['item' => $item, 'cat' => $category], ['title' => $item->name]);

        } else {

            $items = $this->InfoUnitsModel->getItems(['category' => $category->id]);

            $this->view('infounits/services/category', ['items' => $items, 'cat' => $category], ['title' => $category->name]);

        }
        
    }
    
    
}
