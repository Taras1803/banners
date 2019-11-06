<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Saler extends MX_Controller {

    protected $auth = 0;
    
    public $saler_info = null;

    function __construct() {

        parent::__construct();

        $this->load->model(['SalerModel', 'OfferModel']);

        $this->load->helper(['cookie', 'url', 'global_helper']);

        $this->auth = get_cookie('saler_auth');

    }

    function index() {

        if ($this->auth) {
            redirect(SALER_PAGE_PATH.'offer_list/');
            return;
        }

        $arOutput['error'] = 0;
		
		$post = $this->input->post();
        
        if( $post ){

            if ( $error = $this->SalerModel->login($post['username'], $post['password']) ) {

                $arOutput['error'] = $error;

            } else {

                redirect(SALER_PAGE_PATH.'offer_list/');

            }
            
        }
        
        $this->load->view('login', $arOutput);
        
    }

    function logout() {
        delete_cookie('saler_auth');
        redirect(SALER_PAGE_PATH);
    }


    function checkAuth() {

        $saler = $this->SalerModel->isAuthorized($this->auth);

        if ( !$saler )
        {
            delete_cookie('saler_auth');
            redirect(SALER_PAGE_PATH, 'refresh');
        }
        else
        {
            $this->saler_info = $saler;
            return true;
        }
    }




    function offer_list() {

        if ($this->checkAuth())
        {
            $objs = $this->OfferModel->getOffers($this->saler_info->id);
            $this->showView('offer_list', ['objs' => $objs]);
        }

    }

    function add(){
        if ($this->checkAuth())
        {
            $this->db->insert('saler_offers', ['saler_id' => $this->saler_info->id]);
            $id = $this->db->insert_id();
            redirect(SALER_PAGE_PATH.'offer/'.$id.'/');
        }
    }

    function offer($id = null){
        if ($id == null) {
            redirect(SALER_PAGE_PATH . 'offer_list/');
            return;
        }

        if ($this->checkAuth() && $offer = $this->OfferModel->offerData($id)) {
            $fav = [];

            if (count($this->session->items)) {
                $this->db->select('b.GID,s.code,s.id')->from('board_sides s');
                $this->db->join('boards b', 's.board_id = b.id')->where_in('s.id', $this->session->items);
                $fav = $this->db->get()->result();
            }

            $this->showView('offer', [
                'offer' => $offer,
                'fav' => $fav,
                'fav_string' => $this->session->items ? join(',',$this->session->items) : [],
            ]);
        } else {
            show_404();
        }
    }

    function specialOffer($id = null){
        if ($id == null || !$offer = $this->OfferModel->offerData($id)) {
            show_404();
            return;
        }

        $mapObjs = $this->OfferModel->getUniqueForMap($offer->offerData);

        $this->load->view('special-offer', ['offer' => $offer, 'mapObjs' => $mapObjs]);
    }

    function offerUpdate(){
        $post = (object) $this->input->post();

        if ($post->id)
            $this->db->set('data', $post->data)->where('id', $post->id)->update('saler_offers');

        redirect(SALER_PAGE_PATH . 'offer/'.$post->id.'/');
    }

    function offerDel($id = null){
        if ($id != null)
            $this->db->where('id', $id)->delete('saler_offers');

        redirect(SALER_PAGE_PATH . 'offer_list/');
    }




    function showView($page, $arPageData) {
        
        $this->load->view('header', ['saler' => $this->saler_info]);
        $this->load->view($page, $arPageData);
        $this->load->view('footer');
        
    }

    function manualCompile(){

        $less = new lessc;

        $less->compileFile("template/admin/css/admin-styles.less", "template/admin/css/admin-styles.css");

    }

}
