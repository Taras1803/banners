<?php

function get_option($code){

    $CI =& get_instance();

    $option = $CI->db->get_where('settings', ['code' => $code])->first_row();

    if( $option ){

        return $option->value;

    }

}

function logger( $data ){
    echo '<script>';
    echo 'console.log("'. gettype($data) .'", '.json_encode( $data ) .')';
    echo '</script>';
}

function getnofollow(){

    $CI =& get_instance();
    $CI->load->helper('url');
    $noindex = $CI->db->select('value')->from('settings')->where('code', 'noindex')->get()->result();
    $nofollow = $CI->db->select('value')->from('settings')->where('code', 'nofollow')->get()->result();
    $noindex_arr = json_decode($noindex[0]->value);
    $nofollow_arr = json_decode($nofollow[0]->value);
    $curent_url = site_url() . substr($_SERVER['REQUEST_URI'],1);

    foreach ($noindex_arr as $url){
        if(trim($curent_url) == trim($url)){
            $noindex = 1;
            break;
        }else{
            $noindex = 0;
        }
    }
    foreach ($nofollow_arr as $url){
        if(trim($curent_url) == trim($url)){
            $nofollow = 1;
            break;
        }else{
            $nofollow = 0;
        }
    }

    return ['noindex' => $noindex, 'nofollow' => $nofollow];
}

