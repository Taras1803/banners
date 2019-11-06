<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/VM_Controller.php';

class Boards extends VM_Controller {

    function __construct(){

        parent::__construct();

        $this->load->model(['BoardsModel', 'SeoModel']);

    }

	public function index() {
        $get = $this->input->get();

        $districts = $this->db->order_by('name')->get('districts')->result();
        $roads     = $this->db->order_by('name')->get('roads')->result();
        $towns     = $this->db->order_by('name')->get('towns')->result();

        $output = [

            'types'   => $this->db->where('count > 0')->order_by('count DESC')->get('board_types')->result(),
            'districts' => $districts,
            'roads' => $roads,
            'towns' => $towns,

        ];

        // Получаем каноникал, во избежание левых ссылок
        $canon = $this->SeoModel->getCanonical($get, $output);

        // Формируем SEO
        $seo = $this->SeoModel->getSeoByParams($get);
        $output['h1'] = (isset($seo->h1)) ? $seo->h1 : 'Адресная программа';
        $output['text'] = (isset($seo->text)) ? $seo->text : '';
        $title = (isset($seo->title)) ? $seo->title : 'Карта рекламных конструкций';
        $desc = (isset($seo->description)) ? $seo->description : '';



        // Ссылки снизу страницы (когда выбран регион)
        $output['seo_links'] = $this->SeoModel->getSeoLinks($get);

        $this->view('boards/map', $output, [
            'title' => $title,
            'desc' => $desc,
            'canon' => $canon]);
	}

    public function detail($id = null, $code = null){

        if (!$id) show_404();

        $this->output->delete_cache();

        $this->db->select([

            'boards.*',
            'side.code',
            'side.id as side_id',
            'side.direction',
            'img.large as image',

            'd.name as d_name', 'd.code as d_code',
            't.name as t_name', 't.code as t_code',
            'r.name as r_name', 'r.code as r_code',

        ]);

        $this->db->from('boards');

        $this->db->join('board_sides side', 'boards.id = side.board_id', 'left');
        $this->db->join('files img','img.id = side.image_id', 'left');

        $this->db->where('boards.GID', $id);

        // Местоположение для перелинковки
        $this->db->join('districts d', 'boards.district_id = d.id', 'left');
        $this->db->join('towns t', 'boards.town_id = t.id', 'left');
        $this->db->join('roads r', 'boards.road_id = r.id', 'left');

        // Если выбрана сторона
        if( $code ) $this->db->where('side.code', $code);

        $board = $this->db->get()->first_row();


        if( empty($board) ) show_404();


        $board->type = $this->db->get_where('board_types', ['id' => $board->type])->first_row();

        $board->sides = $this->db->get_where('board_sides', ['board_id' => $board->id])->result();


        //добавляем свойства

        $this->db->select([
            'vals.value',
            'prop.name'
        ]);

        $this->db->from('board_prop_vals vals');

        $this->db->join('board_props prop', 'prop.code = vals.code', 'left');

        $this->db->where('vals.board_id', $board->id);

        $this->db->where('prop.show', 1);

        $board->props = $this->db->get()->result();

        // Меняем формат координат
        $board->coords_out = preg_split("/\s?,\s?/",$board->coordinates);

        // Share buttons
        $board->share = [
            'url' => 'http://vmoutdoor.ru' . explode('?',$_SERVER['REQUEST_URI'])[0],
            'title' => 'Рекламный объект Vostok-Media. ' . $board->type->name . ', номер #'.$board->GID,
            'img' => 'http://vmoutdoor.ru'.$board->image,
            'desc' => 'Наружная реклама от компании Восток-Медиа. ' . $board->type->name . ', номер #'.$board->GID
        ];

        // Доп. изображения
        $this->BoardsModel->getExtraImages($board);

        // Доп. объекты рядом
        $board->extra_objs = $this->BoardsModel->getExtraObjs($board);

        // Ссылка назад с сохранением фильтра
        $board->back_link = $this->BoardsModel->getBackLink();

        // SEO
        $b_name = $board->type->name.', номер #'.$board->GID;
        $dir = ($board->direction == 1) ? "Из Москвы" : "От Москвы";

        $this->view('boards/detail', $board, [
            'title' => $b_name.' — '.$board->address,
            'desc' => $b_name.' расположен по адресу '.$board->address.', в направлении '.$dir,
            'canon' => "/boards/detail/$id/",
            'noindex' => $board->noindex,
            'nofollow' => $board->nofollow

        ]);

    }



