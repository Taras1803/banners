<?php

    /**
     *  Simple PHP Site Monitor
     *  v.0.0.1
     *  @require php 5.5
     *
     *  @usage php monitor.php mail@domain.ru[,mail2@domain.ru,...] http://webhook.com/do[,http://webhook.com/do2..]
     *  @todo head/get requests
     *  @todo Message templates
     */

    # Setting time limit
    ini_set('max_execution_time', 0);

    # Setting current paths
    define('PATH',              dirname(__FILE__));
    define('PATH_LOG',          PATH . DIRECTORY_SEPARATOR . 'error.log');
    define('PATH_LIST',         PATH . DIRECTORY_SEPARATOR . 'server.list');
    define('PATH_EM_LIST',      PATH . DIRECTORY_SEPARATOR . 'emails.list');

    # Setting useragent
    define('USERAGENT',         'Monitoring Bot');

    # Setting request timeout
    define('TIMEOUT',           10);

    # Disable ECHO ?
    define('ECHO_OFF',          FALSE);

    # Init vars
    $servers                    = array();

    /**
     * Monitoring error callback function
     *
     * @param  array $log_arr information array
     * @param  string $result Request result
     * @return void
     */
    function    _callback($log_arr, $result)
    {
        global $argv;

        if ( ! function_exists('list2array') ) {
            function list2array($list)
            {
                $_array = array();

                if(strpos($list, ',') !== FALSE) {
                    $_array = array_map('trim', explode(',', $list));
                } else {
                    $_array[] = $list;
                }

                return $_array;

            }
        }

        try {

            $result_arr = array(
                'url'       => $log_arr['url'],
                'ip'        => $log_arr['primary_ip'],
                'http_code' => $log_arr['http_code'],
                'error'     => $log_arr['curl_error'],
                'time_ms'      => array(
                    'lookup'    => round(1000 * $log_arr['namelookup_time'], 2 ),
                    'connect'   => round(1000 * ($log_arr['connect_time']       - $log_arr['namelookup_time']), 2 ),
                    'ssl'       => round(1000 * ($log_arr['appconnect_time']    - $log_arr['connect_time']), 2 ),
                    //'redirect'  => round(1000 * $log_arr['redirect_time'], 2 ),
                    'request'   => round(1000 * ($log_arr['starttransfer_time'] - $log_arr['pretransfer_time']), 2 ),
                    'response'  => round(1000 * ($log_arr['total_time']         - $log_arr['starttransfer_time']), 2 ),
                    'total'     => round(1000 * $log_arr['total_time'], 2 )
                )
            );

            $_message = json_encode($result_arr, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            //$_message = var_export($result_arr, TRUE);
            //$_message = implode("\r\n", $result_arr);

            # Reading server list file
            $em_list                    = fopen(PATH_EM_LIST, 'r');

            if ( ! $em_list) {

                # If file read error - throw exception
                throw new Exception("File open error: " . PATH_EM_LIST, 1);

            } else {

                # Reading servers list to monitor
                # One per line
                while (($line = fgets($em_list)) !== false) {

                    $line           = trim($line);

                    /**
                     * Skip if #
                     */
                    if($line[0] != '#')
                        $emails[]  = $line;

                }

            }

            if( ! empty($emails))
            {
                //$emails = list2array($argv[1]);
                foreach ($emails as $key => $email) {
                 //   mail($email, "Упал сайт: " . $log_arr['url'], $_message);
                //    _echo("MAIL: $email");
                }
            }

            fopen('https://api.telegram.org/bot595730108:AAFjtmOw82R8FdxezNAnkUJAJyPxKGh_rkM/sendMessage?chat_id=@mrPingerBot&text=Упал сайт: ' . $log_arr['url'] . '', 'r');

            /* SMS Рассылка
            if( ! empty($argv[2]) ) {

                $webhooks = list2array($argv[2]);

                foreach ($webhooks as $key => $webhook) {

                    //$webhook = str_replace('###message###', $_message, $webhook);
                    $webhook = str_replace('###message###', urlencode($_message), $webhook);
                    $ch = curl_init($webhook);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                    $body = curl_exec($ch);
                    curl_close($ch);

                    _echo("WEBHOOK: $webhook");

                    # TODO: response checks !

                    usleep(1000000 / 2);
                }
            }*/


        } catch (Exception $e) {

            _echo($e->getMessage());

        }
    }

    /**
     * Monitoring error log function
     *
     * @param  array $log_arr information array
     * @return void
     */
    function    _log($log_arr, $result)
    {
        if( ! is_array($log_arr))
            return;

        $fp_log                  = @fopen(PATH_LOG, 'a+');

        if( ! $fp_log)
            return;

        $result_arr             = array(
            date("Y.m.d H:i:s"),
            $log_arr['url'],
            $log_arr['primary_ip'],
            $log_arr['http_code'],
            $log_arr['total_time'],
            $log_arr['curl_error']

        );

        $result_str             = implode("\t", $result_arr) . PHP_EOL;

        @fwrite($fp_log, $result_str);
        @fclose($fp_log);
    }

    function    _echo($str)
    {
        if(ECHO_OFF == FALSE)
            echo $str . PHP_EOL;
    }


    # Starting
    _echo(date("Y.m.d H:i:s").'<br>');

    # Reading server list file
    $fp_list                    = fopen(PATH_LIST, 'r');

    if ( ! $fp_list) {

        # If file read error - throw exception
        throw new Exception("File open error: " . PATH_LIST, 1);

    } else {

        # Reading servers list to monitor
        # One per line
        while (($line = fgets($fp_list)) !== false) {

            $line           = trim($line);

            /**
             * Skip if #
             */
            if($line[0] != '#')
                $servers[]  = $line;

        }

    }
       // 1 минута    60 секунд
       // 1 час   3600 секунд
       // 1 день  86400 секунд
       // 1 неделя    604800 секунд
       // 1 месяц (30.44 дней)    2629743 секунд
       // 1 год (365.24 дней)      31556926 секунд


        echo $today = time();

      /*  $date = file_get_contents('https://api.hackertarget.com/whois/?q=rudocs.org');
        $ddd = explode("\n", $date);
        echo '<pre>';
        //var_dump($ddd);
       // $key = array_search('free-date', $ddd);
        if(preg_grep("/free-date/", $ddd)) {
            $fl_array = preg_grep("/free-date/", $ddd);
        } else {
            $fl_array = preg_grep("/Registry Expiry Date/", $ddd);
        }

        $fl_array = implode("", $fl_array);
        $fl_array = preg_replace("/\s+/", "", $fl_array);

        var_dump($fl_array);
        $xpiry = explode("te:", $fl_array);
        $info_time = strtotime($xpiry[1]) - 604800; // 1 неделя 
        if($info_time <= $today) {
            echo 'Оплачивай бля';
        }
        echo '</pre>';*/
 echo '<pre>';
 $i=0;
    foreach ($servers as $id => $server) {
        $date = file_get_contents('https://api.hackertarget.com/whois/?q='.$server);
        $ddd = explode("\n", $date);
        var_dump($ddd);
       // $key = array_search('free-date', $ddd);
        if(preg_grep("/free-date/", $ddd)) {
            $fl_array = preg_grep("/free-date/", $ddd);
        } else {
            $fl_array = preg_grep("/Registry Expiry Date/", $ddd);
        }
        $fl_array = implode("", $fl_array);
        $fl_array = preg_replace("/\s+/", "", $fl_array);
        var_dump($fl_array);
        $xpiry = explode("te:", $fl_array);
        $info_time = strtotime($xpiry[1]) - 604800; // 1 неделя 
        if($info_time <= $today) {
            echo 'Оплачивай бля: '.$server;
           // fopen('https://api.telegram.org/bot595730108:AAFjtmOw82R8FdxezNAnkUJAJyPxKGh_rkM/sendMessage?chat_id=@mrPingerBot&text=Не забудь оплатить домен: ' . $server . '', 'r');
        }
        //Проверка регистрации домера неделя до окончания
        sleep(2);
        echo $i; 
        $i++;
    }
echo '</pre>';
    _echo(date("Y.m.d H:i:s"));
?>
