<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/controllers/VM_Controller.php';

class Email extends VM_Controller {
    
    function __construct(){
     
        parent::__construct();
        
        $this->load->libraries(['email']);
        
        $user = $this->db->get('users')->first_row();
        
        $this->to = explode(',', $user->email);
        
    }
    
    public $to;
    
    public $email_config = [
        
        'mailtype' => 'html'
        
    ];

	function quickorder() {
         
        $name    = $this->input->post('name');
        $phone   = $this->input->post('phone');
        $side_id = $this->input->post('side_id');
        
        $this->load->model('FavoritesModel');
        
        $board = $this->FavoritesModel->getById($side_id);

        if ( empty($name) || empty($phone) || !$board ) {

            die('0');

        }
        
                
        $this->email->initialize($this->email_config);

        $this->email->from('vmoutdoor', 'Заказ конструкции');
        $this->email->to($this->to);

        $this->email->subject("vmoutdoor.ru заказ конструкции");

        $msg = "<h3>vmoutdoor.ru заказ конструкции</h3><p>Имя: $name</p><p>Телефон: $phone</p><p>Номер: $board->GID $board->code</p>";

        $this->email->message($msg);

        $this->email->send();

        echo "Наш менеджер свяжется с вами в ближайшее время!";
        
    }
    
	function order() {
         
        $name    = $this->input->post('name');
        $phone   = $this->input->post('phone');
        
        $this->load->model('FavoritesModel');
        
        $boards = $this->FavoritesModel->getList();

        if ( empty($name) || empty($phone) || empty($boards) ) {

            die('0');

        }
        
        $this->email->initialize($this->email_config);

        $this->email->from('vmoutdoor', 'Заказ конструкций');
        $this->email->to($this->to);

        $this->email->subject("vmoutdoor.ru заказ конструкции");

        $html = $this->load->view('email/order', [
            
            'boards' => $boards, 
            'name' => $name, 
            'phone' => $phone
        
        ], 1);

        $this->email->message($html);

        $this->email->send();
        
        $this->FavoritesModel->clear();

        echo "Наш менеджер свяжется с вами в ближайшее время!";
        
    }
    
	function subscribe() {

        $possible_goals = ['news_update', 'map_update'];
        
        $post = $this->input->post();
        
        $email = $post['email'];

        $goal = $post['goal'];

        // Если цель разрешена
        if (!$goal || array_search($goal, $possible_goals) === false) return;

        // Формат почты
        if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ){
            echo "Не правильный формат электронной почты";
            return;
        }


        $exists = $this->db->get_where('subscribe', ['email' => $email])->first_row();


        // Подписка на карту
        if ($goal == 'map_update') {

            if (!$exists) {

                $this->db->insert('subscribe', ['email' => $email, 'map_update' => 1]);
                echo $this->subscribeNotify($goal, $email);
                echo "Вы успешно подписаны на обновление адресной программы";

            } elseif($exists->map_update == 1){

                echo "Вы уже подписаны на обновление адресной программы";

            } else {

                $this->db->set('map_update', 1)->where('email', $email)->update('subscribe');
                echo $this->subscribeNotify($goal, $email);
                echo "Вы успешно подписаны на обновление адресной программы";

            }
        }


        // Подписка на новости
        if ($goal == 'news_update'){

            if( !$exists ){

                $this->db->insert('subscribe', ['email' => $email, 'news_update' => 1]);
                echo $this->subscribeNotify($goal, $email);
                echo "Вы успешно подписаны на обновление новостей";

            } elseif ($exists->news_update == 1) {

                echo "Вы уже подписаны на обновление новостей";

            } else {

                $this->db->set('news_update', 1)->where('email', $email)->update('subscribe');
                echo $this->subscribeNotify($goal, $email);
                echo "Вы успешно подписаны на обновление новостей";

            }
        }
        
    }
    
	function work() {

        $name  = $this->input->post('name');
        $phone = $this->input->post('phone');

        if ( empty($name) || empty($phone) ) {

            die('0');

        }
        
        $this->email->initialize($this->email_config);

        $this->email->from('vmoutdoor', 'Заявка на работу');
        $this->email->to($this->to);

        $this->email->subject("vmoutdoor.ru заявка на работу");

        $msg = "<h3>У нас хочет работать</h3><p>Имя: $name</p><p>Телефон: $phone</p>";

        $this->email->message($msg);

        $this->email->send();

        echo "Наш менеджер свяжется с вами в ближайшее время!";
        
    }
    
	function callme() {

        $name  = $this->input->post('name');
        $phone = $this->input->post('phone');

        if ( empty($name) || empty($phone) ) {

            die('0');

        }
        
        $this->email->initialize($this->email_config);

        $this->email->from('vmoutdoor', 'Заявка на звонок');
        $this->email->to($this->to);

        $this->email->subject("vmoutdoor.ru заявка на звонок");

        $msg = "<h3>Оставлена заявка на звонок</h3><p>Имя: $name</p><p>Телефон: $phone</p>";

        $this->email->message($msg);

        $this->email->send();

        echo "Наш менеджер свяжется с вами в ближайшее время!";
        
    }


    function subscribeNotify($type,$email){

        $this->email->initialize($this->email_config);

        $this->email->from('vmoutdoor', 'Vmoutdoor: подписка на обновление');

        $this->email->to($this->to);

        if ($type == 'map_update'){

            $this->email->subject("Vmoutdoor: подписка на обновление адресной программы");
            $msg = "<h3>Vmoutdoor.ru подписка на обновление адресной программы</h3><p>Email: $email</p>";

        } elseif ($type == 'news_update'){

            $this->email->subject("Vmoutdoor: подписка на обновление новостей");
            $msg = "<h3>Vmoutdoor.ru подписка на обновление новостей</h3><p>Email: $email</p>";

        } else return 0;


        $this->email->message($msg);

        return $this->email->send();
    }
    
    
}
