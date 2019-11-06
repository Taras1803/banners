<?php

require APPPATH . '/modules/adm/controllers/Adm.php';

class Category extends Adm {

    var $autoload = array(
        'model' => array('CategoryModel'),
    );

    function __construct() {
        parent::__construct();
        $this->checkAuth();

        $this->load->helper('myform');
    }

    public function index(){
            $items = $this->CategoryModel->getList();
            $this->showView('category/list', ['items' => $items]);
    }

    public function edit($id){
        $category = $this->CategoryModel->getCategory($id);
        $filters = $this->CategoryModel->getAllFilters();
        /*echo '<pre>';
        print_r($category);
            return;*/
        $this->showView('category/edit', ['category' => $category, 'filters' => $filters]);
    }

    public function add(){
        $filters = $this->CategoryModel->getAllFilters();
        $this->showView('category/add', ['filters' => $filters]);
    }

    function addAjax(){
        $category = $this->input->post()['category'];

        if ($category)
            echo $this->CategoryModel->add($category);
    }

    function updateAjax(){
        $category = $this->input->post()['category'];

        if ($category['id'] && $category['code'])
            echo $this->CategoryModel->update($category);
        else
            echo '0';
    }

    function removeAjax(){
        $category_id = $this->input->post()['category_id'];
        if ($category_id) {
            $this->CategoryModel->remove($category_id);
            die('1');
        }
        echo '0';
    }
}