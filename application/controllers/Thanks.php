<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/VM_Controller.php';

class Thanks extends VM_Controller {
    
    function __construct(){
     
        parent::__construct();
        
        $this->load->model('InfoUnitsModel');
        
    }

	public function index(){
    
        $thanks = $this->InfoUnitsModel->getItems(['infounit_id' => 3]);

        $this->view('infounits/thanks', ['thanks' => $thanks], ['title' => "Благодарности"]);
        
	}
}
