<?php
/*
 * 
 * View responsavel em mostrar o menu mais opcoes com as votacoes, propriedades e arquivos anexos
 * 
 * 
 */

include_once ('../../../../../wp-config.php');
include_once ('../../../../../wp-load.php');
include_once ('../../../../../wp-includes/wp-db.php');
include_once ('js/list_js.php');
?> 
<!-- TAINACAN: hidden utilizados para execucao de processos desta view (list.php)  -->
<input type="hidden" id="keyword_pagination" name="keyword_pagination" value="<?php if (isset($keyword)) echo $keyword; ?>" >
<input type="hidden" id="sorted_form" name="sorted_form" value="<?php echo $sorted_by; ?>" >
<!--?php if (get_option('collection_root_id') != $collection_id): ?-->
<!-- TAINACAN: panel situado abaixo do painel da colecao e acima da listagem de itens   -->
<!--div class="panel panel-default clear" style="margin-top: 5px;">
    <div class="panel-heading" style="border-bottom: 0px;display:block;"> 
<!-- TAINACAN: mostra o tipo e a forma de ordenacao realizada para a listagem  -->
<!--strong><span style="font-size: 15px;"><?php echo $listed_by; ?></span></strong>
<!-- TAINACAN: mostra o numero de objetos obtidos na pesquisa atual  -->
<!--span class="pull-right"><?php _e('Number of objects: ', 'tainacan'); ?>:&nbsp;<span id="object_count"><b><?php echo $loop->found_posts; ?></b></span></span-->
<input type="hidden" id="number_found_posts" value="<?php echo $loop->found_posts; ?>" />
<!--/div>    
</div-->
<!--?php endif; ?-->
<?php if ($loop->have_posts()) : ?>
    <!-- TAINACAN: esta div apenas coloca um estilo para scroll -->
    <!--div class="row">
    <!-- TAINACAN: esta div apenas engloba toda a listagem,  -->
    <!--div class="post"-->
    <!-- TAINACAN: esta div eh responsavel em mostrar os cabecalhos das div's que ficam na parte superior  das colunas, title,content, menu ...  -->
    <!--div class="row" <?php if ($collection_data['collection_metas']['socialdb_collection_columns'] != '1') echo "style='display:none;'"; ?>>
           <div <?php if ($collection_data['collection_metas']['socialdb_collection_hide_thumbnail'] == 'hide_thumb') echo "style='display:none;'"; ?> class="col-md-2"><strong><?php _e('Object Thumbnail'); ?></strong></b></div>
           <div <?php if ($collection_data['collection_metas']['socialdb_collection_hide_title'] == 'hide_title') echo "style='display:none;'"; ?> class="col-md-2"><strong><?php _e('Object Name'); ?></strong></div>
           <div <?php if ($collection_data['collection_metas']['socialdb_collection_hide_description'] == 'hide_description') echo "style='display:none;'"; ?> class="col-md-2"><strong><?php _e('Object Description'); ?></strong></div>
           <div <?php if ($collection_data['collection_metas']['socialdb_collection_hide_categories'] == 'hide_category') echo "style='display:none;'"; ?> class="col-md-2"><strong><?php _e('Classifications'); ?></strong></div>
          <div <?php if ($collection_data['collection_metas']['socialdb_collection_hide_rankings'] == 'hide_rankings') echo "style='display:none;'"; ?> class="col-md-2"><strong><?php _e('Rankings'); ?></strong></div>
           <div <?php if ($collection_data['collection_metas']['socialdb_collection_hide_menu'] == 'hide_menu') echo "style='display:none;'"; ?> class="col-md-2"><strong><?php _e('Actions'); ?></strong></div>
    </div-->
    <!-- TAINACAN: esta div apenas setada para que todas os items fiquem abaixo da class row  -->
    <!--div class="row"-->
    <?php
    if ($collection_data['collection_metas']['socialdb_collection_columns'] != '') {
        $classColumn = 12 / $collection_data['collection_metas']['socialdb_collection_columns'];
    } else {
        $classColumn = 12;
    }
    $countLine = 0;
    ?>
    <?php
    while ($loop->have_posts()) : $loop->the_post();
        $countLine++;
        ?>  
        <!-- TAINACAN: esta div eh responsavel em determinar se a listagem sera de uma coluna, duas e etc | O id e o tamanho da class sao construidos dinamicamente  -->    
        <!-- Container geral do objeto-->
        <li class="col-md-6" id="object_<?php echo get_the_ID() ?>">
            <!-- TAINACAN: coloca a class row DO ITEM, sao cinco colunas possiveis todas elas podendo ser escondidas pelo o usuario, mas seu tamanho eh fixo col-md-2  -->
            <div class="item-colecao">
                <div class="row droppableClassifications item-info" style="margin:0;">
                    <!-- TAINACAN: container que mostra o thumbnail do objeto ou a imagem default do fichario, utiliza-se a biblioteca pretty photo para expansao da imagem para seu tamanho default  -->
                    <div class="col-md-3 colFoto" style="min-height: 150px;">
                        <?php if (get_option('collection_root_id') != $collection_id): ?>
                            <a href="#" onclick="showSingleObject('<?php echo get_the_ID() ?>', '<?php echo get_template_directory_uri() ?>');">
                            <?php else: ?>
                                <a href="<?php echo get_the_permalink(); ?>">   
                                <?php endif; ?>
                                <?php
                                //verifica se tem thumbnail
                                if (get_the_post_thumbnail(get_the_ID(), 'thumbnail')) {
                                    //$url = get_post_meta(get_the_ID(), 'socialdb_thumbnail_url', true);
                                    $url_image = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
                                    ?>
                                    <img src="<?php echo $url_image; ?>" class="img-responsive" />
                                    <?php
                                } else {// pega a foto padrao 
                                    ?>
                                    <img src="<?php echo get_item_thumbnail_default(get_the_ID()); ?>" class="img-responsive">
                                <?php } ?>
                            </a>
        <!--a href=""><img src="images/imagem.png" alt=""></a-->
                    </div>
                    <div class="col-md-7 flex-box" style="flex-direction:column;">
                        <!-- TITLE -->
                        <?php if (get_option('collection_root_id') == $collection_id): ?>
                            <a href="<?php echo get_the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
                            <?php
                        else:
                            $uri = get_post_meta(get_the_ID(), 'socialdb_uri_imported', true);
                            ?>
                            <a href="#" onclick="showSingleObject('<?php echo get_the_ID() ?>', '<?php echo get_template_directory_uri() ?>');">
                                <!--a target="_blank" href="< ?php echo get_the_permalink($collection_id) ?>?item=< ?php echo get_post(get_the_ID())->post_name ?>"-->
                                <h4><?php the_title(); ?></h4>
                            </a>
                        <?php endif; ?>
                        <!--a href="#" onclick="showSingleObject('< ?php echo get_the_ID() ?>', '< ?php echo get_template_directory_uri() ?>');"><h4>Titulo</h4></a-->
                        <!-- END TITLE -->

                        <!-- DESCRIPTION -->
                        <h5><small><?php echo substr(get_the_content(), 0, 100); ?></small></h5>
                        <!-- END DESCRIPTION --> 

                        <!-- CATEGORIES AND TAGS -->
                        <!-- TAINACAN: hidden com id do objeto -->
                        <input type="hidden" value="<?php echo get_the_ID() ?>" class="object_id">
                        <!--span><small><?php _e('Categorias and Tags', 'tainacan'); ?></small></span><br-->
                        <!-- TAINACAN: botao que ativa o ajax que mostra as classificacoes -->
                        <!--h5>
                            <a class="cat-tag-btn" onclick="show_classifications('<?php echo get_the_ID() ?>')" id="show_classificiations_<?php echo get_the_ID() ?>" style="cursor:pointer;">
                                <?php _e('Show classifications', 'tainacan'); ?> <span class="caret"></span>
                            </a>
                        </h5-->
                        <button id="show_classificiations_<?php echo get_the_ID() ?>" onclick="show_classifications('<?php echo get_the_ID() ?>')" class="btn btn-default"><?php _e('Categorias and Tags', 'tainacan'); ?> <?php //_e('Show classifications', 'tainacan'); ?></button>
                        <!-- TAINACAN: container(AJAX) que mostra o html com as classificacoes do objeto -->
                        <div id="classifications_<?php echo get_the_ID() ?>" style="overflow: scroll; overflow-x: hidden; height: 50px; display: none;">
                        </div>
                    </div>
                    <div id="popover_content_wrapper<?php echo get_the_ID(); ?>" class="hide flex-box">
                        <a target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo get_the_permalink($collection_id) . '?item=' . get_post(get_the_ID())->post_name; ?>&amp;text=<?php echo htmlentities(get_the_title()); ?>&amp;via=socialdb"><div data-icon="&#xe005;"></div></a>
                        <a onclick="redirect_facebook('<?php echo get_the_ID() ?>');" href="#"><div data-icon="&#xe021;"></div></a>
                        <a target="_blank" href="https://plus.google.com/share?url=<?php echo get_the_permalink($collection_id) . '?item=' . get_post(get_the_ID())->post_name; ?>"><div data-icon="&#xe01b;"></div></a>
                    </div>
                    <div class="col-md-2 item-redesocial right">
                        <a id="popover_network<?php echo get_the_ID(); ?>" rel="popover" data-placement="left" onclick="showPopover(<?php echo get_the_ID(); ?>)"><div style="font-size:2em; cursor:pointer;" data-icon="&#xe00b;"></div></a>
                        <!-- TAINACAN: link para publicacao do item no facebook -->
                        <!--a onclick="redirect_facebook('<?php echo get_the_ID() ?>');" href="#">
                            <span data-icon="&#xe021;"></span>
                        </a>
                        <!-- TAINACAN: link para publicacao do item no twitter -->
                        <!--a target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo get_the_permalink($collection_id) . '?item=' . get_post(get_the_ID())->post_name; ?>&amp;text=<?php echo htmlentities(get_the_title()); ?>&amp;via=socialdb"><span data-icon="&#xe005;"></span></a>
                        <!-- TAINACAN: link para publicacao do item no g+ -->
                        <!--a target="_blank" href="https://plus.google.com/share?url=<?php echo get_the_permalink($collection_id) . '?item=' . get_post(get_the_ID())->post_name; ?>"><span data-icon="&#xe01b;"></span></a-->
                    </div>
                </div>
                <div class="row same-height item-interaction" style="margin:0;">
                    <div class="col-md-3 colFoto">
                        <?php if (get_option('collection_root_id') != $collection_id): ?>
                            <!-- TAINACAN: este botao nao aparece na tela porem eh necessario pois eh disparado automaticamente --> 
                            <button id="show_rankings_<?php echo get_the_ID() ?>" onclick="show_value_ordenation('<?php echo get_the_ID() ?>')" class="btn btn-default btn-lg"><?php _e('Show rankings', 'tainacan'); ?></button>
                            <!-- TAINACAN: container(AJAX) que mostra o html com os rankings do objeto-->
                            <div id="rankings_<?php echo get_the_ID() ?>"></div>
                            <!-- TAINACAN: script para disparar o evento que mostra os rankings -->
                            <script>
                                $('#show_rankings_<?php echo get_the_ID() ?>').hide();
                                $('#show_rankings_<?php echo get_the_ID() ?>').trigger('click');
                            </script>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-7">
                        <span><small><?php echo __('Created by: ', 'tainacan') . get_the_author(); ?></small></span><span class="pull-right"><small><?php echo get_the_date('d/m/Y'); ?></small></span>
                    </div>
                    <ul class="item-funcs col-md-2 right">
                        <!-- TAINACAN: hidden com id do item -->
                        <input type="hidden" class="post_id" name="post_id" value="<?= get_the_ID() ?>">

                                                                <!--li><a href=""><span class="glyphicon glyphicon-trash"></span></a></li>
                                                                <li><a href=""><span class="glyphicon glyphicon-warning-sign"></span></a></li>
                                                                <li><a href=""><span class="glyphicon glyphicon-pencil"></span></a></li>
                                                                <li><a href=""><span class="glyphicon glyphicon-comment"></span></a></li-->

                        <?php if (get_option('collection_root_id') != $collection_id): ?>
                            <!--------------------------- DELETE AND EDIT OBJECT------------------------------------------------>
                            <?php if ($is_moderator || get_post(get_the_ID())->post_author == get_current_user_id()): ?>
                                <li>
                                    <a onclick="delete_object('<?= __('Delete Object', 'tainacan') ?>', '<?= __('Are you sure to remove the object: ', 'tainacan') . get_the_title() ?>', '<?php echo get_the_ID() ?>', '<?= mktime() ?>')" href="#" class="remove">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="edit_object('<?php echo get_the_ID() ?>')">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li>
                                    <a onclick="show_report_abuse('<?php echo get_the_ID() ?>')" href="#" class="report_abuse">
                                        <span class="glyphicon glyphicon-warning-sign"></span>
                                    </a>
                                </li>
                                <!-- TAINACAN:  modal padrao bootstrap para reportar abuso -->
                                <div class="modal fade" id="modal_delete_object<?php echo get_the_ID() ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">  
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-trash"></span>&nbsp;<?php _e('Report Abuse', 'tainacan'); ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <?php echo __('Describe why the object: ', 'tainacan') . get_the_title() . __(' is abusive: ', 'tainacan'); ?>
                                                <textarea id="observation_delete_object<?php echo get_the_ID() ?>" class="form-control"></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close', 'tainacan'); ?></button>
                                                <button onclick="report_abuse_object('<?= __('Delete Object') ?>', '<?= __('Are you sure to remove the object: ', 'tainacan') . get_the_title() ?>', '<?php echo get_the_ID() ?>', '<?= mktime() ?>')" type="button" class="btn btn-primary"><?php echo __('Delete', 'tainacan'); ?></button>
                                            </div>
                                            </form>  
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <li><a href=""><span class="glyphicon glyphicon-comment"></span></a></li>
                        <?php else: ?>
                            <!-- TAINACAN: mostra o modal da biblioteca sweet alert para exclusao de uma colecao -->
                            <?php if ($is_moderator || get_post(get_the_ID())->post_author == get_current_user_id()): ?>
                                <li>
                                    <a onclick="delete_collection('<?= __('Delete Object', 'tainacan') ?>', '<?= __('Are you sure to remove the collection: ', 'tainacan') . get_the_title() ?>', '<?php echo get_the_ID() ?>', '<?= mktime() ?>', '<?php echo get_option('collection_root_id') ?>')" href="#" class="remove">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <!-- TAINACAN: mostra o modal para reportar abusao em um item, gerando assim um evento -->
                                <li>
                                    <a onclick="show_report_abuse('<?php echo get_the_ID() ?>')" href="#" class="report_abuse">
                                        <span class="glyphicon glyphicon-warning-sign"></span>
                                    </a>
                                </li>
                                <!-- TAINACAN:  modal padrao bootstrap para reportar abuso -->
                                <div class="modal fade" id="modal_delete_object<?php echo get_the_ID() ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">  
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-trash"></span>&nbsp;<?php _e('Report Abuse', 'tainacan'); ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <?php echo __('Describe why the collection: ', 'tainacan') . get_the_title() . __(' is abusive: ', 'tainacan'); ?>
                                                <textarea id="observation_delete_collection<?php echo get_the_ID() ?>" class="form-control"></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close', 'tainacan'); ?></button>
                                                <button onclick="report_abuse_collection('<?php _e('Delete Collection', 'tainacan') ?>', '<?php _e('Are you sure to remove the collection: ', 'tainacan') . get_the_title() ?>', '<?php echo get_the_ID() ?>', '<?= mktime() ?>', '<?php echo get_option('collection_root_id') ?>')" type="button" class="btn btn-primary"><?php echo __('Delete', 'tainacan'); ?></button>
                                            </div>
                                            </form>  
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </li>
        <?php
