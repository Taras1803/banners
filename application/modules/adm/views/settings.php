<div class="row">
    <div class="col-md-12">
       
        <form action="" enctype="multipart/form-data" method="post">
        
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-pencil"></i>
                    <a href="/" target="_blank">Настройки сайта</a>
                </div>
                <div class="buttons-set pull-right">
                    <button class="btn save">Сохранить</button>
                </div>
            </div>
            
            <ul class="form-tabs">

                <li>
                    <a href="#tab_general" data-tab> Основное </a>
                </li>
                <li>
                    <a href="#tab_password" data-tab>Администратор</a>
                </li>

            </ul>
            
            <div class="portlet-body">
   
                <div class="tab-content">
                   
                    <div class="tab-pane" id="tab_general">
                       
                        <div class="form-body">
                            
                            <?php foreach( $settings as $setting ): ?>

                                <div class="form-group">

                                    <label class="control-label col-xs-2"><?= $setting->name ?></label>

                                    <div class="col-xs-6">
                                        
                                        <?php switch ( $setting->type ):

                                            case 2: ?>

                                                <textarea rows="5" class="form-control" name="settings[<?= $setting->code ?>]"><?= $setting->value ?></textarea>

                                            <?php break;

                                            default: ?>

                                                <input type="text" class="form-control" name="settings[<?= $setting->code ?>]" value="<?= $setting->value ?>">

                                            <?php break;


                                        endswitch; ?>

                                    </div>
                                    
                                </div>
                            
                            <?php endforeach; ?>

                            <div class="form-group">
                                <label class="control-label col-xs-2"> robots.txt </label>
                                <div class="col-xs-6">
                                    <textarea rows="5" class="form-control" name="robots"><?= $robots ?></textarea>
                                </div>
                            </div>

                        </div>
                        
                    </div>
                    
                    <div class="tab-pane" id="tab_password">
                       
                        <div class="form-body">
                            
                            <?php foreach( $errors as $error ): ?>
                            
                                <div class="error-message">
                                    <?= $error ?>
                                </div>
                            
                            <?php endforeach; ?>
                            
                            <div class="form-group">
                                <label class="control-label col-xs-2">Логин</label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" name="login" value="<?= $user->login ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-xs-2">E-mail</label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" name="email" value="<?= $user->email ?>">
                                </div>
                            </div>
                            
                            <br>

                            <div class="form-group">
                                <label class="control-label col-xs-2">Старый пароль</label>
                                <div class="col-xs-6">
                                    <input type="password" class="form-control" name="old_password" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-2">Новый пароль</label>
                                <div class="col-xs-6">
                                    <input type="password" class="form-control" name="new_password" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-2">Повторите пароль</label>
                                <div class="col-xs-6">
                                    <input type="password" class="form-control" name="repeat_password" value="">
                                </div>
                            </div>

                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
            
            <div class="buttons-set bottom">
                <button class="btn save save">Сохранить</button>
            </div>
            
        </div>
        <?= form_close() ?>
    </div>
</div>

<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>

<script src="/libraries/admin/js/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

<script src="/template/admin/js/boards-edit.js" type="text/javascript"></script>
