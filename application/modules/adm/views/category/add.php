<div class="page-content">
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">
                Добавление категорий
            </div>
            <div class="buttons-set pull-right">
                <a href="../" class="btn">Назад</a>
            </div>
        </div>

        <form action="" id="category-form">
            <div class="portlet-body">
                <div class="form-body">
                    <div class="form-group">
                        <div class="col-xs-2" style="text-align: right;"><h4>Свойства</h4></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-2">URL код (строго латиница) *:</label>
                        <div class="col-xs-6">
                            <input class="form-control" name="category[code]" placeholder="Например: lutshie-schiti-v-balashihe">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-2">H1 название *:</label>
                        <div class="col-xs-6">
                            <input class="form-control" name="category[h1]" placeholder="Например: Лучшие щиты в Балашихе">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-2">Title:</label>
                        <div class="col-xs-6">
                            <input class="form-control" name="category[title]" placeholder="Например: Лучшие щиты в Балашихе">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-2">Description:</label>
                        <div class="col-xs-6">
                            <input class="form-control" name="category[description]" placeholder="Например: Лучшие щиты в Балашихе">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-2">SEO текст:</label>
                        <div class="col-xs-6">
                            <textarea class="form-control" name="category[seo]" placeholder="html/text"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-2" style="text-align: right;"><h4>Фильтры</h4></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-2">По типу конструкции:</label>
                        <div class="col-xs-6">
                            <select name="category[board_types][]" class="select2 custom" multiple>
                                <?php foreach($filters['board_types'] as $filter):?>
                                    <option value="<?=$filter->id?>"><?=$filter->name?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-2">По шоссе:</label>
                        <div class="col-xs-6">
                            <select name="category[roads][]" class="select2 custom" multiple>
                                <?php foreach($filters['roads'] as $filter):?>
                                    <option value="<?=$filter->id?>"><?=$filter->name?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-2">По району:</label>
                        <div class="col-xs-6">
                            <select name="category[districts][]" class="select2 custom" multiple>
                                <?php foreach($filters['districts'] as $filter):?>
                                    <option value="<?=$filter->id?>"><?=$filter->name?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-2">По городу:</label>
                        <div class="col-xs-6">
                            <select name="category[towns][]" class="select2 custom" multiple>
                                <?php foreach($filters['towns'] as $filter):?>
                                    <option value="<?=$filter->id?>"><?=$filter->name?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="buttons-set bottom">
                <button class="btn save">Добавить</button>
                <a href="../" class="btn">Отменить</a>
            </div>
        </form>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
        <script>
            $('#category-form').submit(function(e){
                e.preventDefault();

                $.post('../addAjax/', $(this).serialize(), function(res){
                    if (res == '1') {
                        location.href = '/adm/category/';
                    } else {
                        alert('При добавлении произошла ошибка, возможно вы заполнили не все обязательные поля');
                    }
                });
            });

            $('.select2.custom').select2();
        </script>
    </div>
</div>