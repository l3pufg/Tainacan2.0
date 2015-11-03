<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
get_header();
$options = get_option('socialdb_theme_options');
?>
<!-- TAINACAN: hiddeNs responsaveis em realizar acoes do repositorio -->
<input type="hidden" id="src" name="src" value="<?php echo get_template_directory_uri() ?>">
<input type="hidden" id="repository_main_page" name="repository_main_page" value="true">
<input type="hidden" id="info_messages" name="info_messages" value="<?php
if (isset($_GET['info_messages'])) {
    echo $_GET['info_messages'];
}
?>">
<input type="hidden" id="object_page" name="object_page" value="<?php
if (isset($_GET['item'])) {
    echo trim($_GET['item']);
}
?>">
<input type="hidden" id="socialdb_fb_api_id" name="socialdb_fb_api_id" value="<?php echo $options['socialdb_fb_api_id']; ?>">
<input type="hidden" id="socialdb_embed_api_id" name="socialdb_embed_api_id" value="<?php echo $options['socialdb_embed_api_id']; ?>">
<input type="hidden" id="collection_id" name="collection_id" value="<?php echo get_option('collection_root_id'); ?>">
<!-- TAINACAN: classe pura jumbotron do bootstrap, so textos que foram alterados -->
<center>
    <div id="main_part" class="home">
        <div class="row container-fluid">
            <div id="searchBoxIndex" class="col-md-3 col-sm-12 center">
                <form id="formSearchCollections" role="search">
                    <div class="input-group search-collection search-home">
                        <input type="text" class="form-control" name="search_collections" id="search_collections" onfocus="changeBoxWidth(this)" placeholder="<?php _e('Find', 'tainacan') ?>"/>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                </form>
                <a onclick="showAdvancedSearch('<?php echo get_template_directory_uri() ?>');" href="#" class="col-md-12 adv_search">
                    <span class="white"><?php _e('Advanced search', 'tainacan') ?></span>
                    <span class="glyphicon glyphicon-triangle-bottom white"></span>
                </a>
            </div>
        </div>
    </div>
</center>

</header>
<!--center>
   <div id="main_part" class="jumbotron">
       <h1>Tainacan</h1>
       <p><?= __('Welcome') ?></p>
       <input type="hidden" id="src" name="src" value="<?php echo get_template_directory_uri() ?>">
       <p><a class="btn btn-primary btn-lg" href="<?php echo get_permalink(get_option('collection_root_id')); ?>" role="button"><?php _e('Open Collection', 'tainacan') ?></a></p>
   </div>
</center>
<!-- TAINACAN: esta div (AJAX) recebe html E esta presente tanto na index quanto no single, pois algumas views da administracao sao carregadas aqui -->
<div id="configuration"></div>
<!-- TAINACAN: esta div (AJAX) mostra a listagem de colecoes mais populares e mais recentes  -->
<!--div class="container">
<div class="row">
   <div class="col-md-6">
<div class="row">
   <div class="col-md-4">
     <div class="panel panel-default">
       <div class="panel-body" style="padding:3px;">
         <img src="<?php echo get_template_directory_uri() ?>/libraries/images/colecao_thumb.svg" class="img-responsive">
       </div>
         <div class="panel-footer" style="padding:3px;">
         <span><small>
Coleção Campeão Brasileiro 2015 Timão é ns que voa bruxao</small></span>
       </div>
     </div>
   </div>
 </div>  </div>
 </div></div-->

<input type="hidden" id="max_collection_showed" name="max_collection_showed" value="6">
<input type="hidden" id="total_collections" name="total_collections" value="">
<input type="hidden" id="last_index" name="last_index" value="0">
<div id="display_view_main_page"></div>
<!-- TAINACAN: esta div possui um gif que e colocada como none quando a listagem de recents e populares  -->
<div id="loader_collections" style="margin-bottom: 150px;" ><center><img src="<?php echo get_template_directory_uri() . '/libraries/images/catalogo_loader_725.gif' ?>"><h3><?php _e('Loading Collections...', 'tainacan') ?></h3></center></div>
</body>
<?php
get_footer();
include_once 'views/theme_options/js/index_js.php';
?>