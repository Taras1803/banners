<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/controllers/VM_Controller.php';

class Category extends VM_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('CategoryModel');
    }

    function _remap($param) {
        $this->index($param);
    }

    public function index($id = null){
        if (!$id){
            show_404();
            return;
        }

        $category = $this->CategoryModel->getFullCategoryData($id);
        $this->view('category/detail', ['category' => $category]);
    }
}
