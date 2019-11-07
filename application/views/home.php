<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

  <div class="main-wheat">
       
       <div class="overlay">

           <div class="content-circle">

               <div class="content__logo">
                   <img src="/<?=TEMPLATE_DIR?>/img/vm_big.svg" class="vm-big" alt="vm_big">
               </div>

               <div class="content__text">
                   <img src="/<?=TEMPLATE_DIR?>/img/vm_descript.svg" class="vm-name" alt="vm_descript">
                   <div class="operator">Оператор наружной рекламы</div>
                   <a class="yellow-btn" href="/boards/">Адресная программа</a>
               </div>

           </div>

       </div>
       
       <video class="video-bg" src="" autoplay loop></video>

    </div>

    <!--<div class="main-h">
        <div class="container">
            <h1>Наружная реклама от компании Восток-Медиа</h1>
        </div>
    </div>-->


    <div class="black-header">

        <div class="line yellow"></div>

        <h2><span class="yellow">Типы конструкций</span></h2>

    </div>

    <div class="container">
        <div id="index-types">
            <div>
                <a href="/boards/?type=Schit_3x6">
                    <h6>Щиты 3х6</h6>
                    <div class="index-type-content clearfix">
                        <div class="index-type-ico"></div>
                        <p>Билборды разных типов и размеров со статичным информационным полем или поворотными модулями Trivision, двух-трехсторонние и V-образные суперсайты с подсветкой, рекламные заборы, арки, дибонды;</p>
                    </div>
                </a>
            </div>
            <div>
                <a href="/boards/#type=Schit_5x15,Schit_4x12,Schit_5x12">
                    <h6>Суперсайты</h6>
                    <div class="index-type-content clearfix">
                        <div class="index-type-ico"></div>
                        <p>Транспаранты, растяжки для мостов, брандмауэры, вымпелы для столбов и фонарей и др.;</p>
                    </div>
                </a>
            </div>
            <div>
                <a href="/boards/?type=Siti-format">
                    <h6>Сити форматы</h6>
                    <div class="index-type-content clearfix">
                        <div class="index-type-ico"></div>
                        <p>Постеры и скроллеры, стелы, штендеры, пилоны;</p>
                    </div>
                </a>
            </div>
            <div>
                <a href="/boards/?type=Ostanovka">
                    <h6>Остановочные павильоны</h6>
                    <div class="index-type-content clearfix">
                        <div class="index-type-ico"></div>
                        <p>Заказывайте стандартные или креативные макеты </p>
                    </div>
                </a>
            </div>
            <div>
                <a href="/boards/">
                    <h6>Динамические РК</h6>
                    <div class="index-type-content clearfix">
                        <div class="index-type-ico"></div>
                        <p>Световые короба и объемные буквы</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="black-header">

        <div class="line yellow"></div>

        <h2><span class="yellow">Видео о нас</span></h2>

    </div>

    <div id="index-video">
        <iframe width="800" height="450" src="https://www.youtube.com/embed/afvW5TjBzes" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>

    <div class="black-header">

       <div class="line yellow"></div>

       <h2><span class="yellow">Наши постоянные клиенты:</span></h2>

    </div>

    <div class="clients">

       <div class="track">

            <?php foreach( scandir(TEMPLATE_DIR . '/img/clients') as $file ): ?>

                <?php if( is_file(TEMPLATE_DIR . '/img/clients/' . $file) ) : ?>
                    
                    <div class="client">

                       <img src="/<?= TEMPLATE_DIR ?>/img/clients/<?= $file ?>" alt="file">

                    </div>

                <?php endif; ?>

            <?php endforeach; ?>

        </div>

    </div>

    <div class="features">

        <div class="container">

            <div class="line"></div>

            <div id="about-menu-wrap">

                <h1>Наружная реклама от компании Восток-Медиа</h1>

                <div id="about-menu">
                    <div class="active">О нас</div>
                    <div>Наша миссия</div>
                    <div>Философия</div>
                    <div>Услуги</div>
                </div>
                <div id="about-content">
                    <div class="active">
                        <p>Наше агентство специализируется на предоставлении услуг по аренде рекламных конструкций в Московской области. Мы располагаем большим числом рекламных графических площадей, которые расположены в самых массовых местах. Мы обладаем устойчивой и стабильной рыночной репутацией, о чем говорят многочисленные положительные отзывы клиентов.</p>
                        <p>Наш штат сотрудников состоит из квалифицированных специалистов, которые отличаются большим и емким практическим опытом в сфере маркетинга. Они смогут подобрать наиболее эффективные рекламные площади для вашей рекламной кампании. Мы всегда слушаем ваши текущие потребности и пожелания, что позволяет сделать информацию по вашему коммерческому предложению более заметной и узнаваемой. Наружная реклама является двигателем любого бизнеса и является залогом успешного развития.</p>
                    </div>
                    <div>
                        <p>При осуществлении своей деятельности мы руководствуемся принципами здоровой конкурентной борьбы, а также стремимся сделать существующий рынок рекламы в Московском регионе более цивилизованным и структурированным. Мы сотрудничаем с большим числом предприятий, а также регулярно принимаем участие в благотворительности. Наружная реклама является не только способом привлечения клиентов, но и средством массовой информации.</p>
                        <p>Такие особенности позволили нам добиться высоких финальных результатов при выполнении своей работы по предоставлению рекламных площадей и изготовлению наружной рекламы. Регулярно мы получаем огромное число благодарностей от различных структур, потому что мы знаем и понимаем свою работу, и всегда достигаем намеченных вами показателей и поставленных целей.</p>
                    </div>
                    <div>
                        <p>Наша философия строится на простых принципах постоянного развития. Мы не стоим на месте, а движемся вперед. Такие ценности касаются не только компании, но и ее сотрудников. Каждый вносит свой вклад для достижения высокого результата. Мы стремимся сегодня быть лучше, чем вчера, а завтра мы будем лучше, чем сегодня. Исходные принципы помогают нам развиваться, а вместе с этим развивать весь маркетинговый рынок, что находит свое отражение в стабильном повышении качества предоставляемых услуг.</p>
                        <p>Мы ценим и уважаем своих партнеров, а также ценим и уважаем ваших клиентов, поэтому наша философия является основополагающим инструментом для достижения успеха всех участников рекламного рынка Московской области.</p>
                    </div>
                    <div>
                        <p>Оператор «Восток-Медиа» предоставляет услуги по размещению наружной рекламы. Также мы самостоятельно осуществляем производство наружной рекламы, на основе предоставленных исходных данных. Мы располагаем большим числом эффективных рабочих инструментов, которые позволяют нам делать качественный продукт. Производственная материально-техническая база нашей компании позволяет изготовить щиты, баннеры, остановочные павильоны, вывески и многое другое.</p>
                        <p>Подбор наиболее подходящего рекламного места – это трудоемкий и творческий процесс, который требует креативности и неординарности от исполнителей. Чтобы заказать наружную рекламу для своей компании вы можете обратиться к нам, где квалифицированный оператор развернуто и полноценно ответит на все ваши вопросы. Мы всегда учитываем ваши потребности, что помогает осуществить поиск наиболее эффективного места расположения вашей рекламы.</p>
                    </div>
                </div>
            </div>

            <h2>Наши преимущества:</h2>

            <div id="features-wrap">

                <div>

                    <div class="feature">

                        <img src="/<?=TEMPLATE_DIR?>/img/features/ohvat.svg" alt="ohvat">

                        <p>Абсолютный<br> охват территорий</p>

                        <span>Нам легко конкурировать с другими компаниями  за счет  огромного охвата поверхностей</span>

                    </div>

                </div>

                <div>

                    <div class="feature">

                        <img src="/<?=TEMPLATE_DIR?>/img/features/baing.svg" alt="baing">

                        <p>Баинговые<br> возможности</p>

                        <span>Наша компания имеет широкие баинговые возможности - мы размещаем наружную рекламу на различных поверхностях</span>

                    </div>

                </div>

                <div>

                    <div class="feature">

                        <img src="/<?=TEMPLATE_DIR?>/img/features/all.svg" alt="all">

                        <p>Полный цикл<br> работ</p>

                        <span>Мы - агенство полного цикла, мы сами выполняем заказы и можем предложить нашим клиентам услуги по выгодным ценам</span>

                    </div>

                </div>

                <div>

                    <div class="feature">

                        <img src="/<?=TEMPLATE_DIR?>/img/features/original.svg" alt="original">

                        <p>Оригинальные<br> конструкции</p>

                        <span>Мы организуем заказы по различным оригинальным и креативным макетам</span>

                    </div>

                </div>

                <div>

                    <div class="feature">

                        <img src="/<?=TEMPLATE_DIR?>/img/features/comanda.svg" alt="comanda">

                        <p>Опытные<br> специалисты</p>

                        <span>Залог успеха нашей компании- сплоченная профессиональная команда, нацеленная на реальный результат</span>

                    </div>

                </div>

                <!--
                    <div class="col-xs-6 col-sm-4 col-md-2">

                        <div class="feature">

                            <img src="/<?=TEMPLATE_DIR?>/img/features/indiv.svg">

                            <p>Индивидуальный<br>подход</p>

                        </div>

                    </div>
                    -->

            </div>

        </div>

    </div>
    
    <script>
        
        //загрузка видео, если у устройства большой экран

        $(window).on('load resize', function(e){
            
            var video = $('.video-bg');
            
            var src = video.attr('src');
            
            if( $(this).width() > 992 && !src ){
            
                video.attr('src', '/videos/wheat.mp4');

                video.on('loadeddata', function(){
                    
                    $(window).off('resize');
                    
                    //центруем и подгоняем размер при изменении размера экрана
                    
                    var natW = video[0].videoWidth;
                    var natH = video[0].videoHeight;

                    var scale = natH / natW;

                    var container = video.parent();
                    
                    var resize = function(){

                        var contW = container.width();
                        var contH = container.height();

                        if( contW * scale > contH ){
                            
                            var width  = contW;
                            var height = contW * scale;

                        } else {
                            
                            var width  = contH / scale;
                            var height = contH;

                        }
                        
                        video.css('height', height).css('width', width);
                        
                        video.css('margin-top',  (contH - height) / 2);
                        video.css('margin-left', (contW - width)  / 2);
                        
                    }
                                  
                    resize();
                    
                    $(window).on('resize', resize);

                });
                
            }
            
        });

    </script>