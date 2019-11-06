<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/VM_Controller.php';

class Db extends VM_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model(['DbModel']);
    }

    function index() {

        $out = $this->DbModel->getPlaces();
        $this->view('db/index',
            [
                'h1'=> 'База объектов',
                'objs' => $out,
                'breadcrumbs' => [
                    'Восток-Медиа' => '/',
                    'База объектов' => '/db/',
                ],
            ],
            ['title' => "База объектов — Восток Медиа"]
        );

    }

    public function rewriteurls(){
        $this->DbModel->rewriteurls();
        echo "ЧПУ ссылки обновлены";
    }

    protected function getItem($code = null, $table, $placeId){

        if (!$code) show_404();

        $item = $this->DbModel->placeExist($table, $code);

        if (!$item || !$item->id) show_404();


        $objs = $this->DbModel->getObjects($placeId, $item->id);

        $this->view('db/detail',
            [
                'h1'=> 'База объектов - '.$item->name,
                'objs' => $objs,
                'breadcrumbs' => [
                    'Восток-Медиа' => '/',
                    'База объектов' => '/db/',
                    $item->name => '/db/'.$code.'/'
                ],
            ],
            ['title' => "База объектов — ".$item->name." в Восток Медиа"]
        );
    }


    function roads($code = null){
        $this->getItem($code, 'roads', 'road_id');
    }


    function towns($code = null){
        $this->getItem($code, 'towns', 'town_id');
    }


    function districts($code = null){
        $this->getItem($code, 'districts', 'district_id');
    }
}