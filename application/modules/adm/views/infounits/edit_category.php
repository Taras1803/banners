
<form action="<?= $_SERVER['REQUEST_URI'] ?>" enctype="multipart/form-data" method="post">

    <div class="portlet">

        <div class="portlet-title">
            <div class="caption">
                <span> <?= $category->name ?></span>
            </div>

            <div class="buttons-set pull-right">
                <button class="btn save">Сохранить</button>
                <a class="btn" href="<?= ADMIN_PAGE_PATH ?>infounits/settings/<?= $category->infounit_id ?>/#tab_categories">Вернуться</a>
            </div>
        </div>
            
        <div class="portlet-body">

            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-xs-2">Название</label>
                    <div class="col-xs-6">
                        <input type="text" class="form-control" name="name" value="<?= $category->name ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-xs-2">ЧПУ страницы</label>
                    <div class="col-xs-6">
                        <input type="text" class="form-control" name="url" value="<?= $category->url ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-xs-2">Родитель</label>
                    <div class="col-xs-3">
                        <select class="form-control" name="parent">

                            <option value="0">Нет</option>

                            <? foreach( $cats as $cat): ?>

                                <option <?= set_selected_val($cat->id, $category->parent) ?> value="<?= $cat->id ?>">

                                    <?= str_repeat('&nbsp;', $cat->level * 3) . $cat->name ?>

                                </option>

                            <? endforeach; ?>

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-xs-2">Изображение</label>
                    <div class="col-xs-10">
                        <div class="fileinput <?php if(empty($category->image)):?>fileinput-new<?php else:?>fileinput-exists<?php endif;?>" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput">

                                <?php if ( !empty($category->image) ):?>

                                    <img src="<?= $category->image ?>" class="form-image"/>

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
                    <label class="control-label col-xs-2">Описание</label>
                    <div class="col-xs-8">
                        <textarea type="text" class="wysihtml5 form-control" rows="5" name="description"><?= $category->description ?></textarea>
                    </div>
                </div>

            </div>
                    
        </div>
               
        <div class="buttons-set bottom">
            <button class="btn save">Сохранить</button>
            <a class="btn" href="<?= ADMIN_PAGE_PATH ?>infounits/settings/<?= $category->infounit_id ?>/#tab_categories">Вернуться</a>
        </div>   
                
    </div>
        
</form>

<script src="/libraries/admin/js/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

<script src="/template/admin/js/infounits.js"></script>