//        if ($countLine == $collection_data['collection_metas']['socialdb_collection_columns']) {
//            echo "</div> <!-- TAINACAN: apeanas um separador entre os objetos> <hr--><div class=\"row\">";
//            $countLine = 0;
//        }
        ?>
    <?php endwhile; ?> 
    <!--/div-->
    <!--/div--> 
    <!--/div -->
<?php else: ?> 
    <!-- TAINACAN: se a pesquisa nao encontrou nenhum item --> 
    <div id="items_not_found" class="alert alert-danger">
        <span class="glyphicon glyphicon-warning-sign"></span>&nbsp;<?php _e('No objects found!', 'tainacan'); ?>
    </div>
    <!-- TAINACAN: se a colecao estiver vazia eh mostrado --> 
    <div id="collection_empty" style="display:none" >
        <?php if (get_option('collection_root_id') != $collection_id): ?>
            <div class="jumbotron">
                <h2 style="text-align: center;"><?php _e('This collection is empty, create the first item!', 'tainacan') ?></h2>
                <p style="text-align: center;"><a onclick="show_form_item()" class="btn btn-primary btn-lg" href="#" role="button"><span class="glyphicon glyphicon-plus"></span>&nbsp;<?php _e('Click here to add a new item', 'tainacan') ?></a>
                </p>
            </div>
        <?php else: ?>
            <div class="jumbotron">
                <h2 style="text-align: center;"><?php _e('This repository is empty, create the first collection!', 'tainacan') ?></h2>
                <p style="text-align: center;"><a onclick="showModalCreateCollection()" class="btn btn-primary btn-lg" href="#" role="button"><span class="glyphicon glyphicon-plus"></span>&nbsp;<?php _e('Click here to add a new collection', 'tainacan') ?></a>
                </p>
            </div>
        <?php endif; ?>
    </div>
