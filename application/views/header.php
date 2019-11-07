<?php

    require "libraries/lessc.inc.php";


    $less = new lessc;

    try {
      $less->checkedCompile(TEMPLATE_DIR . "/css/style.less", TEMPLATE_DIR . "/css/style.css");

        //die;
    } catch (exception $e) {
      echo "fatal error: " . $e->getMessage();
    }

//$favorites = new FavoritesModel;
//$favorites = $favorites->getSummary();

?>

<!DOCTYPE html>
<html lang="ru">
    <head>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
        
        <meta name="keywords" content="<?= get_option('meta_keywords'); ?>">

        <?php if (isset($seo['desc']) && $seo['desc']): ?>
            <meta name="description" content="<?= $seo['desc'] ?>">
        <?php else: ?>
            <meta name="description" content="<?= get_option('meta_description'); ?>">
        <?php endif; ?>


        <link rel="stylesheet" type="text/css" href="/libraries/public/css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/<?=TEMPLATE_DIR?>/css/style.css">
        
        <link rel="icon" href="/favicon.ico" type="image/x-icon" />

        <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,600&amp;subset=cyrillic" rel="stylesheet">
        <?php $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2); //echo $uri_parts[0]; ?>


        <script src="/libraries/public/js/jquery/jquery-2.2.4.min.js"></script>

        <script src="/<?=TEMPLATE_DIR?>/js/functions.js"></script>
        <script src="/<?=TEMPLATE_DIR?>/js/global.js"></script>

        <?php if(isset($seo['page']) && $seo['page'] >= 2 && isset($seo['canonical'])): ?>
            <link rel="canonical" href="<?= $seo['canonical'] ?>"/>
        <?php endif; ?>

        <?php if(isset($seo['noindex']) && $seo['noindex'] == 1): ?>
            <meta name="robots" content="noindex">
        <?php endif; ?>

        <?php if(isset($seo['nofollow']) && $seo['nofollow'] == 1): ?>
            <meta name="robots" content="nofollow">
        <?php endif; ?>


        <title>
            <?php
            if( !empty( $seo['title'] ))
                {
                    echo $seo['title'];
                }
            else
            {
                echo get_option('title');
            }
            ?>

        </title>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-72440853-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-72440853-1');
        </script>

    </head>
    <body>

        <div class="site">

            <div class="header-margin"></div>

            <header>

                <div class="container">

                   <div class="logo">
                       <a href="/"><img src="/<?=TEMPLATE_DIR?>/img/vm_logo.svg" alt="vm_logo"></a>
                   </div>

                   <div class="menu-bg hidden"></div>

                   <div class="top-menu">

                       <div class="close"></div>

                       <div class="menu-item">
                          
                           <span>О нас</span>
                           
                           <div class="dropdown submenu left">
                               
                               <a href="/news/">Новости</a>
                               <a href="/gallery/">Галерея</a>
                               <a href="/thanks/">Благодарности</a>
                               <a href="/partners/">Партнерства</a>
                               <a href="/charity/">Благотворительность</a>
                               
                           </div>
                           
                       </div>
                       <div class="menu-item">
                          
                           <span>Наружная реклама</span>
                           
                           <div class="dropdown submenu">
                               
                               <a href="/boards/">Карта конструкций</a>
                               <a href="/services/production/">Производство</a>
                               <a href="/services/montage/">Монтаж</a>
                               <a href="/services/design/">Дизайн</a>
                               <a href="/services/dorozhnye-ukazateli/">Дорожные указатели</a>
                               <a href="/services/ekspertiza-reklamnykh-konstruktsij/">Экспертиза конструкций</a>
                               <a href="/services/registratsiya-reklamy/">Регистрация рекламы</a>
                               
                           </div>
                           
                       </div>
                       <div class="menu-item"><a href="/digital/">Digital</a></div>
                       <div class="menu-item"><a href="/contacts/">Контакты</a></div>
                       <div class="menu-item">
                          
                           <a href="/favorites/" class="favorites">Избранное
                           
                               <div class="count"><?= $favorites['total'] ?></div>
                           
                           </a>
                           
                           <div class="dropdown fav-list">
                               
                                <?= $favorites['header'] ?>
                               
                           </div>
                           
                       </div>

                   </div>

                   <div class="menu-button visible-xs visible-sm"></div>

                   <div class="header-phone visible-lg">
                       <?= get_option('phone'); ?><br>
                       <span class="open-callback" onclick="callback('callme')">Заказать звонок</span>
                   </div>

                </div>

            </header>