<?php

class SalerModel extends CI_Model {

    public $tableName = 'salers';

    function login($login = null, $password = null) {

        if( !$login ) return 1;
        if( !$password ) return 2;

        $this->db->select('id, login, password');
        $this->db->where('login', $login);
        $saler = $this->db->get($this->tableName)->first_row();

        if( $saler ) {
            if( password_verify($password, $saler->password) ){ // made by password_hash('test', PASSWORD_BCRYPT)

                $auth = sha1($saler->id . $saler->password . rand());
                $this->db->set('token', $auth)->where('id', $saler->id)->update('salers');

                set_cookie('saler_auth', $auth, 86400 * 30);

            } else return 2;

        } else return 1;
    }

    function isAuthorized($auth) {

        if (!$auth) return false;

        $this->db->select('login, id');
        $this->db->where('token', $auth);

        $saler = $this->db->get($this->tableName)->first_row();

        return $saler ? $saler : false;

    }
    
} 