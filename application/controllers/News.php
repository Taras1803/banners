<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/VM_Controller.php';

class News extends VM_Controller {
    
    function __construct(){
     
        parent::__construct();
        
        $this->load->helper('lang_helper');
        $this->load->model('InfoUnitsModel');
        
    }

	public function index($slug = 'page-1'){


        $this->load->helper('url');


        $item = $this->InfoUnitsModel->getItem($slug);
        
        if( $item ){
        
            $this->view('infounits/detail', $item, ['title' => $item->name]);
            
        } else {
        
            $arPage = explode('-', $slug);

            if ($arPage[0] != 'page' || !isset($arPage[1]) || !is_numeric($arPage[1])) show_404();

            $page = $arPage[1];

            $news = $this->InfoUnitsModel->getItems(['infounit_id' => 1, 'page' => $page]);

            //получаем все результатов

            $total = $this->InfoUnitsModel->total;

            $canonical = site_url('news/');

            if( $news ){

                if($page > 1){
                    $title = "Новости | Страница " . $page;
                }else{
                    $title = "Новости";
                }

                $output = [
                    'news' => $news,
                    'total_pages' => ceil($total / 5),
                    'current_page' => $page,
                    'seo' => ['title' => $title]
                ];

                $this->view('infounits/news', $output, ['title' => $title, 'page' => $page, 'canonical' => $canonical]);

            } else {

                show_404();   

            }
            
        }
	}
    
}
