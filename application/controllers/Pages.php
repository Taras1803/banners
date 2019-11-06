<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/VM_Controller.php';

class Pages extends VM_Controller {
    
    function __construct(){
     
        parent::__construct();
        
    }

	public function digital() {

		$this->view('pages/digital', null, ['title' => "Vostok Digital, создание и продвижение сайтов"]);
        
    }
    
    public function contacts() {

		$this->view('pages/contacts', null, ['title' => "Контакты"]);
        
    }
    
    
}
