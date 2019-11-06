<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/VM_Controller.php';

class Home extends VM_Controller {
    
    function __construct(){
     
        parent::__construct();
        
    }

	public function index() {
        
//		$this->view('home', null, ['desc' => '', 'canon' => '']);
		$this->view('home');
	}
}
