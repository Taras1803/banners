<?php

require APPPATH . '/modules/adm/controllers/Adm.php';

class Settings extends Adm {

    /*var $autoload = array(
        'model' => array('files_model'),
    );*/

    function __construct() {
        parent::__construct();
        $this->checkAuth();
        
        $this->load->helper('myform');
    }

    function index() {

        if($this->user->isAuthorized($this->auth)->group_id != 1) { redirect(ADMIN_PAGE_PATH, 'refresh'); return; } // Доступ только админам

        $post = $this->input->post();
        
        $errors = [];
        
        list($user_id, $cookie_hash) = explode('_', $this->auth);
        
        if ($post) {

            file_put_contents('robots.txt', $post['robots']);

            if( !empty( $post['settings']) ){

                foreach ( $post['settings'] as $code => &$value ){
                    if($code == 'noindex' || $code == 'nofollow' || $code == 'sitemap'){
                        $value = explode("\n", $value);
                        $value = json_encode($value);
                    }
                    $this->db->update('settings', ['value' => $value], ['code' => $code]);
                    
                }
                
            }
            
            $this->db->update('users', ['login' => $post['login'], 'email' => $post['email'] ], ['id' => $user_id]);
            
            if( !empty($post['new_password']) ){
                
                if( $post['new_password'] == $post['repeat_password'] ){

                    $user = $this->db->get_where('users', ['id' => $user_id])->first_row();

                    if( password_verify($post['old_password'], $user->password) ){

                        $hash = password_hash($post['new_password'], PASSWORD_DEFAULT);
                        
                        $this->db->update('users', ['password' => $hash], ['id' => $user_id]);
                        
                        $auth = $user_id . '_' . sha1( $post['new_password'] );
                        
                        set_cookie('auth', $auth);

                    } else {
                        
                        $errors[] = 'Неверный старый пароль';
                        
                    }
                    
                } else {
                    
                    $errors[] = 'Пароли не совпадают';
                    
                }
                                          
            }
                                          
        }
        
        $settings = $this->db->order_by('sorting')->get('settings')->result();


        foreach( $settings as  &$setting ){
            if($setting->code == 'noindex' || $setting->code == 'nofollow' || $setting->code == 'sitemap'){
                $setting->value = json_decode( $setting->value);
                $setting->value = implode("\n", $setting->value);
            }
        }
        $robots = file_get_contents(site_url() . 'robots.txt');

        $output = [
            
            'settings' => $settings,
            'robots' => $robots,
            'user'   => $this->db->get_where('users', ['id' => $user_id])->first_row(),
            'errors' => $errors,
            
        ];

        $this->showView('settings', $output);
        
    }
    
}
