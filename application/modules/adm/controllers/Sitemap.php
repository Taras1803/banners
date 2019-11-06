<?php

require APPPATH . '/modules/adm/controllers/Adm.php';

class Sitemap extends Adm
{


    function __construct() {
        parent::__construct();
        $this->checkAuth();

        $this->load->helper('myform');
    }

    function index() {

        $this->showView('sitemap', []);

    }

    public function generate() {

        $this->load->helper('url');

        $lastmod = '<lastmod>' . date('Y-m-d\TH:i:sP', time()) . '</lastmod>';

        $output = '<?xml version="1.0" encoding="UTF-8"?>';
        $output .= "\n";
        $output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
        $output .= "\n";

        if($this->inSitemap(site_url())){
            $output .= '<url>';
            $output .= "\n";
            $output .= '<loc>' . site_url() . '</loc>';
            $output .= "\n";
            $output .= $lastmod;
            $output .= "\n";
            $output .= '</url>';
            $output .= "\n";
        }
        $array_of_urls = [
            'db', 'news', 'gallery', 'thanks', 'partners', 'charity', 'boards', 'digital', 'favorites', 'contacts',
            'services/dorozhnye-ukazateli',
            'services/ekspertiza-reklamnykh-konstruktsij',
            'services/registratsiya-reklamy',
            'services/desig',
            'services/design/dizajn-naruzhnoj-reklamy',
            'services/montage',
            'services/montage/izgotovlenie-i-montazh-supersajtov',
            'services/montage/montazh-reklamnykh-bannerov',
            'services/montage/reklama',
            'services/production',
            'services/production/remont-reklamnykh-vyvesok',
            'services/production/reklama-na-shhitakh',
            'services/production/izgotovlenie-samokleyashhejsya-reklamy',
            'services/production/izgotovlenie-reklamnykh-vyvesok',
            'services/production/proizvodstvo-reklamnykh-konstruktsi'
        ];
        foreach ($array_of_urls as $url) {
            $output .= $this->generateTypeUnit($url);
        }

        $output .= $this->generateTypeOfDb('roads');
        $output .= $this->generateTypeOfDb('towns');
        $output .= $this->generateTypeOfDb('districts');

        $boards = $this->db->get('boards')->result();
        foreach ($boards as $board){
            if($this->inSitemap(site_url() . 'boards/' . $board->GID . '/')) {
                $output .= '<url>';
                $output .= "\n";
                $output .= '<loc>' . site_url() . 'boards/' . $board->GID . '/</loc>';
                $output .= "\n";
                $output .= $lastmod;
                $output .= "\n";
                $output .= '</url>';
                $output .= "\n";
            }
        }
        $output .= '</urlset>';

        if(file_put_contents('sitemap.xml', $output)){
            echo 1;
        }else{
            echo 0;
        }

    }

    private function generateTypeOfDb($type){
        $lastmod = '<lastmod>' . date('Y-m-d\TH:i:sP', time()) . '</lastmod>';
        $elements = $this->db->get($type)->result();
        $output = '';
        foreach ($elements as $element){
            if($this->inSitemap(site_url() . 'db/' . $type . '/' . $element->code . '/')){
                $output .= '<url>';
                $output .= "\n";
                $output .= '<loc>' . site_url() . 'db/' . $type . '/' . $element->code . '/</loc>';
                $output .= "\n";
                $output .= $lastmod;
                $output .= "\n";
                $output .= '</url>';
                $output .= "\n";
            }
        }
        return $output;
    }

    private function generateTypeUnit($type){
        $lastmod = '<lastmod>' . date('Y-m-d\TH:i:sP', time()) . '</lastmod>';
        if($this->inSitemap(site_url(). $type . '/')){
            $output = '<url>';
            $output .= "\n";
            $output .= '<loc>' . site_url() . $type . '/</loc>';
            $output .= "\n";
            $output .= $lastmod;
            $output .= "\n";
            $output .= '</url>';
            $output .= "\n";
        }else{
            $output = '';
        }
        return $output;
    }

    private function inSitemap($curent_url)
    {
        $this->load->helper('url');
        $sitemap = $this->db->select('value')->from('settings')->where('code', 'sitemap')->get()->result();
        $sitemap_arr = json_decode($sitemap[0]->value);

        foreach ($sitemap_arr as $url) {
            if (trim($curent_url) == trim($url)) {
                $sitemap = false;
                break;
            } else {
                $sitemap = true;
            }
        }
        return $sitemap;
    }
}