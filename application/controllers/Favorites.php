<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/VM_Controller.php';

class Favorites extends VM_Controller {
    
    
    function __construct(){
        
        parent::__construct();

       // $this->modules=array('SalerModel','OfferModel');
        
    }

	function index() {

        //$this->load->model(['saler/SalerModel', 'saler/OfferModel']);
       // echo site_url();
      // var_dump($this->load->module('OfferModel'));

        $favorites = $this->FavoritesModel->getList();

        $mapObjs = '';

       $mapObjs = $this->getUniqueForMap($favorites);
        
        $this->view('favorites', ['favorites' => $favorites, 'mapObjs' => $mapObjs], ['title' => "Избранное"]);
        
	}
    
    function remove($id = null){
        
        $items = $this->session->items;
        
        if( is_array($items) ){
            
            $index = array_search( $id, $items );
            
            if( $index !== false ){
                
                unset($items[$index]);
                
                $this->session->set_userdata('items', $items);
                
                $summary = $this->FavoritesModel->getSummary();
        
                $header = $this->load->view('header_favorites', ['favorites' =>  $summary['sorted'] ], 1);

                echo json_encode(['total' => $summary['total'], 'header' => $header]);
                
            }
            
        }
        
    }
    
    function add(){
        
        $ids = $this->input->post('id');
        
        
        if( !empty( $ids ) ){
        
            if( is_array($ids) ){

                foreach( $ids as $id ){
                    
                   $this->FavoritesModel->add($id);
                    
                }

            } else {
                
                $this->FavoritesModel->add($ids);
                
            }
            
            $summary = $this->FavoritesModel->getSummary();

            $header = $this->load->view('header_favorites', ['favorites' =>  $summary['sorted'] ], 1);

            echo json_encode(['total' => $summary['total'], 'header' => $header]);
            
        }
        
    }
    
    function export(){
        
        $sides = $this->FavoritesModel->getList();
        
        $rows = [];
        
        foreach( $sides as $side ){
            
            $rows[] = [$side->GID, $side->code, $side->type, $side->address];
            
        }
            
        //добавляем названия колонок первой строкой
        
        array_unshift($rows, ['Номер', 'Сторона', 'Тип', 'Адрес']);
        
        //создаём elsx файл
        
        $this->load->library('Excel');
        
        $data = $this->excel->setExportLayout("template/admin/xlsx_layout.xlsx");
    
        $data = $this->excel->export($rows);
        
        //отдаём файл браузеру
        
        $file_name = 'export_vmoutdoor_' . date('Y-m-d-H-i');
        
        header( "Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf8" );
        header( "Content-Disposition: inline; filename=$file_name.xlsx" );
        
        echo $data;
        
    }

    function getUniqueForMap($objs){
        $temp = [];
        $mapObjs = [];

        foreach($objs as $obj){
            if (array_search($obj->id,$temp) === false){
                $temp[] = $obj->id;
                $mapObjs[] = $obj;
            }
        }

        return $mapObjs;
    }
    
}