    public function get(){
        $q = (object) $this->input->post(); //получаем запрос

        $this->db->select(['boards.id','boards.GID','boards.coordinates','type.color'])
            ->from('boards')
            ->join('board_types type', 'type.id = boards.type', 'left')
            ->where('boards.active', 1);

        if( !empty( $q->keyword ) ){
            if( is_numeric($q->keyword)){
                $this->db->where('GID', $q->keyword);
            } else {
                $this->db->join('districts', 'districts.id = boards.district_id', 'left');
                $this->db->join('roads', 'roads.id = boards.road_id', 'left');
                $this->db->join('towns', 'towns.id = boards.town_id', 'left');

                $this->db->like('boards.address', $q->keyword);

                $this->db->or_like('districts.name',   $q->keyword);
                $this->db->or_like('roads.name',  $q->keyword);
                $this->db->or_like('towns.name',  $q->keyword);
            }
        }

        if( !empty( $q->type ) ) {
            $type_ids = $this->getIdsByCode("SELECT ID FROM board_types WHERE code IN ?", $q->type);
            $this->db->where_in('boards.type', $type_ids);
        }

        if( !empty( $q->district ) || !empty( $q->town ) || !empty( $q->road ) ){
            $this->db->group_start();

            if( !empty( $q->district ) ) {
                $district_ids = $this->getIdsByCode("SELECT ID FROM districts WHERE code IN ?", $q->district);
                $this->db->or_where_in('boards.district_id', $district_ids);
            }

            if( !empty( $q->town ) ) {
                $town_ids = $this->getIdsByCode("SELECT ID FROM towns WHERE code IN ?", $q->town);
                $this->db->or_where_in('boards.town_id', $town_ids);
            }

            if( !empty( $q->road ) ) {
                $roads_ids = $this->getIdsByCode("SELECT ID FROM roads WHERE code IN ?", $q->road);
                $this->db->or_where_in('boards.road_id', $roads_ids);
            }

            $this->db->group_end();
        }

        $boards = $this->db->get()->result();

        $seo = $this->SeoModel->getSeoByParamsPost($this->input->post());

        echo json_encode(['boards' => $boards, 'seo' => $seo]);
    }

    public function getForMap($board_id){

        //получаем щит

        $this->db->select('address');

        $this->db->where('id', $board_id);

        $board = $this->db->get('boards')->first_row();

        //получаем стороны

        $this->db->select([

            's.id',
            's.code',
            'f.small',
            'f.original'

        ]);

        $this->db->from('board_sides s')->where('s.board_id', $board_id);
        $this->db->join('files f', 's.image_id = f.id', 'left');
        $sides = $this->db->get()->result();

        foreach ($sides as $side) {
            $this->db->select('i.small,i.original')->from('extra_images as i')->where('i.side_id', $side->id);
            $side->extra_imgs = $this->db->get()->result();
        }


        echo json_encode([ 'sides' => $sides, 'board' => $board ]);

    }

    function getIdsByCode($query, $codes){

        $ids = [];

        $res = $this->db->query($query, array($codes))->result();

        foreach($res as $item) $ids[] = $item->ID;

        return $ids;

    }


    function getSearchHints(){

        $data = (object) $this->input->post();

        $hints = $this->BoardsModel->getHints($data->str);

        echo json_encode($hints);
    }


    function manualCompile(){

        require_once('libraries/lessc.inc.php');

        $less = new lessc;

        $less->compileFile("template/public/css/style.less", "template/public/css/style.css");

    }


}
