<div class="page-content" id="category-page">
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">
               Генерация sitemap.xml
            </div>
        </div>

        <div class="portlet-body">
            <a><input type="button" value="Сгенерировать"></a>
        </div>
    </div>
    <script src="/libraries/admin/js/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/libraries/admin/js/datatables/datatables.bootstrap.js" type="text/javascript"></script>

</div>
<script>
    $('.portlet-body a').click(function () {
        var input = $('.portlet-body a input');
        input.addClass('submit');
        input.attr('value','Генерируется');
        $.get("<?=ADMIN_PAGE_PATH?>sitemap/generate/", onAjaxSuccess);

        function onAjaxSuccess(response)
        {
            input.removeClass('submit');
            input.attr('value','Сгенерировать');
           if(response === '1'){
               alert('sitemap.xml успешно сгенерирован');
           }else{
               alert('Ошибка генерации');
           }
        }

    })
</script>
<style>
    .submit{
        color: red;
        border-radius: 20px;
    }
</style>