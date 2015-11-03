<?php
/*
 * Template Name: Index
 * Description: teste
 */
get_header();
$options = get_option('socialdb_theme_options');
?>

<?php while (have_posts()) : the_post(); ?>
     <!-- TAINACAN: div necessaria para procedimentos do facebook  -->
    <div id="fb-root"></div>
     <!-- TAINACAN: esta div (AJAX) mostra o painel da colecao e suas acoes, estilos inline para descer a div apenas pois estava sob o header  -->
    <div class="panel panel-default collection_header" id="collection_post" style="margin-top: -20px;margin-bottom: 0px;">  
    </div> 
    <!-- TAINACAN - BEGIN: ITENS NECESSARIOS PARA EXECUCAO DE VARIAS PARTES DO SOCIALDB -->
    <input type="hidden" id="socialdb_fb_api_id" name="socialdb_fb_api_id" value="<?php echo $options['socialdb_fb_api_id']; ?>">
    <input type="hidden" id="socialdb_embed_api_id" name="socialdb_embed_api_id" value="<?php echo $options['socialdb_embed_api_id']; ?>">
    <input type="hidden" id="current_user_id" name="current_user_id" value="<?php echo get_current_user_id(); ?>">
    <input type="hidden" id="src" name="src" value="<?php echo get_template_directory_uri() ?>">
    <input type="hidden" id="collection_id" name="collection_id" value="<?php echo get_the_ID() ?>">
    <input type="hidden" id="search_collection_field" name="search_collection_field" value="<?php if ($_GET['search']) {
        echo $_GET['search'];
    } ?>">
    <input type="hidden" id="recovery_password" name="recovery_password" value="<?php if ($_GET['recovery_password']) {
        echo (int) base64_decode($_GET['recovery_password']);
    } ?>">
    <input type="hidden" id="mycollections" name="mycollections" value="<?php if (isset($_GET['mycollections'])) {
        echo 'true';
    } ?>">
    <input type="hidden" id="object_page" name="object_page" value="<?php if (isset($_GET['item'])) {
        echo trim($_GET['item']);
    } ?>">
    <input type="hidden" id="info_messages" name="info_messages" value="<?php if (isset($_GET['info_messages'])) {
        echo $_GET['info_messages'];
    } ?>">
    <input type="hidden" id="info_title" name="info_title" value="<?php if (isset($_GET['info_title'])) {
        echo $_GET['info_title'];
    } ?>">
    <input type="hidden" id="open_wizard" name="open_wizard" value="<?php if (isset($_GET['open_wizard'])) {
        echo $_GET['open_wizard'];
    } ?>">
    <input type="hidden" id="open_login" name="open_login" value="<?php if (isset($_GET['open_login'])) {
        echo $_GET['open_login'];
    } ?>">
    <input type="hidden" id="wp_query_args" name="wp_query_args" value=""> <!-- utilizado na busca -->
    <input type="hidden" id="value_search" name="value_search" value=""> <!-- utilizado na busca -->
    <!-- TAINACAN - END: ITENS NECESSARIOS PARA EXECUCAO DE VARIAS PARTES DO SOCIALDB -->
    
     <!-- TAINACAN: esta div central que agrupa todos os locais para widgets e a listagem de objeto -->
    <div id="main_part" >
         <!-- TAINACAN: esta div (AJAX) mostra os widgets para pesquisa que estao setadas na horizontal  -->
        <div class="row" id="horizontal_menu">
        </div> 
        <!-- TAINACAN: este container agrupa a coluna da esquerda dos widgets, a listagem de itens e coluna da direita dos widgets --> 
       <div id="container_three_columns" class="container-fluid row">  
            <!-- TAINACAN: esta div (AJAX) mostra os widgets para pesquisa que estao setadas na esquerda  -->
            <div  id="div_left">
                
            </div>	
             <!-- TAINACAN: esta div agrupa a listagem de itens ,submissao de novos itens e ordencao --> 
           <div  id="div_central">
    <?php if (get_option('collection_root_id') != get_the_ID()): ?>
               <!-- TAINACAN: esta div agrupa a submissao de novos itens e a ordenacao (estilo inline usado para afastar do painel da colecao) --> 
                <div id="menu_object" style="margin-top: 10px;" class="row">
                    <div class="col-md-12 search-colecao">
                            <div class="input-group">
                                <input  style="font-size: 13px; " class="form-control input-medium placeholder ui-autocomplete-input" id="search_objects" onkeyup="set_value(this)" onkeydown="if (event.keyCode === 13)
                                            document.getElementById('search_main').click();
                                        " type="text" placeholder="Search Objects" autocomplete="off">
                                <span class="input-group-btn">
                                    <button id="search_main" type="button" onclick="search_objects('#search_objects')" class="btn btn-default">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                    <button onclick="clear_list()"id="clear" class="btn btn-default"><?php _e('Clear') ?></button>
                                </span>
                            </div>
                            <h6 class="pull-right white" style="color:#666">Busca Avançada<span class="glyphicon glyphicon-triangle-bottom"></span></h6>

                        </div>
                    <!-- TAINACAN: esta div estao localizados o campo para o titulo e botao com o icone para o adicionar rapido, colado ao input - col-md-6 (bootstrap) -->
                    <!--div class="col-md-6">
                        <div class="input-group">
                            <input onkeydown="if (event.keyCode === 13)
                                        document.getElementById('click_fast_insert').click()" type="text" placeholder="<?php _e('Type the title or the URI to you object!'); ?>" id="fast_insert_object" class="form-control input-medium placeholder" style="font-size: 13px; "></textarea>
                            <span class="input-group-btn">
                                <button class="btn btn-default" id="click_fast_insert" onclick="fast_insert()" type="button"><span class="glyphicon glyphicon-plus"></span></button>
                            </span>
                        </div><!-- /input-group -->
                    <!--/div-->
                    <!-- TAINACAN: esta div estao o botao que abre o formulario completo para submissao de itens, botao para ordenacao asc e desc, e o selectbox para selecionar a ordenacao  - col-md-6 (bootstrap) -->
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group" role="group" aria-label="...">
                                    <button type="button" id="create_button" href="#" class="btn btn-default"><?php _e('New Object') ?> </button>
                                    <!--<button type="button" id="home_button" href="#" class="btn btn-default">Home</button>
                                       <button type="button" class="btn btn-default">Right</button>-->
                                </div> 
                                <button onclick="asc_ordenation()" type="button" id="sort_list" href="#" class="btn btn-default pull-right"><span class="glyphicon glyphicon-sort-by-attributes"></button>
                                <button onclick="desc_ordenation()" type="button" id="sort_list" href="#" class="btn btn-default pull-right"><span class="glyphicon glyphicon-sort-by-attributes-alt"></button>
                                <!--<div class="btn-group pull-right" role="group" aria-label="menu">
                                    <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-sort"></span></button>
                                    <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-star"></span></button>
                                </div>-->
                            </div>  
                            <div class="col-md-6"> 
                                <select onchange="getOrder(this)" class="form-control"  name="collection_single_ordenation" id="collection_single_ordenation">
                                    <option value=""><?php _e('Sorted by') ?></option>
                                </select>
                            </div>    
                        </div>    
                        <!-- <a id="create_button" href="#" class="btn btn-default">Create</a>&nbsp;-->
                    </div>
                </div>  
    <?php endif; ?>
            <!--div id="remove"> view removida </div> -->
             <!-- TAINACAN: esta div (AJAX)recebe o formulario para criacao e edicao de itens  -->
            <div id="form">
            </div>	
            <!-- TAINACAN: esta div apenas 'envelopa' a que recebe a listagem nenhum estilo e associado  -->
            <div id="container_socialdb">
                <!-- TAINACAN: esta div (AJAX)recebe a listagem de itens  -->
                <div id="list">
                </div>    
            </div>
            <!-- TAINACAN: div que esta o gif que eh mostrada ao filtrar itens e outras acoes que necessitam e carregamento -->
            <div id="loader_objects" style="display:none"><center><img src="<?php echo get_template_directory_uri() . '/libraries/images/catalogo_loader_725.gif' ?>"><h3><?php _e('Loading objects...') ?></h3></center></div>
            <br>
            <!--a id="home_button" href="#" class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span></a-->

        </div>
        <!-- TAINACAN: esta div (AJAX) mostra os widgets para pesquisa que estao setadas na direita  -->
        <div id="div_right">
        </div>    
    </div>
   </div>      
   <!-- Fim do conteudo principal da pagina (div main part) -->
    <!-- TAINACAN: esta div eh mostrada quando eh clicado com o botao direito sobre categorias e tags no dynatree  -->
    <ul id="myMenuSingle" class="contextMenu" style="display:none;">
        <li class="add"><a href="#add"><?php echo __('Add'); ?></a></li>  
        <li class="edit"><a href="#edit"><?php echo __('Edit'); ?></a></li>
        <li class="delete"><a href="#delete"><?php echo __('Remove'); ?></a></li>
    </ul> 


    <!-- TAINACAN: modal padrao bootstrap para adicao de categorias    -->
    <div class="modal fade" id="modalAddCategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form  id="submit_adicionar_category_single">   
                    <input type="hidden" id="category_single_add_id" name="category_single_add_id" value="">
                    <input type="hidden" id="operation_event_create_category" name="operation" value="add_event_term_create">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-plus"></span>&nbsp;<?php echo __('Add Category'); ?></h4>
                    </div>
                    <div class="modal-body">

                        <div class="create_form-group">
                            <label for="category_single_name"><?php _e('Category name'); ?></label>
                            <input type="text" class="form-control" id="category_single_name" name="socialdb_event_term_suggested_name" required="required" placeholder="<?php _e('Category name'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="category_single_parent_name"><?php _e('Category parent'); ?></label>
                            <input disabled="disabled" type="text" class="form-control" id="category_single_parent_name" placeholder="<?php _e('Right click on the tree and select the category as parent'); ?>" name="category_single_parent_name" >
                            <input type="hidden"  id="category_single_parent_id"  name="socialdb_event_term_parent" value="0" >
                        </div>
                        <input type="hidden" id="category_single_add_collection_id" name="socialdb_event_collection_id" value="<?php echo get_the_ID(); ?>">
                        <input type="hidden" id="category_single_add_create_time" name="socialdb_event_create_date" value="<?php echo mktime(); ?>">
                        <input type="hidden" id="category_single_add_user_id" name="socialdb_event_user_id" value="<?php echo get_current_user_id(); ?>">     
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo __('Save'); ?></button>
                    </div>
                </form>  
            </div>
        </div>
    </div>

    <!-- TAINACAN: modal padrao bootstrap para edicao de categorias    -->
    <div class="modal fade" id="modalEditCategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form  id="submit_edit_category_single">   
                    <input type="hidden" id="category_single_edit_id" name="socialdb_event_term_id" value="">
                    <input type="hidden" id="operation_event_edit_category" name="operation" value="add_event_term_edit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-pencil"></span>&nbsp;<?php echo __('Edit Category'); ?></h4>
                    </div>
                    <div class="modal-body row">
                        <div class="col-md-4">
                            <div id="dynatree_modal_edit">
                            </div>
                        </div>    
                        <div class="col-md-8">
                            <div class="create_form-group">
                                <label for="category_single_edit_name"><?php _e('Category name'); ?></label>
                                <input type="text" class="form-control" id="category_single_edit_name" name="socialdb_event_term_suggested_name" required="required" placeholder="<?php _e('Category name'); ?>">
                                <input type="hidden"  id="socialdb_event_previous_name"  name="socialdb_event_term_previous_name" value="0" >
                            </div>
                            <div class="form-group">
                                <label for="category_single_parent_name_edit"><?php _e('Category parent'); ?></label>
                                <input disabled="disabled" type="text" class="form-control" id="category_single_parent_name_edit" name="category_single_term_parent_name_edit" placeholder="<?php _e('Click on the tree and select the category as parent'); ?>" >
                                <input type="hidden"  id="category_single_parent_id_edit"  name="socialdb_event_term_suggested_parent" value="0" >
                                <input type="hidden"  id="socialdb_event_previous_parent"  name="socialdb_event_term_previous_parent" value="0" >
                            </div>
                            <input type="hidden" id="category_single_edit_collection_id" name="socialdb_event_collection_id" value="<?php echo get_the_ID(); ?>">
                            <input type="hidden" id="category_single_edit_time" name="socialdb_event_create_date" value="<?php echo mktime(); ?>">
                            <input type="hidden" id="category_single_edit_user_id" name="socialdb_event_user_id" value="<?php echo get_current_user_id(); ?>">   
                        </div>    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo __('Edit'); ?></button>
                    </div>
                </form>  
            </div>
        </div>
    </div>
    <!-- modal exluir -->
    <div class="modal fade" id="modalExcluirCategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form  id="submit_delete_category_single">   
                    <input type="hidden" id="category_single_delete_id" name="socialdb_event_term_id" value="">
                    <input type="hidden" id="operation" name="operation" value="add_event_term_delete">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-trash"></span>&nbsp;<?php echo __('Remove Category'); ?></h4>
                    </div>
                    <div class="modal-body">
    <?php echo __('Confirm the exclusion of '); ?><span id="delete_category_single_name"></span>?
                    </div>
                    <input type="hidden" id="category_single_delete_collection_id" name="socialdb_event_collection_id" value="<?php echo get_the_ID(); ?>">
                    <input type="hidden" id="category_single_delete_time" name="socialdb_event_create_date" value="<?php echo mktime(); ?>">
                    <input type="hidden" id="category_single_delete_user_id" name="socialdb_event_user_id" value="<?php echo get_current_user_id(); ?>">   

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo __('Delete'); ?></button>
                    </div>
                </form>  
            </div>
        </div>
    </div>



    <!-- TAINACAN: modal padrao bootstrap para adicao de items sem url    -->
    <!-- modal Adicionar Rapido -->
    <div class="modal fade" id="modal_import_objet_url" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">  
                <div id="form_url_import">
                    <input type="hidden" id="socialdb_event_collection_id_tag" name="socialdb_event_collection_id" value="">
                    <input type="hidden" id="operation" name="operation" value="add">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <input type="text" id="title_insert_object_url" class="form-control input-lg" value="">
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4" id="image_side"></div>
                            <div class="col-md-8">
                                <textarea rows="6" class="form-control" id="description_insert_object_url" ></textarea>
                            </div>
                            <input type="hidden" id="thumbnail_url" name="thumbnail_url" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
                        <a href="#" id="save_object_url" class="btn btn-primary"><?php echo __('Save'); ?></a>
                    </div> 
                </div> 
                <div style="display: none;" id="loader_import_object">
                    <center><img src="<?php echo get_template_directory_uri() . '/libraries/images/catalogo_loader_725.gif' ?>"><h3><?php _e('Importing Object...') ?></h3></center>
                </div>
            </div>
        </div>        
    </div>

    <!-- TAINACAN: modal padrao bootstrap para adicao de tags    -->
    <!-- modal Adicionar Tag -->
    <div class="modal fade" id="modalAdicionarTag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form  id="submit_adicionar_tag_single">   
                    <input type="hidden" id="operation_tag_add" name="operation" value="add_event_tag_create">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-plus"></span>&nbsp;<?php echo __('Add Tag'); ?></h4>
                    </div>
                    <div class="modal-body">

                        <div class="create_form-group">
                            <label for="tag_single_name"><?php _e('Tag'); ?></label>
                            <input type="text" class="form-control" id="tag_single_name" name="socialdb_event_tag_suggested_name" required="required" placeholder="<?php _e('Tag name'); ?>">
                        </div>

                        <input type="hidden" id="tag_single_add_collection_id" name="socialdb_event_collection_id" value="<?php echo get_the_ID(); ?>">
                        <input type="hidden" id="tag_single_add_create_time" name="socialdb_event_create_date" value="<?php echo mktime(); ?>">
                        <input type="hidden" id="tag_single_add_user_id" name="socialdb_event_user_id" value="<?php echo get_current_user_id(); ?>">     
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo __('Save'); ?></button>
                    </div>
                </form>  
            </div>
        </div>
    </div>

    <!-- TAINACAN: modal padrao bootstrap para edicao de tags   -->
    <div class="modal fade" id="modalEditTag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form  id="submit_edit_tag_single">   
                    <input type="hidden" id="tag_single_edit_id" name="socialdb_event_tag_id" value="">
                    <input type="hidden" id="operation_tag_edit" name="operation" value="add_event_tag_edit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-pencil"></span>&nbsp;<?php echo __('Edit Tag'); ?></h4>
                    </div>
                    <div class="modal-body row">                         
                        <div class="col-md-12">
                            <div class="create_form-group">
                                <label for="tag_single_edit_name"><?php _e('Tag name'); ?></label>
                                <input type="text" class="form-control" id="tag_single_edit_name" name="socialdb_event_tag_suggested_name" required="required" placeholder="<?php _e('Tag name'); ?>">

                            </div>                            
                            <input type="hidden" id="tag_single_edit_collection_id" name="socialdb_event_collection_id" value="<?php echo get_the_ID(); ?>">
                            <input type="hidden" id="tag_single_edit_time" name="socialdb_event_create_date" value="<?php echo mktime(); ?>">
                            <input type="hidden" id="tag_single_edit_user_id" name="socialdb_event_user_id" value="<?php echo get_current_user_id(); ?>">   
                        </div>    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo __('Edit'); ?></button>
                    </div>
                </form>  
            </div>
        </div>
    </div>
    <!-- TAINACAN: modal padrao bootstrap para exclusao de tags   -->
    <div class="modal fade" id="modalExcluirTag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form  id="submit_delete_tag_single">   
                    <input type="hidden" id="tag_single_delete_id" name="socialdb_event_tag_id" value="">
                    <input type="hidden" id="operation_tag_delete" name="operation" value="add_event_tag_delete">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-trash"></span>&nbsp;<?php echo __('Remove Tag'); ?></h4>
                    </div>
                    <div class="modal-body">
    <?php echo __('Confirm the exclusion of '); ?><span id="delete_tag_single_name"></span>?
                    </div>
                    <input type="hidden" id="tag_single_delete_collection_id" name="socialdb_event_collection_id" value="<?php echo get_the_ID(); ?>">
                    <input type="hidden" id="tag_single_delete_time" name="socialdb_event_create_date" value="<?php echo mktime(); ?>">
                    <input type="hidden" id="tag_single_delete_user_id" name="socialdb_event_user_id" value="<?php echo get_current_user_id(); ?>">   

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo __('Delete'); ?></button>
                    </div>
                </form>  
            </div>
        </div>
    </div>
    <!-- TAINACAN: modal padrao bootstrap para demonstracao de execucao de processos, utilizado em varias partes do socialdb   -->
    <div class="modal fade" id="modalImportMain" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                        <center>
                            <img src="<?php echo get_template_directory_uri() . '/libraries/images/catalogo_loader_725.gif' ?>">
                            <h3><?php _e('Please wait...') ?></h3>
                        </center>
            </div>
        </div>
    </div>
     
     <!-- TAINACAN: modal padrao bootstrap para redefinicaode senha   -->
    <!-- Modal redefinir senha -->
    <div class="modal fade" id="myModalPasswordReset" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  id="formUserPasswordReset" name="formUserPasswordReset" >  
                <input type="hidden" name="operation" value="change_password">
                <input type="hidden" name="password_user_id" id="password_user_id" value=""/>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php _e('Change Password!'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="old_password_reset"><?php _e('Old Password'); ?><span style="color: #EE0000;"> *</span></label>
                        <input type="password" required="required" class="form-control" name="old_password_reset" id="old_password_reset" placeholder="<?php _e('Type here the old password'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="new_password_reset"><?php _e('New Password'); ?><span style="color: #EE0000;"> *</span></label>
                        <input type="password" required="required" class="form-control" name="new_password_reset" id="new_password_reset" placeholder="<?php _e('Type here the new password'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="new_check_password_reset"><?php _e('Confirm new password'); ?><span style="color: #EE0000;"> *</span></label>
                        <input type="password" required="required" class="form-control" name="new_check_password_reset" id="new_check_password_reset" placeholder="<?php _e('Type here your new password again'); ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close'); ?></button>
                    <button type="submit" class="btn btn-primary" onclick="check_passwords(); return false;"><?php _e('Submit'); ?></button>
                </div>
            </form>    
        </div>
    </div>
</div>
<!-- TAINACAN: esta div (AJAX) mostra as configuracoes da colecao  -->
    <div id="configuration" class="row">
    </div>
<!-- TAINACAN: scripts utilizados para criacao e monagem dos widgets de pesquisa  -->
     <?php  include_once 'views/search/js/single_js.php'; ?>


    <?php
endwhile; // end of the loop.
get_footer();
?>

