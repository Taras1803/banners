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

    public function index($code = null){
        if (!$code){
            show_404();
            return;
        }

        $perPage = 12;
        $page = 1;
        $get = (array) $this->input->get();

        if (isset($get['p'])){
            $p = (int) $get['p'];
            if ($p && is_int($p) && $p >= 1)
                $page = $p;
        }

        $category = $this->CategoryModel->getFullCategoryData($code);

        if (!$category){
            show_404();
            return;
        }

        $pagable_items = $this->CategoryModel->getPagableItems($category->items, $perPage, $page);

        $this->view(
            'category/detail',
            [
                'category' => $category,
                'pagable_items' => $pagable_items,
                'perPage' => $perPage,
                'page' => $page,
                'seo_links' => $this->CategoryModel->getSeoLinks()
            ],
            [
                'title' => $category->title,
                'desc' => $category->description,
            ]
        );
    }
}