<?php
endif;

$numberItems = ceil($loop->found_posts / 10);
if ($loop->found_posts > 10):
    ?>
    <!-- TAINACAN: div com a paginacao da listagem --> 
    <center>
        <div id="center_pagination" class="col-md-12" style="margin-top: 20px;margin-bottom: 10px; height: 40px;width: 100%;margin-left: auto ;margin-right: auto ;">  
            <input type="hidden" id="number_pages" name="number_pages" value="<?= $numberItems; ?>">
            <div id="teste" class="pagination_items" style="">
                <a href="#" class="btn btn-default btn-sm first" data-action="first"><span class="glyphicon glyphicon-backward"></span><!--&laquo;--></a>
                <a href="#" class="btn btn-default btn-sm previous" data-action="previous"><span class="glyphicon glyphicon-step-backward"></span><!--&lsaquo;--></a>
                <input type="text"  style="width: 90px;" readonly="readonly"  data-current-page="<?php if (isset($pagid)) echo $pagid; ?>" data-max-page="0" />
                <a href="#" class="btn btn-default btn-sm next" data-action="next"><span class="glyphicon glyphicon-step-forward"></span><!--&rsaquo;--></a>
                <a href="#" class="btn btn-default btn-sm last" data-action="last"><span class="glyphicon glyphicon-forward"></span><!--   &raquo; --></a>                                       
            </div> 
        </div>  
    </center>
<?php endif; ?>


