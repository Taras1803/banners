<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/VM_Controller.php';

class Partners extends VM_Controller {
    
    function __construct(){
     
        parent::__construct();
        
        $this->load->model('InfoUnitsModel');
        
    }

	public function index(){
    
        $partners = $this->InfoUnitsModel->getItems(['infounit_id' => 4]);

        $this->view('infounits/partners', ['partners' => $partners], ['title' => "Партнеры"]);
        
	}
}
