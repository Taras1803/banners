<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/VM_Controller.php';

class Gallery extends VM_Controller {
    
    function __construct(){
     
        parent::__construct();
        
        $this->load->model('InfoUnitsModel');
        
    }

	public function index(){
    
        $portfolio = $this->InfoUnitsModel->getItems(['infounit_id' => 2, 'props' => 1]);

        $this->view('infounits/gallery', ['portfolio' => $portfolio], ['title' => "Портфолио"]);

	}
}
