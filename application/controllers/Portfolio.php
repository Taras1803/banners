<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/VM_Controller.php';

class Portfolio extends VM_Controller {
    
    function __construct(){
     
        parent::__construct();
        
        $this->load->model('InfoUnitsModel');
        
    }

	public function index(){
    
        $portfolio = $this->InfoUnitsModel->getItems(['infounit_id' => 2, 'props' => 1]);
        
        $this->view('infounits/portfolio', ['portfolio' => $portfolio], ['title' => "Портфолио"]);
        
	}
}
