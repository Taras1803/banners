
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet">
           
           <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                <div class="portlet-title">
                    <div class="caption">
                        <span>Свойства конструкций</span>
                    </div>
                    
                    <div class="buttons-set pull-right">

                        <button class="btn save">Сохранить</button>
                        <a href="javascript:void()" class="btn add-prop">Добавить свойство</a>
                        <a href="/adm/boards/" class="btn">Назад</a>
                    
                    </div>

                </div>


                <div class="portlet-body">
                  
                    <table class="table all-borders" id="prop_list">
                        <thead>
                            <tr>
                                <th> Имя </th>
                                <th> Код </th>
                                <th> Номер колонки в Excel </th>
                                <th width="45"> Показывать </th>
                                <th width="45"></th>
                            </tr>
                        </thead>
                        <tbody>
                   
                            <?php if (empty($props)):?>

                                <tr class="property">
                                    <td>
                                        <input type="text" name="prop[new][name]" value="" class="form-control"/>
                                    </td>
                                    <td>
                                        <input type="text" name="prop[new][code]" value="" class="form-control"/>
                                    </td>
                                    <td>
                                        <input type="text" name="prop[new][xlsx_column]" value="" class="form-control"/>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="prop[new][show]"/>
                                    </td>
                                    <td class="text-center">
                                        <span class="btn default red" onclick="delete_prop(this)"><i class="fa fa-times"></i></span>
                                    </td>
                                </tr>

                            <?php else:?>
                    
                                <?php foreach ($props as $prop): ?>

                                    <tr class="property">
                                       
                                        <td>
                                            <input type="text"   name="prop[<?= $prop->id ?>][name]" value="<?= $prop->name ?>" class="form-control"/>
                                            <input type="hidden" name="prop[<?= $prop->id ?>][id]" value="<?= $prop->id ?>" class="prop_id"/>
                                        </td>
                                        <td>
                                            <input type="text" name="prop[<?= $prop->id ?>][code]" value="<?= $prop->code ?>" class="form-control"/>
                                        </td>
                                        <td>
                                            <input type="text" name="prop[<?= $prop->id ?>][xlsx_column]" value="<?= $prop->xlsx_column ?>" class="form-control"/>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" <? if($prop->show) echo 'checked'; ?> name="prop[<?= $prop->id ?>][show]"/>
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
                    
                </div>
                
                <div class="buttons-set bottom">
                    <button class="btn save">Сохранить</button>
                    <a href="javascript:void()" class="btn add-prop">Добавить свойство</a>
                    <a href="/adm/boards/" class="btn">Назад</a>
                </div>
            
            </form>
            
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->

    </div>
</div>

<script>
    
    i = 1;
    
    $('.add-prop').click(function(){
         
         prop = $('#prop_list tbody tr:first').clone().appendTo('#prop_list tbody');
         
         prop.find('.prop_id').remove();
         
         prop.find('input, select').each(function(){
             
             $(this).val('').attr("name", $(this).attr("name").replace( $(this).attr("name").match(/\[(.+?)\]/g)[0], "[new_" + i + "]") );
         
         });
             
         i++;
         
     });
    
     function delete_prop(e){
         
         var tr = $(e).closest('tr');
         
         var id = tr.find('.prop_id').val();
         
         if( id ){
             
             $.post('/adm/boards/remove_prop/' + id);
             
         }
         
         if( $('#prop_list .property').length > 1 ){
         
            tr.remove();
         
         } else {
           
             tr.find('input, select').val('');
             
         }
         
     }
    
</script>