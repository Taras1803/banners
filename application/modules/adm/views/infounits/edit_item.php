<form action="" enctype="multipart/form-data" method="post">

    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">
                <span> <?= $item->name ?></span>
            </div>

            <div class="buttons-set pull-right">

                <button class="btn save">Сохранить</button>
                <a href="<?= ADMIN_PAGE_PATH ?>infounits/add_item/<?= $item->infounit_id ?>/" class="btn">Добавить еще</a>
                <a href="<?= ADMIN_PAGE_PATH ?>infounits/?infounit_id=<?= $item->infounit_id ?>/" class="btn">Назад</a>

            </div>

        </div>

        <ul class="form-tabs">

            <li><a href="#tab_general" data-tab> Основное </a></li>
            <li><a href="#tab_content" data-tab> Контент </a></li>

        </ul>

        <div class="portlet-body">

            <div class="tab-content">

                <div class="tab-pane" id="tab_general">

                    <div class="form-body form-horizontal">

                        <div class="form-group">
                            <label class="control-label col-xs-2">Название</label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control"  name="name" value="<?= $item->name ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-2">ЧПУ страницы</label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control" name="url" value="<?= $item->url ?>">
                            </div>
                        </div>

                        <!--<div class="form-group">
                            <label class="control-label col-xs-2">Отображать в сайтмап </label>
                            <div class="col-xs-6">
                                <select class="form-control input-sm input-inline" name="sitemap">
                                    <option value="1" <?php if($item->sitemap == 1): ?>selected<?php endif; ?>>Включить в sitemap</option>
                                    <option value="0" <?php if($item->sitemap == 0): ?>selected<?php endif; ?>>Убрать из sitemap</option>
                                </select>
                            </div>
                        </div>-->

                        <div class="form-group">
                            <label class="control-label col-xs-2">Категория</label>
                            <div class="col-xs-3">
                                <select class="form-control" name="category">

                                    <option value="0">Без категории</option>

                                    <? foreach( $cats as $cat): ?>

                                        <option <?= set_selected_val($cat->id, $item->category) ?> value="<?= $cat->id ?>">

                                            <?= str_repeat('&nbsp;', $cat->level * 3) . $cat->name ?>

                                        </option>

                                    <? endforeach; ?>

                                </select>
                            </div>
                            <div class="col-xs-7">
                                <a class="btn dark add-prop" href="<?= ADMIN_PAGE_PATH ?>infounits/settings/<?= $item->infounit_id ?>/#tab_categories">Настроить</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-2">Изображение</label>
                            <div class="col-xs-10">
                                <div class="fileinput <?php if(empty($item->image)):?>fileinput-new<?php  else:?>fileinput-exists<?php endif;?>" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput">

                                        <?php if ( !empty($item->image) ):?>

                                            <img src="<?= $item->image ?>" class="form-image"/>

                                        <?php endif;?>

                                    </div>
                                    <div>
                                        <span class="btn btn-file">
                                            <span class="fileinput-new"> Выбрать изображение </span>
                                            <span class="fileinput-exists"> Изменить </span>
                                            <input type="file" name="image"> 
                                        </span>
                                        <a href="javascript:;" class="btn delete fileinput-exists" data-dismiss="fileinput"> Удалить </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-2">Дата</label>
                            <div class="col-xs-3">
                                <input class="form-control date-picker pull-left" type="text"  value="<?= date('d-m-Y', strtotime($item->date_created)) ?>" name="date">
                            </div>
                            <div class="col-xs-7">
                                <input class="form-control input-inline text-center" type="text" size="1" value="<?= date('H', strtotime($item->date_created)) ?>" name="hours">
                                <span>&nbsp;: &nbsp;</span>
                                <input class="form-control input-inline text-center" type="text" size="1" value="<?= date('i', strtotime($item->date_created)) ?>" name="minutes">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-2">Анонс</label>
                            <div class="col-xs-10">
                                <textarea type="text" class="wysihtml5 form-control" style="height: 150px" name="preview"><?= $item->preview ?></textarea>
                            </div>
                        </div>

                        <?php foreach ($IU_Props as $i => $prop): ?>

                            <div class="form-group">

                                <label class="col-xs-2 control-label">
                                    <?= $prop->name ?>
                                </label>

                                <div class="col-xs-5">
                                    <input class="form-control" name="props[<?= $prop->code ?>]" value="<?= isset($itemprops[$prop->code]) ? $itemprops[$prop->code] : '' ?>" />
                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                </div>

                <div class="tab-pane" id="tab_content">

                    <div class="form-body">

                        <div class="form-group">
                            <div class="col-xs-12">
                                <textarea type="text" class="wysihtml5 form-control" name="content" style="height: 500px"><?= $item->content ?></textarea>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="buttons-set bottom">
            <button class="btn save">Сохранить</button>
            <button onclick="history.back();return false;" class="btn">Назад</button>
        </div>

    </div>

</form>

<script src="/libraries/admin/js/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

<!--Подключаем библиотеку WYSIHTML5 и его настройки для проекта-->

<script src="/libraries/admin/js/wysihtml5-0.3.0.min.js" type="text/javascript"></script>

<script src="/template/admin/js/construct.wysihml5.js"></script>
