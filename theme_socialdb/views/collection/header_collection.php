<?php
include_once ('../../../../../wp-config.php');
include_once ('../../../../../wp-load.php');
include_once ('../../../../../wp-includes/wp-db.php');
include_once ('js/header_js.php');
//$post = get_post($collection_id);
$options = get_option('socialdb_theme_options');
?>
<!-- TAINACAN: panel da colecao, background-color definido pelo o usuario -->
<!--div class="panel-heading" style="max-width: 100%;border-color: <?= $collection_metas['socialdb_collection_board_border_color'] ?>;color:<?= $collection_metas['socialdb_collection_board_font_color'] ?>;background-color: <?= $collection_metas['socialdb_collection_board_background_color'] ?>;"-->
<?php $url_image = wp_get_attachment_url(get_post_meta($collection_post->ID, 'socialdb_collection_cover_id', true)); ?>
<div class="panel-heading collection_header container-fluid" style="max-width: 100%;background-color: #6a6a6a;padding:0 20px; <?php if ($url_image) { ?> background-image: url(<?php echo $url_image; ?>); <?php } ?>">
    <div class="row">
        <!-- TAINACAN: container com o menu da colecao, link para eventos e a busca de items -->
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="row same-height">
                    <div class="col-md-3">
                        <div class="relative">
                            <?php if ((verify_collection_moderators($collection_post->ID, get_current_user_id()) || current_user_can('manage_options')) && get_post_type($collection_post->ID) == 'socialdb_collection'): ?>
                                <div onclick="showCollectionConfiguration_editImages('<?php echo get_template_directory_uri() ?>', '1');" class="avatar-edit">
                                    <span class="glyphicon glyphicon-picture show-edit" ></span>
                                    <span><?php _e('Change image', 'tainacan'); ?></span>
                                </div>
                            <?php endif; ?>
                            <a href="<?php echo get_the_permalink($collection_post->ID); ?>">
                                <?php
                                $url_image = wp_get_attachment_url(get_post_thumbnail_id($collection_post->ID));
                                if (get_the_post_thumbnail($collection_post->ID, 'thumbnail') && $url_image) {
                                    //echo get_the_post_thumbnail($collection_post->ID, $thumbSize);
                                    ?><img width="150" height="150" itemprop="image" class="attachment-thumbnail wp-post-image img-responsive" src="<?php echo $url_image; ?>" /><?php
                                } else {
                                    ?>
                                    <img src="<?php echo get_template_directory_uri() ?>/libraries/images/colecao_thumb.svg" class="attachment-thumbnail wp-post-image img-responsive">
                                <?php } ?>
                            </a>
                        </div>
                    </div>
                    <!-- TAINACAN: div com o titulo e a descricao -->
                    <div style="font-size: 24px;" class="col-md-9 titulo-colecao relative">
                        <?php if (isset($mycollections) && $mycollections == 'true') { ?>
                            <span class="bottom"><b class="white"><?php _e('My Collections', 'tainacan'); ?></b><br></span>
                        <?php } else { ?>
                            <span class="bottom">
                                <b class="white"><?php echo $collection_post->post_title; ?></b><br>
                                <?php echo strip_tags($collection_post->post_content); ?>
                            </span>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="padding:10px 0;text-align:right;">
                <input type="hidden" id="socialdb_permalink_collection" name="socialdb_permalink_collection" value="<?php echo get_the_permalink($collection_post->ID); ?>" />
                <?php if ((verify_collection_moderators($collection_post->ID, get_current_user_id()) || current_user_can('manage_options')) && get_post_type($collection_post->ID) == 'socialdb_collection'): ?>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" >    
                        <div class="fab">  
                            <img src="<?php echo get_template_directory_uri() ?>/libraries/images/configuracao.svg" alt="" class="img-responsive">
                        </div> 
                    </a>   
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li><a onclick="showCollectionConfiguration('<?php echo get_template_directory_uri() ?>');" href="#"><span class="glyphicon glyphicon-wrench"></span>&nbsp;<?php _e('Configuration', 'tainacan'); ?></a></li>
                        <li><a onclick="showDesignConfiguration('<?php echo get_template_directory_uri() ?>');" href="#"><span class="glyphicon glyphicon-picture"></span>&nbsp;<?php _e('Design', 'tainacan'); ?></a></li>
                        <?php
                        if (get_option('collection_root_id') == $collection_post->ID) {
                            ?>
                            <!--li class="divider"></li>
                            <li><a onclick="showAPIConfiguration('< ?php echo get_template_directory_uri() ?>');" href="#"><span class="glyphicon glyphicon-lock"></span>&nbsp;< ?php _e('API Keys Configuration'); ?></a></li-->
                            <?php
                        } else {
                            ?>
                            <li><a onclick="showPropertiesConfiguration('<?php echo get_template_directory_uri() ?>');" href="#"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;<?php _e('Metadata', 'tainacan'); ?></a></li>
                            <li><a onclick="showRankingConfiguration('<?php echo get_template_directory_uri() ?>');" href="#"><span class="glyphicon glyphicon-star"></span>&nbsp;<?php _e('Rankings', 'tainacan'); ?></a></li>
                            <li><a onclick="showSearchConfiguration('<?php echo get_template_directory_uri() ?>');" href="#"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;<?php _e('Search', 'tainacan'); ?></a></li>
                            <li class="divider"></li>
                            <!--li><a onclick="showUsersConfiguration('<?php echo get_template_directory_uri() ?>');" href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;<?php _e('Users', 'tainacan'); ?></a></li-->
                            <li><a onclick="showCategoriesConfiguration('<?php echo get_template_directory_uri() ?>');" href="#"><span class="glyphicon glyphicon-filter"></span>&nbsp;<?php _e('Categories', 'tainacan'); ?></a></li>
                            <li><a onclick="showSocialConfiguration('<?php echo get_template_directory_uri() ?>');" href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;<?php _e('Social', 'tainacan'); ?></a></li>
                            <li><a onclick="showLicensesConfiguration('<?php echo get_template_directory_uri() ?>');" href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;<?php _e('Licenses', 'tainacan'); ?></a></li>
                            <li><a onclick="showImport('<?php echo get_template_directory_uri() ?>');" href="#"><span class="glyphicon glyphicon-open"></span>&nbsp;<?php _e('Import', 'tainacan'); ?></a></li>
                            <li><a onclick="showExport('<?php echo get_template_directory_uri() ?>');" href="#"><span class="glyphicon glyphicon-save"></span>&nbsp;<?php _e('Export', 'tainacan'); ?></a></li>
                            <li class="divider"></li>
                            <li style="background-color: #e4b9b9;"><a onclick="delete_collection_redirect('<?php _e('Delete Collection', 'tainacan') ?>', '<?php echo __('Are you sure to remove the collection: ', 'tainacan') . $collection_post->post_title ?>', '<?php echo $collection_post->ID ?>', '<?= mktime() ?>', '<?php echo get_option('collection_root_id') ?>')" href="#"><span class="glyphicon glyphicon-trash"></span>&nbsp;<?php _e('Delete', 'tainacan'); ?></a></li>
                            <?php
                        }
                        if (get_option('collection_root_id') != $collection_post->ID) {
                            ?>
                            <li class="divider"></li>
                            <li><a onclick="showEvents('<?php echo get_template_directory_uri() ?>');" style="color:<?php echo $collection_metas['socialdb_collection_board_link_color']; ?>" href="#"><span class="glyphicon glyphicon-flash"></span> <?php _e('Events', 'tainacan'); ?>&nbsp;<span id="notification_events" style="background-color:red;color:white;font-size:13px;"></span></a></li>
                            <?php if (!verify_collection_moderators($collection_post->ID, get_current_user_id()) && !current_user_can('manage_options')): ?>
                                <li><a onclick="show_report_abuse_collection('<?php echo $collection_post->ID; ?>');" style="color:<?php echo $collection_metas['socialdb_collection_board_link_color']; ?>" href="#"><span class="glyphicon glyphicon-warning-sign"></span> <?php _e('Report Abuse', 'tainacan'); ?>&nbsp;</a></li>
                                <!-- modal exluir -->
                                <div class="modal fade" id="modal_delete_collection<?php echo $collection_post->ID; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content"> 
                                            <form>
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-trash"></span>&nbsp;<?php _e('Report Abuse', 'tainacan'); ?></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <?php echo __('Describe why the collection: ') . $collection_post->post_title . __(' is abusive: ', 'tainacan'); ?>
                                                    <textarea id="observation_delete_collection<?php echo $collection_post->ID ?>" class="form-control"></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close', 'tainacan'); ?></button>
                                                    <button onclick="report_abuse_collection('<?php _e('Delete Collection', 'tainacan') ?>', '<?php _e('Are you sure to remove the collection: ', 'tainacan') . $collection_post->post_title ?>', '<?php echo $collection_post->ID ?>', '<?php echo mktime() ?>', '<?php echo get_option('collection_root_id') ?>')" type="button" class="btn btn-primary"><?php echo __('Delete', 'tainacan'); ?></button>
                                                </div>
                                            </form>  
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php
                        }
                        ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="col-md-12 bg-edit">
                        <?php if ((verify_collection_moderators($collection_post->ID, get_current_user_id()) || current_user_can('manage_options')) && get_post_type($collection_post->ID) == 'socialdb_collection'): ?>
                            <button onclick="showCollectionConfiguration_editImages('<?php echo get_template_directory_uri() ?>', '2');" class="btn btn-default">
                                <span class="glyphicon glyphicon-picture" ></span><span><?php _e('Change Cover', 'tainacan'); ?></span>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6 pull-right" style="text-align:right;padding:10px 0;"> <!-- compartilhamentos -->
                    <!-- ******************** TAINACAN: compartilhar colecao (titutlo,imagem e descricao) no FACEBOOK ******************** -->
                    <a target="_blank" href="http://www.facebook.com/sharer/sharer.php?s=100&amp;p[url]=<?php echo get_the_permalink($collection_post->ID); ?>&amp;p[images][0]=<?php echo wp_get_attachment_url(get_post_thumbnail_id($collection_post->ID)); ?>&amp;p[title]=<?php echo htmlentities($collection_post->post_title); ?>&amp;p[summary]=<?php echo strip_tags($collection_post->post_content); ?>">
                        <div class="fab"><span data-icon="&#xe021;"></span></div>
                    </a>
                    <!-- ******************** TAINACAN: compartilhar colecao (titulo,imagem) no GOOGLE PLUS ******************** -->
                    <a target="_blank" href="https://plus.google.com/share?url=<?php echo get_the_permalink($collection_post->ID); ?>">
                        <div class="fab"><span data-icon="&#xe01b;"></span></div>
                    </a>
                    <!-- ************************ TAINACAN: compartilhar colecao  no TWITTER ******************** -->
                    <a target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo get_the_permalink($collection_post->ID); ?>&amp;text=<?php echo htmlentities($collection_post->post_title); ?>&amp;via=socialdb">
                        <div class="fab"><span data-icon="&#xe005;"></span></div>
                    </a>
                    <!-- ******************** TAINACAN: RSS da colecao com seus metadados ******************** -->
                    <?php if (get_option('collection_root_id') != $collection_post->ID): ?>
                        <a target="_blank" href="<?php echo site_url() . '/feed_collection/' . $collection_post->post_name ?>">
                            <div class="fab"><span data-icon="&#xe00c;"></span></div>
                        </a>
                    <?php endif; ?>
                    <!-- ******************** TAINACAN: exportar CSV os items da colecao que estao filtrados ******************** -->
                    <?php if (get_option('collection_root_id') != $collection_post->ID) { ?>
                        <a href="#" onclick="export_selected_objects()">
                            <div class="fab"><small><h6><b>csv</b></h6></small></div>
                        </a>
                    <?php } ?>
                    <!-- ******************** TAINACAN: IFRAME URL ******************** -->
                    <a href="#" id="iframebutton" data-container="body" data-toggle="popover" data-placement="left" data-title="URL Iframe" data-content="" data-original-title="" title="">
                        <div class="fab"><small><h6><b><></b></h6></small></div>
                    </a>
                    <!--button style="float:right;margin-left:5px;" id="iframebutton" type="button" class="btn btn-default btn-sm" data-container="body" data-toggle="popover" data-placement="left" data-title="URL Iframe" data-content="">
                        <span class="glyphicon glyphicon-link"></span>
                    </button-->
                </div>
            </div>
        </div>                
    </div>
    <!-- TAINACAN: div com o input para pesquisa de items na colecao -->
    <!--div class="col-md-10">
        <div class="input-group">
            <div class="input-group-btn">
                <button onclick="clear_list()"id="clear" class="btn-xs btn-primary btn" style="margin-right:10px;margin-bottom:5px"><?php _e('Clear', 'tainacan') ?></button>
            </div>
            <input onkeyup="set_value(this)" onkeydown="if (event.keyCode === 13)
                        document.getElementById('search_main').click();
                   " type="text" style="font-size: 13px; " class="form-control input-medium placeholder" id="search_objects" placeholder="<?php _e('Search Objects', 'tainacan') ?>">
            <span class="input-group-btn">
                <button id="search_main" type="button" onclick="search_objects('#search_objects')"  class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div--> 
</div>    