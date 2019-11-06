

<!DOCTYPE html>
<html lang="en">

    <head>
       
        <meta charset="utf-8"/>
        
        <title>VM Admin Panel</title>
        
        <!--Шрифты и иконки-->
        
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
        <link href="/libraries/admin/css/font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        
        <link rel="icon" href="/favicon.ico" type="image/x-icon" />
        
        <!-- Bootstrap -->
        
        <link href="/libraries/admin/js/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css">
        <link href="/libraries/admin/css/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css">

        <!-- jQuery & jQuery UI-->
       
        <script src="/libraries/admin/js/jquery/jquery-3.1.1.min.js" type="text/javascript"></script>
        <script src="/libraries/admin/js/jquery/jquery-ui.1.10.4.min.js" type="text/javascript"></script>
        
        <!-- Основные стили и JS -->
        
        <link href="/template/admin/css/admin-styles.css" rel="stylesheet" type="text/css"/>
        <script src="/template/admin/js/admin-global.js" type="text/javascript"></script>

    </head>
    
    <body>
       
        <div class="site">
            
            <header>

                <div class="logo">
                    Панель управления <a href="/" target="_blank"><b>Восток-Медиа</b></a>
                </div>

                <div class="logout">

                    <i class="fa fa-user"></i>&#160; <?= $this->user_info->login ?>, <a href="<?= ADMIN_PAGE_PATH ?>logout/">выйти</a>

                </div>

            </header>

            <div class="container-fluid">

                <div class="page-sidebar-wrapper">

                    <div class="page-sidebar">

                        <ul class="page-sidebar-menu">

                            <li <?php if ( $this->uri->segment(2) == "boards" && !$this->uri->segment(3)): ?> class="active"<?php endif; ?>>
                                <a href="<?=ADMIN_PAGE_PATH?>boards/">
                                    <i class="fa fa-building-o"></i>
                                    <span class="title">&#160; Конструкции</span>
                                </a>
                            </li>
                            
                            <li <?php if ( $this->uri->segment(2) == "settings" ): ?> class="active"<?php endif; ?>>
                                <a href="<?= ADMIN_PAGE_PATH ?>settings/">
                                    <i class="fa fa-gear"></i>
                                    <span class="title">&#160; Настройки</span>
                                </a>
                            </li>

                            <li <?php if ( $this->uri->segment(2) == "boards" && $this->uri->segment(3) == "uploadCsvSeo" ): ?> class="active"<?php endif; ?>>
                                <a href="<?=ADMIN_PAGE_PATH?>boards/uploadCsvSeo/">
                                    <i class="fa fa-gear"></i>
                                    <span class="title">&#160; SEO-настройки</span>
                                </a>
                            </li>

                            <li <?php if ( $this->uri->segment(2) == "sitemap" ): ?> class="active"<?php endif; ?>>
                                <a href="<?=ADMIN_PAGE_PATH?>sitemap/">
                                    <i class="fa fa-gear"></i>
                                    <span class="title">&#160; Sitemap </span>
                                </a>
                            </li>

                            <li <?php if ( $this->uri->segment(2) == "category"): ?> class="active"<?php endif; ?>>
                                <a href="<?= ADMIN_PAGE_PATH ?>category/">
                                    <i class="fa fa-newspaper-o"></i>
                                    <span class="title">&#160; Категории</span>
                                </a>
                            </li>

                            <li <?php if ( $this->uri->segment(2) == "infounits" ): ?> class="active"<?php endif; ?>>

                                <div class="add-new"><a href="<?= ADMIN_PAGE_PATH ?>infounits/add/">+</a></div>

                                <a href="javascript:;" class="open-menu">
                                    <i class="fa fa-newspaper-o"></i>
                                    <span class="title">&#160; Инфоблоки</span>
                                </a>

                                <ul class="sub-menu">

                                  <?php  $IUs = $this->db->get('infounits')->result();  ?>

                                   <?php foreach ( $IUs as $unit ) : ?>

                                        <li<?php if ( $this->input->get('infounit_id') == $unit->id ): ?> class="active"<?php endif; ?>>

                                            <a href="<?= ADMIN_PAGE_PATH ?>infounits/?infounit_id=<?= $unit->id ?>"><?= $unit->name ?></a>

                                        </li>

                                    <?php endforeach; ?>

                                </ul>
                            </li>

                        </ul>
                        <!-- END SIDEBAR MENU -->
                    </div>
                </div>
                <!-- END SIDEBAR -->
                <div class="page-content-wrapper">
                    <div class="page-content">