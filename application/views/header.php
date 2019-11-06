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
    <link rel="canonical" href="<?= $seo['canonical'] ?>" />
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
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'UA-72440853-1');
    </script>

</head>

<body>

    <div class="site">

        <div class="header-margin"></div>

        <header>

            <div class="container mob-w">

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
                    <!--                       <div class="menu-item"><a href="/digital/">Digital</a></div>-->
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



                <div class="mob-bg">

                    <div class="menu-button visible-xs visible-sm"></div>

                    <div class="header-phone visible-lg">

                        <div class="header-phone-btns">
                            <div class="header-phone-btn">
                                <span class="open-callback" onclick="callback('callme')">

                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                        viewBox="0 0 482.6 482.6" width="20px" height="20px"
                                        style="enable-background:new 0 0 482.6 482.6;" xml:space="preserve">
                                        <g>
                                            <path d="M98.339,320.8c47.6,56.9,104.9,101.7,170.3,133.4c24.9,11.8,58.2,25.8,95.3,28.2c2.3,0.1,4.5,0.2,6.8,0.2
                                        c24.9,0,44.9-8.6,61.2-26.3c0.1-0.1,0.3-0.3,0.4-0.5c5.8-7,12.4-13.3,19.3-20c4.7-4.5,9.5-9.2,14.1-14
                                        c21.3-22.2,21.3-50.4-0.2-71.9l-60.1-60.1c-10.2-10.6-22.4-16.2-35.2-16.2c-12.8,0-25.1,5.6-35.6,16.1l-35.8,35.8
                                        c-3.3-1.9-6.7-3.6-9.9-5.2c-4-2-7.7-3.9-11-6c-32.6-20.7-62.2-47.7-90.5-82.4c-14.3-18.1-23.9-33.3-30.6-48.8
                                        c9.4-8.5,18.2-17.4,26.7-26.1c3-3.1,6.1-6.2,9.2-9.3c10.8-10.8,16.6-23.3,16.6-36s-5.7-25.2-16.6-36l-29.8-29.8
                                        c-3.5-3.5-6.8-6.9-10.2-10.4c-6.6-6.8-13.5-13.8-20.3-20.1c-10.3-10.1-22.4-15.4-35.2-15.4c-12.7,0-24.9,5.3-35.6,15.5l-37.4,37.4
                                        c-13.6,13.6-21.3,30.1-22.9,49.2c-1.9,23.9,2.5,49.3,13.9,80C32.739,229.6,59.139,273.7,98.339,320.8z M25.739,104.2
                                        c1.2-13.3,6.3-24.4,15.9-34l37.2-37.2c5.8-5.6,12.2-8.5,18.4-8.5c6.1,0,12.3,2.9,18,8.7c6.7,6.2,13,12.7,19.8,19.6
                                        c3.4,3.5,6.9,7,10.4,10.6l29.8,29.8c6.2,6.2,9.4,12.5,9.4,18.7s-3.2,12.5-9.4,18.7c-3.1,3.1-6.2,6.3-9.3,9.4
                                        c-9.3,9.4-18,18.3-27.6,26.8c-0.2,0.2-0.3,0.3-0.5,0.5c-8.3,8.3-7,16.2-5,22.2c0.1,0.3,0.2,0.5,0.3,0.8
                                        c7.7,18.5,18.4,36.1,35.1,57.1c30,37,61.6,65.7,96.4,87.8c4.3,2.8,8.9,5,13.2,7.2c4,2,7.7,3.9,11,6c0.4,0.2,0.7,0.4,1.1,0.6
                                        c3.3,1.7,6.5,2.5,9.7,2.5c8,0,13.2-5.1,14.9-6.8l37.4-37.4c5.8-5.8,12.1-8.9,18.3-8.9c7.6,0,13.8,4.7,17.7,8.9l60.3,60.2
                                        c12,12,11.9,25-0.3,37.7c-4.2,4.5-8.6,8.8-13.3,13.3c-7,6.8-14.3,13.8-20.9,21.7c-11.5,12.4-25.2,18.2-42.9,18.2
                                        c-1.7,0-3.5-0.1-5.2-0.2c-32.8-2.1-63.3-14.9-86.2-25.8c-62.2-30.1-116.8-72.8-162.1-127c-37.3-44.9-62.4-86.7-79-131.5
                                        C28.039,146.4,24.139,124.3,25.739,104.2z" />
                                    </svg>

                                </span>

                            </div>

                            <div class="header-phone-btn">
                                <span class="open-callback" onclick="callback('emailme')">

                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                                        width="20px" height="20px" style="enable-background:new 0 0 512 512;"
                                        xml:space="preserve">
                                        <path
                                            d="M467,61H45C20.218,61,0,81.196,0,106v300c0,24.72,20.128,45,45,45h422c24.72,0,45-20.128,45-45V106 C512,81.28,491.872,61,467,61z M460.786,91L256.954,294.833L51.359,91H460.786z M30,399.788V112.069l144.479,143.24L30,399.788z M51.213,421l144.57-144.57l50.657,50.222c5.864,5.814,15.327,5.795,21.167-0.046L317,277.213L460.787,421H51.213z M482,399.787 L338.213,256L482,112.212V399.787z" />
                                    </svg>

                                </span>
                            </div>
                        </div>



                        <div class="header-phone-tel">
                            <span class="header-phone-text">
                                <?= get_option('phone'); ?><br>
                            </span>
                            <span class="header-email-bordered">
                                <?= get_option('email'); ?>
                            </span>

                        </div>


                    </div>
                </div>

            </div>

        </header>