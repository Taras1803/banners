<?php

class User extends CI_Model {
    
    public $AdminGroup = 1;
    public $tableName = 'users';
    
    function login($login = null, $password = null) {



        if( !$login ) return 1;
        if( !$password ) return 2;
        
        $this->db->select('id, password');
        $this->db->where('login', $login);
        //$this->db->where('group_id', $this->AdminGroup);
        
        $user = $this->db->get($this->tableName)->first_row();

        if( $user ) {
        
            if( password_verify($password, $user->password) ){
                
                $auth = $user->id . '_' . sha1( $user->password );
                
                set_cookie('auth', $auth, 86400 * 30);

            } else {
             
                return 2;
                
            }
            
        } else {
            
            return 1;   
            
        }
        
    }
    
    function isAuthorized($auth) {
        
        if (!$auth) return false;
        
        list($id, $cookie_hash) = explode('_', $auth);
        
        $this->db->select('password, login, id, group_id');
        $this->db->where('id', $id);
        //$this->db->where('group_id', $this->AdminGroup);
        
        $user = $this->db->get($this->tableName)->first_row();
        
        if ($user){
         
            $pass_hash = sha1( $user->password );
            
            if( $cookie_hash === $pass_hash ) return $user;
            
        }
        
    }
    
} 