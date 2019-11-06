<div class="portlet">
    <div class="portlet-title">
        <div class="caption">
            <span><?= $infounit->name ?></span>
        </div>
    </div>
    
    
    <form action="" enctype="multipart/form-data" method="post">

        <ul class="form-tabs">

            <li><a href="#tab_general" data-tab> Основное </a></li>
            <li><a href="#tab_props" data-tab> Дополнительные поля </a></li>
            <li><a href="#tab_categories" data-tab> Категории </a></li>

        </ul>

        <div class="portlet-body">

            <div class="tab-content">

                <div class="tab-pane" id="tab_general">

                    <div class="form-body">

                        <div class="form-group">
                            <label class="control-label col-xs-2">Название</label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control" name="name" value="<?= $infounit->name ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-2">ЧПУ страницы</label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control" name="url" value="<?= $infounit->url ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-2"></div>
                            <div class="col-xs-6">
                                <a href="<?= ADMIN_PAGE_PATH ?>infounits/delete_unit/<?= $infounit->id ?>"  onclick="return confirm('Все данные будут потеряны');" class="btn delete">Удалить инфоблок</a>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="tab-pane" id="tab_props">

                    <div class="form-body">

                        <div class="row">

                            <div class="col-xs-9">

                                <h4>Список дополнительных полей</h4>

                                <table class="table all-borders" id="prop_list">
                                    <thead>
                                        <tr>
                                            <th> Имя </th>
                                            <th style="width: 30%"> Код </th>
                                            <th width="45"></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php if (empty($properties)):?>

                                        <tr class="property">
                                            <td>
                                                <input type="text"   name="props[new_1][name]" value="" class="form-control"/>
                                            </td>
                                            <td>
                                                <input type="text" name="props[new_1][code]" value="" class="form-control"/>
                                            </td>
                                            <td class="text-center">
                                                <span class="table-btn delete" onclick="delete_prop(this)"><i class="fa fa-times"></i></span>
                                            </td>
                                        </tr>

                                    <?php else:?>

                                        <?php foreach ($properties as $prop): ?>

                                            <tr class="property">
                                                <td>
                                                    <input type="text" name="props[<?= $prop->id ?>][name]" value="<?= $prop->name ?>" class="form-control"/>
                                                    <input type="hidden" name="props[<?= $prop->id ?>][id]" value="<?= $prop->id ?>" class="prop_id"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="props[<?= $prop->id ?>][code]" value="<?= $prop->code ?>" class="form-control"/>
                                                </td>
                                                <td class="text-center">
                                                    <span class="table-btn delete" onclick="delete_prop(this)"><i class="fa fa-times"></i></span>
                                                </td>
                                            </tr>

                                        <?php endforeach; ?>

                                    <?php endif;?>

                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>


                            <div class="btn dark add-prop">Добавить поле</div>

                        </div>

                    </div>

                </div>

            </div>

                <div class="tab-pane" id="tab_categories">

                    <div class="form-body">

                        <a class="btn dark add-prop" href="<?= ADMIN_PAGE_PATH ?>infounits/add_category/<?= $infounit->id ?>/">Добавить категорию</a>

                        <br><br>

                        <?php if ( !empty($categories) ) : ?>

                            <table class="table table-striped" id="new_list">
                                <thead>
                                    <tr>
                                        <th style="width: 40px"> ID </th>
                                        <th> Название </th>
                                        <th style="width: 30px"></th>
                                        <th style="width: 30px"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($categories as $category): ?>
                                        <tr>
                                            <td><?= $category->id ?></td>
                                            <td>
                                                <?= str_repeat('—', $category->level) . ' ' . $category->name ?>
                                            </td>
                                            <td>
                                                <a href="<?= ADMIN_PAGE_PATH ?>infounits/edit_category/<?= $category->id ?>/" class="table-btn"><i class="fa fa-pencil"></i></a>
                                            </td>
                                            <td>
                                                <a href="<?= ADMIN_PAGE_PATH ?>infounits/delete_category/<?= $category->id ?>/" class="table-btn delete"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>

                        <?php endif; ?>

                    </div>

                </div>

            </div>


        </div>

        <div class="buttons-set bottom">
            <button class="btn save">Сохранить</button>
            <button onclick="history.back();return false;" class="btn">Назад</button>
        </div>
    
    </form>


</div>

<script>
    
     i = 2;
    
     $('.add-prop').click(function(){
         
         prop = $('#prop_list tbody tr:first').clone().appendTo('#prop_list tbody');
         
         prop.find('[name=id]').remove();
         
         prop.find('input, select').each(function(){
             
             $(this).val('').attr("name", $(this).attr("name").replace( $(this).attr("name").match(/\[(.+?)\]/g)[0], "[new_" + i + "]") );
         
         });
             
         i++;
         
     });
    
     function delete_prop(e){
         
         var tr = $(e).closest('tr');
         
         var id = tr.find('.prop_id').val();
         
         if( id ){
             
             $.post('/adm/infounits/delete_prop/' + id);
             
         }
         
         if( $('#prop_list .property').length > 1 ){
         
            tr.remove();
         
         } else {
           
             tr.find('input, select').val('');
             
         }
         
     }
    
</script>
