<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/VM_Controller.php';

class Error2 extends VM_Controller {

    public function __construct() {

        parent::__construct();
    }

    public function index(){

        $this->output->set_status_header('404');
        $this->view('error_404', [], ['title' => '404 not found']);
    }




}
