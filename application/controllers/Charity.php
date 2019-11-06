<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/VM_Controller.php';

class Charity extends VM_Controller {
    
    function __construct(){
     
        parent::__construct();
        
        $this->load->model('InfoUnitsModel');
        
    }

	public function index(){
    
        $items = $this->InfoUnitsModel->getItems(['infounit_id' => 9, 'props'=>['href'] ]);

        $this->view('infounits/charity', ['items' => $items], ['title' => "Благотворительность"]);
        
	}
}
