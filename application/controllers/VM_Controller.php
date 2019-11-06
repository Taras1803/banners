<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VM_Controller extends CI_Controller {
    
    function __construct(){
     
        parent::__construct();
        
        $this->load->model('FavoritesModel');
        $this->load->helper('global');
        
    }
    
    protected function view($view, $output = null, $seo = []){

        $summary = $this->FavoritesModel->getSummary();

        $header = $this->load->view('header_favorites', ['favorites' => $summary['sorted'] ], 1);

        $getnofollow = getnofollow();
        $seo['noindex'] = $getnofollow['noindex'];
        $seo['nofollow']  = $getnofollow['nofollow'];


        $this->load->view('header', [
            
            'favorites' => ['total' => $summary['total'], 'header' => $header],
            'seo' => $seo,
            'phone' => $this->get_option('phone'),
            'title' => $this->get_option('title'),
            'description' => $this->get_option('meta_description'),
            'keywords' => $this->get_option('meta_keywords'),
        
        ]);
        
        $this->load->view($view, $output);
        
        $this->load->view('footer');
        
    }
    
    function get_option($code){
        
        $option = $this->db->get_where('settings', ['code' => $code])->first_row();
        
        return $option->value;
        
    }
    
}
